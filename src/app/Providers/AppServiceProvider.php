<?php

namespace App\Providers;

use App\Domain\ReceiptInfo\Contracts\ReceiptInfoRepositoryInterface;
use App\Domain\ReceiptInfo\Repositories\ReceiptInfoRepository;
use App\Domain\UserInfo\Contracts\UserInfoRepositoryInterface;
use App\Domain\UserInfo\Repositories\UserInfoRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /** 
         * QUESTION: What is this doing???? 
         * Is it required to register services this way?
         * What are providers and what do they do in Laravel?
         */
        $this->app->bind(UserInfoRepositoryInterface::class, UserInfoRepository::class);
        $this->app->bind(ReceiptInfoRepositoryInterface::class, ReceiptInfoRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
