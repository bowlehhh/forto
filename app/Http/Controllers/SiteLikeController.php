<?php

namespace App\Http\Controllers;

use App\Support\FortoSiteLikeStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiteLikeController extends Controller
{
    public function store(Request $request, FortoSiteLikeStore $siteLikeStore): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:40'],
        ]);

        return response()->json(
            $siteLikeStore->add($validated['name']),
        );
    }
}
