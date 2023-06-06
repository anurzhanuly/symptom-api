<?php

namespace App\Symptom\Utils\Clients\Translator;

interface TranslatorInterface
{
    public function translate(string $text, string $fromLanguage = 'en', string $targetLanguage = 'ru'): string;
}
