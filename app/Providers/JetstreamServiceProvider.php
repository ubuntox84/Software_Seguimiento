<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Http\Livewire\UpdateProfileInformationForm;
use Laravel\Jetstream\Jetstream;
use Livewire\Livewire;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Jetstream::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
        $this->configureRoutes();
        Livewire::component('profile.update-profile-information-form', UpdateProfileInformationForm::class);
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
     protected function configureRoutes()
    {
        
            Route::group([
                'namespace' => 'Laravel\Jetstream\Http\Controllers',
                'domain' => config('jetstream.domain', null),
                'prefix' => config('jetstream.prefix', config('jetstream.path')),
            ], function () {
                $this->loadRoutesFrom(base_path('routes/jetstream.php'));
            });
        
    }
}
