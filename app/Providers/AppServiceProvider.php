<?php

namespace App\Providers;

use App\Symptom\Utils\Clients\chatGPT\Client;
use App\Symptom\Utils\Clients\SymptomAI\SymptomAI;
use App\Symptom\Utils\Clients\SymptomAI\SymptomAiInterface;
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
            $symptomAiService = new Client();
            return new SymptomAI($symptomAiService);
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
