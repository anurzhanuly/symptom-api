<?php
declare(strict_types=0);
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Result as ResultEntity;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class Result extends TransformerAbstract
{
    public string $type = 'result';

    protected array $defaultIncludes = ['patient', 'doctor'];

    protected DoctorForClinic $doctorForClinicTransformer;

    protected PatientList $patientTransformer;

    public function __construct(DoctorForClinic $doctorForClinicTransformer, PatientList $patientTransformer)
    {
        $this->doctorForClinicTransformer = $doctorForClinicTransformer;
        $this->patientTransformer         = $patientTransformer;
    }

    public function transform(ResultEntity $result): array
    {
        return [
            'id'       => $result->getId(),
            'diagnose' => $result->getDiagnose(),
        ];
    }

    public function includeDoctor(ResultEntity $result): ?Item
    {
        return new Item($result->getDoctor(), $this->doctorForClinicTransformer, $this->doctorForClinicTransformer->type);
    }

    public function includePatient(ResultEntity $result): ?item
    {
        return new Item($result->getPatient(), $this->patientTransformer, $this->patientTransformer->type);
    }
}
