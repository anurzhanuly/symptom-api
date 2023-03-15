<?php

namespace App\Providers;

use App\Symptom\Utils\SymptomAI\SymptomAiInterface;
use App\Symptom\Utils\SymptomAI\SymptomAI;
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
        $this->app->bind(SymptomAiInterface::class, function () {
            return new SymptomAI();
        });
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
