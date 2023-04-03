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

    public function getByName(string $name): Setting
    {
        return Setting::where('name', $name)->first();
    }

    public function getValueByName(string $name): array
    {
        return (Setting::where('name', $name)->first())->getValue();
    }

    public function create(array $attributes): Setting
    {
        return Setting::create($attributes);
    }

    public function update($id, array $attributes): bool
    {
        $setting = Setting::find($id);

        if (!$setting) {
            return false;
        }

        $setting->fill($attributes);
        $setting->save();

        return $setting;
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
