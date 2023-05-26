<?php

namespace App\Repositories\Rest;

use Illuminate\Http\Request;
use App\Models\Rest;

interface RestRepositoryInterface
{
    public function store(int $researchId): Rest;
    public function update(Rest $currentRest, $endTime): void;
}
