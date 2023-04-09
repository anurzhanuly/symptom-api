<?php

namespace App\Symptom\Repositories;

use App\Symptom\Entities\Recommendation;

class RecommendationsRepository
{
    /**
     * @return array<Recommendation>
     */
    public function getAll(): array
    {
        return Recommendation::all()->all();
    }

    public function getByName(string $name): ?Recommendation
    {
        return Recommendation::where('name', $name)->first();
    }

    public function getOneById(int $id): Recommendation
    {
        return Recommendation::find($id);
    }

    public function create(array $data): Recommendation
    {
        return Recommendation::create($data);
    }

    public function update(array $data): Recommendation
    {
        return Recommendation::updateOrCreate(['id' => $data['id']], $data);
    }
}
