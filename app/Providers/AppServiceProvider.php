<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\Task;
use App\Policies\TaskPolicy;
use App\Models\Assessment ; 
use \App\Policies\AssessmentPolicy ; 

class AppServiceProvider extends ServiceProvider
{

    // Protected TaskPolicy
    protected $policies = [
        Task::class => TaskPolicy::class,
        Assessment::class => AssessmentPolicy::class,
    ];
    
    
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }



}
