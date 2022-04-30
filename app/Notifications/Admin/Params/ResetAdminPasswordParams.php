<?php
declare(strict_types=1);

namespace App\Notifications\Admin\Params;

use App\Models\Admin;
use App\Modules\Notifiable\BaseNotifiableParams;

/**
 * Class ResetAdminPasswordParams
 * @package App\Notifications\Admin\Params
 */
class ResetAdminPasswordParams extends BaseNotifiableParams
{
    private Admin $admin;
    /**
     * ResetAdminPasswordParams constructor.
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        parent::__construct($admin->email, '管理ユーザーへのパスワードリセットメールの送信');
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->admin->id,
            'name' => $this->admin->name,
            'email' => $this->admin->email,
        ];
    }
}
