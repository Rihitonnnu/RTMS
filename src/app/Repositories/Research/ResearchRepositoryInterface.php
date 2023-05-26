<?php

namespace App\Repositories\Research;

use App\Models\Research;
use Illuminate\Http\Request;

interface ResearchRepositoryInterface
{
    public function store(Request $request): Research;
    public function update(Request $request, int $targetTimeId): void;
}
