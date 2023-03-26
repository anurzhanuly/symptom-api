<?php
declare(strict_types=1);
namespace App\Symptom\Services\Settings;

use App\Symptom\Entities\Setting;
use App\Symptom\Repositories\SettingRepository;

class Create
{
    private SettingRepository $settingsRepository;

    public function __construct(SettingRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function execute(array $attributes): Setting
    {
        return $this->settingsRepository->create($attributes);
    }
}
