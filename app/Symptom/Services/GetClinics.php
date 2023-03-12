<?php

class GetClinics
{
    protected ClinicRepository $clinicRepository;

    public function __construct(ClinicRepository $clinicRepository)
    {
        $this->clinicRepository = $clinicRepository;
    }

    public function execute(): array
    {
        return $this->clinicRepository->getClinics();
    }
}
