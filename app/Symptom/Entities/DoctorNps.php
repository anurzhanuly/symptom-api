<?php
namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Model;

class DoctorNps extends Model
{
    protected $table = 'doctor_nps';

    protected $fillable = ['name', 'workplace', 'phone', 'is_checked'];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWorkplace(): string
    {
        return $this->workplace;
    }

    public function setWorkplace(string $workplace): self
    {
        $this->workplace = $workplace;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function isChecked(): bool
    {
        return $this->is_checked;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
