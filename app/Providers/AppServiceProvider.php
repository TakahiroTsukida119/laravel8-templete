<?php

namespace App\Providers;

use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryImpl;
use App\Services\Frontend\Auth\AuthService;
use App\Services\Frontend\Auth\AuthServiceImpl;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * DIに登録するクラスはbindingsかsingletonsのどちらか一方に登録してください
     * singletonは１度作ったインスタンスが使いまわされる(キャッシングされる）ため、基本的にsingletonを利用するほうがパフォーマンス的に良いです
     * ただ、下記の記事のような特殊な用途での使用の際にはbindingを利用してみてください
     * https://qiita.com/dublog/items/3314ca25a90e76f63b17#4-%E3%82%B7%E3%83%B3%E3%82%B0%E3%83%AB%E3%83%88%E3%83%B3%E3%81%AE%E8%90%BD%E3%81%A8%E3%81%97%E7%A9%B4
     */
    public array $singletons = [
        // Services/Frontend
        AuthService::class => AuthServiceImpl::class,

        // Services/Backend

        // Repositories
        AdminRepository::class => AdminRepositoryImpl::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Default Datetime class
        Date::use(CarbonImmutable::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Model::preventLazyLoading(app()->isLocal());
    }
}
