<?php

namespace App\Symptom\Utils\Clients\HTTP;

interface Http
{
    public function get(string $url, array $params = []): mixed;
    public function post(string $url, array $params = []): mixed;
}
