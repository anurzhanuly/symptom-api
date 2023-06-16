<?php

namespace App\Symptom\Utils\Clients\Translator;

use Statickidz\GoogleTranslate;

class Translator implements TranslatorInterface
{
    public const ENGLISH_LANGUAGE = 'en';

    public const RUSSIAN_LANGUAGE = 'ru';

    private GoogleTranslate $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    public function translate(string $text, string $fromLanguage = 'en', string $targetLanguage = 'ru'): string
    {
        return $this->translator->translate($fromLanguage, $targetLanguage, $text);
    }
}
