<?php

namespace App\Repositories\Research;

use App\Models\TargetTime;
use Illuminate\Http\Request;

interface ResearchRepositoryInterface
{
    public function store(Request $request): TargetTime;
    public function update(Request $request, int $targetTimeId): bool;
}
