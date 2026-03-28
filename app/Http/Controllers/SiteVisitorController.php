<?php

namespace App\Http\Controllers;

use App\Support\FortoVisitorStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiteVisitorController extends Controller
{
    public function store(Request $request, FortoVisitorStore $visitorStore): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:40'],
            'token' => ['required', 'string', 'max:120'],
        ]);

        return response()->json(
            $visitorStore->add($validated['name'], $validated['token']),
        );
    }
}
