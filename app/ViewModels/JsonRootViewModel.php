<?php
declare(strict_types=1);

namespace App\ViewModels;

use App\ViewModels\Base\ViewModel;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class JsonRootViewModel Jsonレスポンス用のViewModelクラス
 * @package App\ViewModels
 */
class JsonRootViewModel extends Base\ViewModel
{
    private array|ViewModel $data;

    public function __construct(array|ViewModel $data)
    {
        $this->data = $data;
    }

    /**
     * @param array|ViewModel $data
     * @return JsonRootViewModel
     */
    #[Pure]
    public static function make(array|ViewModel $data): self
    {
        return new self($data);
    }

    /**
     * @inheritDoc
     */
    public function toMap(): array
    {
        return $this->data instanceof ViewModel
            ? $this->data->toArray()
            : $this->data;
    }
}
