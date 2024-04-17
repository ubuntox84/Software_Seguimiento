<?php

namespace App\Providers;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Livewire\Component;
use Illuminate\Database\Eloquent\Model;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       
        setlocale(LC_TIME, 'es_ES.utf8');
        Carbon::setLocale('es');
        Component::macro('notify', function ($message) {
            $this->dispatchBrowserEvent('notify', $message);
        });
         
        Builder::macro('toCsv', function () {
            $results = $this->get();

            if ($results->count() < 1) return;

            $titles = implode(',', array_keys((array) $results->first()->getAttributes()));

            $values = $results->map(function ($result) {
                return implode(',', collect($result->getAttributes())->map(function ($thing) {
                    return '"'.$thing.'"';
                })->toArray());
            });

            $values->prepend($titles);

            return $values->implode("\n");
        });
    //     Model::preventLazyLoading();
    // Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
    //     Bugsnag::notifyError("N+1 Query detected", sprintf("N+1 Query detected in %s::%s", get_class($model), $relation));
    // });
    }
}
