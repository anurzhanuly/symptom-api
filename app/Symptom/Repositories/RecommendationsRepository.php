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
        $recomendation = new Recommendation();

        $recomendation
            ->setName($data['name'])
            ->setTests($data['tests'])
            ->setConditions($data['conditions'])
            ->save();

        return $recomendation;
    }

    public function update(int $id, array $data): Recommendation
    {
        Recommendation::find($id)->update($data);

        return Recommendation::find($id);
    }

    public function delete(int $id): bool
    {
        return Recommendation::where('id', '=', $id)->delete();
    }
}
