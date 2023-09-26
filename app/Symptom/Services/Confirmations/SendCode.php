<?php
namespace App\Symptom\Services\Confirmations;

use App\Symptom\Repositories\ConfirmationRepository;
use App\Symptom\Utils\Clients\Sms\SmsInterface;

class SendCode
{
    protected SmsInterface $smsClient;

    protected ConfirmationRepository $confirmationRepository;

    public function __construct(
        SmsInterface $smsClient,
        ConfirmationRepository $confirmationRepository
    ) {
        $this->smsClient              = $smsClient;
        $this->confirmationRepository = $confirmationRepository;
    }

    public function execute(int $user_id, string $phone): bool
    {
        $code = rand(100000, 999999);

        try {
            $result = $this->smsClient->sendOne($phone, sprintf(
                '%s %s',
                'Код подтверждения symptom.kz ',
                $code
            ));

            if ($result) {
                $this->confirmationRepository->create($user_id, $phone, $code);

                return true;
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }

        return false;
    }
}
