<?php

namespace App\Repositories\Rest;

use App\Models\Rest;

interface RestRepositoryInterface
{
    public function store(int $researchId): Rest;
    public function update(Rest $currentRest, \Carbon\Carbon $endTime): bool;
}
