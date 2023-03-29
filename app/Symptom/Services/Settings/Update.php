<?php

namespace App\Symptom\Services\Settings;

use App\Symptom\Repositories\SettingRepository;

class Update
{
    private SettingRepository $settingsRepository;

    public function __construct(SettingRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * @throws \Exception
     */
    public function execute(string $name, array $value): bool
    {
        return $this->settingsRepository->update($name, $value);
    }
}
