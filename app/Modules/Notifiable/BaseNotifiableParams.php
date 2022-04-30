<?php
declare(strict_types=1);

namespace App\Modules\Notifiable;

use App\Jobs\SendMailJob;

/**
 * Class BaseNotifiableParams SendMailJobを使用する場合のベースクラス
 * @package App\Modules\Notifiable
 */
abstract class BaseNotifiableParams
{
    use JobNotifiable;

    /**
     * @var string 送信先メールアドレス
     */
    protected string $email;

    /**
     * @var string 概要
     */
    protected string $description;

    /**
     * BaseNotifiableParams constructor.
     * @param string $email 送信先メールアドレス
     */
    public function __construct(string $email, string $description)
    {
        $this->email = $email;
        $this->description = $description;
    }

    /**
     * 開始のメッセージ
     * @return string
     */
    public function getStartMessage(): string
    {
        return "{$this->description}を開始します";
    }

    /**
     * 成功した場合のメッセージ
     * @return string
     */
    public function getSuccessMessage(): string
    {
        return "{$this->description}に成功しました";
    }

    /**
     * 失敗した場合のメッセージ
     * @return string
     */
    public function getErrorMessage(): string
    {
        return "{$this->description}に失敗しました";
    }

    /**
     * @return array
     */
    abstract public function toArray(): array;
}
