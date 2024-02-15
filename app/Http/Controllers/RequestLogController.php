<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\RequestLog;
use Illuminate\Http\Request;

class RequestLogController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'link_id' => ['required', 'exists:links,id'],
            'ip' => ['required', 'ip'],
            'url' => ['required', 'url'],
            'user_agent' => ['required', 'string'],
            'platform' => ['nullable', 'string', 'max:255'],
            'browser' => ['nullable', 'string', 'max:255'],
            'device' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'fingerprint' => ['nullable', 'string', 'size:32'],
            'language' => ['nullable', 'string'],
            'referer' => ['nullable', 'string', 'url'],
            'meta' => ['nullable', 'string'],
        ]);

        $languageDecoded = json_decode(html_entity_decode($validated['language']), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON format for language field.'], 422);
        }
        $validated['language'] = $languageDecoded;

        try {
            $requestLog = RequestLog::create($validated);

            return response()->json($requestLog, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
