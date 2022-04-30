<?php
declare(strict_types=1);

namespace App\Modules\Paginate;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

/**
 * Class ApiPaginate
 * @package App\Modules\Paginate
 */
class ApiPaginate
{
    /**
     * @var int
     */
    private int $currentPage;

    /**
     * @var int
     */
    private int $totalCount;

    /**
     * @var EloquentCollection
     */
    private Collection $items;

    /**
     * @var int
     */
    private int $totalPage;

    /**
     * ApiPaginate constructor.
     * @param int $currentPage
     * @param int $totalCount
     * @param EloquentCollection $items
     * @param int|null $paginateCount
     */
    public function __construct(
        int $currentPage,
        int $totalCount,
        Collection $items,
        int $paginateCount = null
    )
    {
        $this->currentPage = $currentPage;
        $this->totalCount = $totalCount;
        $this->items = $items;
        $this->totalPage = $this->setTotalPage($paginateCount);
        $this->throwModelNotFoundException();
    }

    /**
     * トータルページ数
     * @param int|null $paginateCount
     * @return int
     */
    private function setTotalPage(?int $paginateCount): int
    {
        $totalPage = ceil($this->totalCount / $paginateCount ?? 20);
        return $totalPage > 0
            ? (int)$totalPage
            : 1;
    }

    /**
     * 値が不正な場合はエラーを吐きます
     * @throws ModelNotFoundException
     */
    private function throwModelNotFoundException(): void
    {
        if ($this->totalPage < $this->currentPage) {
            throw new ModelNotFoundException();
        }
        if ($this->currentPage <= 0) {
            throw new ModelNotFoundException();
        }
    }

    /**
     * @param string[]|array $load
     */
    public function load(array $load): void
    {
        $this->items->load($load);
    }

    /**
     * 全ページ数
     * @return int
     */
    public function getTotalPage(): int
    {
        return $this->totalPage;
    }

    /**
     * 最後のページか
     * @return bool true:最後のページ false:ではない
     */
    public function isLastPage(): bool
    {
        return $this->totalPage === $this->currentPage;
    }

    /**
     * @return EloquentCollection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * 現在のページを取得する
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * 総件数
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }
}
