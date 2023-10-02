<?php
namespace App\Symptom\Repositories;

use App\Symptom\Entities\ConfirmCode;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ConfirmationRepository
{
    public function create(int $user_id, string $phone, int $code): ConfirmCode
    {
        return ConfirmCode::create(
            [
                'phone'             => $phone,
                'confirmation_code' => $code,
                'user_id'           => $user_id,
            ]
        );
    }

    public function update(int $confirmation_id, array $data): ConfirmCode
    {
        $confirmation = ConfirmCode::find($confirmation_id);

        if (!$confirmation instanceof ConfirmCode) {
            throw  new ResourceNotFoundException('Запись не найдена', compact('confirmation_id', 'data'));
        }

        $confirmation->update($data);

        return $confirmation;
    }

    public function getOneByUserIdAndCode(int $user_id, int $code): ?ConfirmCode
    {
        return ConfirmCode::query()
            ->where('user_id', '=', $user_id)
            ->where('confirmation_code', '=', $code)
            ->get()
            ->first();
    }
}
