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

    public function setName(string $name): self
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getTestsAsArray()
    {
        return json_decode($this->getAttribute('tests'), true);
    }

    public function getTests()
    {
        return json_decode($this->getAttribute('tests'));
    }

    public function setTests(array $tests): self
    {
        $this->setAttribute('tests', json_encode($tests, JSON_FORCE_OBJECT));

        return $this;
    }

    public function getConditions(): ?array
    {
        return json_decode($this->getAttribute('conditions'), true);
    }

    public function setConditions(array $conditions): self
    {
        $this->setAttribute('conditions', json_encode($conditions));

        return $this;
    }
}
