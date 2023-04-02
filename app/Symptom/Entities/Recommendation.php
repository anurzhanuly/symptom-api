<?php
declare(strict_types=1);
namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $table = 'recommendations';

    protected $fillable = ['name', 'tests', 'conditions'];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->setAttribute('name', $name);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getTests(): ?array
    {
        return json_decode($this->getAttribute('tests'), true);
    }

    public function setTests(array $tests)
    {
        $this->setAttribute('tests', json_encode($tests));
    }

    public function getConditions(): ?array
    {
        return json_decode($this->getAttribute('conditions'), true);
    }

    public function setConditions(array $conditions)
    {
        $this->setAttribute('conditions', json_encode($conditions));
    }
}
