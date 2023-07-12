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
        $recommendation = new Recommendation();

        $recommendation
            ->setName($data['name'])
            ->setTests($data['tests'])
            ->setConditions($data['conditions'])
            ->save();

        return $recommendation;
    }

    public function update(int $id, array $data): Recommendation
    {
        $recommendation = Recommendation::find($id);

        $recommendation
            ->setName($data['name'])
            ->setTests($data['tests'])
            ->setConditions($data['conditions'])
            ->save();

        return $recommendation;
    }

    public function delete(int $id): bool
    {
        return Recommendation::where('id', '=', $id)->delete();
    }
}
