<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class TrustedDeviceModel
{
    public function create(int $userId, string $token, array $data): void
    {
        PDOService::prepare(
            'INSERT INTO trusted_devices
            (user_id, device_token, device_name, user_agent, ip_address, expires_at)
            VALUES (:uid, :token, :name, :ua, :ip, :exp)'
        )->execute([
            'uid'   => $userId,
            'token' => $token,
            'name'  => $data['device_name'],
            'ua'    => $data['user_agent'],
            'ip'    => $data['ip_address'],
            'exp'   => $data['expires_at'],
        ]);
    }

    public function isValid(int $userId, string $token): bool
    {
        $stmt = PDOService::prepare(
            'SELECT 1 FROM trusted_devices
             WHERE user_id = :uid
               AND device_token = :token
               AND expires_at > NOW()'
        );
        $stmt->execute([
            'uid' => $userId,
            'token' => $token,
        ]);

        return (bool) $stmt->fetchColumn();
    }
}
