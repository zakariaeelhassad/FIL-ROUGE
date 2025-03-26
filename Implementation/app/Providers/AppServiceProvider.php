<?php

namespace App\Providers;

use App\Repositories\interface\RepositoryInterface;
use App\Repositories\PostRepository;
use App\Services\ExperienceService;
use App\Services\PostService;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, PostRepository::class);
        
        $this->app->bind(PostService::class, function ($app) {
            return new PostService($app->make(RepositoryInterface::class));
        });

        $this->app->bind(ExperienceService::class, function ($app) {
            return new ExperienceService($app->make(RepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class); } }