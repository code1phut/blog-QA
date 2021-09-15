<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'ApiTagRepository',
        'ApiCategoryRepository',
        'ApiUserRepository',
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();
    }

    private function registerRepositories() {
        foreach ($this->repositories as $repository) {
            $this->app->bindIf(
                'App\\Repositories\\Interfaces\\I'.$repository,
                'App\\Repositories\\Eloquents\\'.$repository,
            );
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
