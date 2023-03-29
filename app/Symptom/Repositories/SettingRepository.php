<?php
declare(strict_types=1);
namespace App\Symptom\Repositories;

use App\Symptom\Entities\Setting;

class SettingRepository
{
    public function getSettings(): array
    {
        return Setting::all()->all();
    }

    public function getByName(string $name): ?Setting
    {
        return Setting::where('name', $name)->first() ?? null;
    }

    public function getValueByName(string $name): array
    {
        return (Setting::where('name', $name)->first())->getValue();
    }

    public function create(array $attributes): Setting
    {
        return Setting::create($attributes);
    }

    public function update(string $name, array $value): bool
    {
        $setting = $this->getByName($name);

        if (!$setting) {
            throw new \Exception('Не удалось найти настройку по названию');
        }

        $setting->setValue($value);

        return $setting->save();
    }

    public function delete($id): bool
    {
        $setting = Setting::find($id);

        if (!$setting) {
            return false;
        }

        $setting->delete();

        return true;
    }
}
