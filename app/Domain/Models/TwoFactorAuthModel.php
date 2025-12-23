<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class TwoFactorAuthModel
{
    public function isEnabled(int $userId): bool
    {
        $stmt = PDOService::prepare(
            'SELECT enabled FROM user_two_factor_auth WHERE user_id = :id'
        );
        $stmt->execute(['id' => $userId]);
        return (bool) ($stmt->fetchColumn() ?? false);
    }

    public function create(int $userId, string $secret): void
    {
        PDOService::prepare(
            'INSERT INTO user_two_factor_auth (user_id, secret)
             VALUES (:id, :secret)
             ON DUPLICATE KEY UPDATE secret = :secret'
        )->execute([
            'id' => $userId,
            'secret' => $secret,
        ]);
    }

    public function enable(int $userId): void
    {
        PDOService::prepare(
            'UPDATE user_two_factor_auth SET enabled = 1 WHERE user_id = :id'
        )->execute(['id' => $userId]);
    }

    public function disable(int $userId): void
    {
        PDOService::prepare(
            'UPDATE user_two_factor_auth SET enabled = 0 WHERE user_id = :id'
        )->execute(['id' => $userId]);
    }

    public function getSecret(int $userId): string
    {
        $stmt = PDOService::prepare(
            'SELECT secret FROM user_two_factor_auth
             WHERE user_id = :id AND enabled = 1'
        );
        $stmt->execute(['id' => $userId]);
        return (string) $stmt->fetchColumn();
    }
}
