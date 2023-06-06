<?php

namespace App\Providers;

use App\Symptom\Utils\Clients\chatGPT\Client as ChatGptClient;
use App\Symptom\Utils\Clients\chatGPT\ClientInterface as ChatGptInterface;
use App\Symptom\Utils\Clients\SymptomAI\SymptomAI;
use App\Symptom\Utils\Clients\SymptomAI\SymptomAiInterface;
use App\Symptom\Utils\Clients\Translator\Translator;
use App\Symptom\Utils\Clients\Translator\TranslatorInterface;
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
            $symptomAiService = $this->app->make(ChatGptInterface::class);
            $translatorService = $this->app->make(TranslatorInterface::class);

            return new SymptomAI($symptomAiService, $translatorService);
        });

        $this->app->bind(ChatGptInterface::class, function () {
            return new ChatGptClient();
        });

        $this->app->bind(TranslatorInterface::class, function () {
            return new Translator();
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
