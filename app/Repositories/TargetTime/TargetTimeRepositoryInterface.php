<?php

namespace App\Repositories\TargetTime;

use App\Models\TargetTime;
use Illuminate\Http\Request;

interface TargetTimeRepositoryInterface
{
    public function store(Request $request): TargetTime;
    public function update(Request $request, int $targetTimeId): bool;
}
