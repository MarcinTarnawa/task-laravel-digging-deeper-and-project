<?php

namespace App\Providers;

use App\Models\CustomerData;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
         // bramki dostępu do autoryzacji
        Gate::define('update', function (User $user, CustomerData $customer_data) {
            return $user->id === $customer_data->user_id;
        });
        
        Gate::define('destroy', function (User $user, CustomerData $customer_data) {
            return $user->id === $customer_data->user_id;
        });
    }
}
