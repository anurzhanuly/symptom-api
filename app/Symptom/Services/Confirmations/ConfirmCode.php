<?php
namespace App\Symptom\Services\Confirmations;

use App\Symptom\Repositories\ConfirmationRepository;
use App\Symptom\Entities\ConfirmCode as ConfirmCodeEntity;

class ConfirmCode
{
    protected ConfirmationRepository $confirmationRepository;

    public function __construct(
        ConfirmationRepository $confirmationRepository
    )
    {
        $this->confirmationRepository = $confirmationRepository;
    }

    public function execute(int $user_id, int $code): bool
    {
        try {
            $confirmation = $this->confirmationRepository->getOneByUserIdAndCode($user_id, $code);

            if ($confirmation instanceof ConfirmCodeEntity) {
                $this->confirmationRepository->update($confirmation->getId(), ['is_confirmed' => true]);
            }

            return true;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}
