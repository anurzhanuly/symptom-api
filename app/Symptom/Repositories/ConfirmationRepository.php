<?php
namespace App\Symptom\Repositories;

use App\Symptom\Entities\ConfirmCode;
use Carbon\Carbon;
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

    public function getUserLimits(int $user_id): array
    {
        $limits     = [];
        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay   = Carbon::now()->endOfDay();
        $codes      = ConfirmCode::query()
            ->where('user_id', '=', $user_id)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->orderBy('created_at', 'desc')
            ->get()
            ->all();

        if (empty($codes)) {
            return $limits;
        }

        if (count($codes) >= ConfirmCode::DAY_LIMIT) {
            $limits[] = ConfirmCode::DAY_LIMIT_MESSAGE;
        }

        $lastCode = Carbon::create($codes[0]->created_at)->timestamp;

        if (Carbon::now()->timestamp - $lastCode <= 60) {
            $limits[] = ConfirmCode::MINUTE_LIMIT_MESSAGE;
        }

        return $limits;
    }
}
