<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Article' => 'App\Policies\ArticlePolicy',
        'App\Message' => 'App\Policies\MessagePolicy',
        'App\Song' => 'App\Policies\SongPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Page' => 'App\Policies\PagePolicy',
        'App\Serie' => 'App\Policies\SeriesPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addYear(21));
        Passport::refreshTokensExpireIn(Carbon::now()->addYear(30));
    }

}