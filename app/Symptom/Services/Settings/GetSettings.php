<?php
declare(strict_types=1);
namespace App\Symptom\Services\Settings;

use App\Symptom\Repositories\SettingRepository;

final class GetSettings
{
    private SettingRepository $settingsRepository;

    public function __construct(SettingRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function execute(): array
    {
        return $this->settingsRepository->getSettings();
    }
}
