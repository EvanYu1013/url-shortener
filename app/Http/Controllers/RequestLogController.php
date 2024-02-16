<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\RequestLog;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RequestLogController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
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
        ];

        $validated = $request->validate($rules);

        $validated['language'] = $this->decodeJsonField($validated['language'] ?? '');
        $validated['meta'] = $this->decodeJsonField($validated['meta'] ?? '');

        $requestLog = RequestLog::create($validated);

        return response()->json($requestLog, 201);
    }

    private function decodeJsonField(string $jsonString)
    {
        if (empty($jsonString)) {
            return null;
        }

        $decoded = json_decode(html_entity_decode($jsonString), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw ValidationException::withMessages([
                'jsonField' => ['Invalid JSON format.'],
            ]);
        }

        return $decoded;
    }
}
