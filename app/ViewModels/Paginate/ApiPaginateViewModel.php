<?php
declare(strict_types=1);

namespace App\ViewModels\Frontend\Paginate;

use App\Modules\Paginate\ApiPaginate;
use App\ViewModels\Base\ViewModel;

/**
 * ページネーション
 * Class ApiPaginateViewModel
 * @package App\ViewModels\Frontend\Paginate
 */
class ApiPaginateViewModel extends ViewModel
{
    private ApiPaginate $paginate;

    /**
     * ApiPaginateViewModel constructor.
     */
    public function __construct(ApiPaginate $paginate)
    {
        $this->paginate = $paginate;
    }

    /**
     * @inheritDoc
     */
    public function toMap(): array
    {
        return [
            'current_page' => $this->paginate->getCurrentPage(),
            'total_page' => $this->paginate->getTotalPage(),
            'total_count' => $this->paginate->getTotalCount(),
        ];
    }
}
