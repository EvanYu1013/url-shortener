<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Link;
use GeoIp2\Database\Reader;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class LinkController extends Controller
{
    public function show(Request $request, $slug)
    {
        $start = microtime(true);
        $link = Link::where('slug', $slug)
            ->where('status', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->firstOrFail();

        $agent = new Agent();
        $log = $this->preparelog($link, $request, $agent);

        $log['url'] = $this->determineRedirectUrl($link, $log);
        $log['meta'] = json_encode([
            'execution_time' => microtime(true) - $start,
        ]);

        return view('links.show', compact('log'));
    }

    protected function preparelog($link, $request, $agent): array
    {
        $log = [
            'link_id' => $link->id,
            'user_agent' => $request->userAgent(),
            'platform' => $agent->platform(),
            'browser' => $agent->browser(),
            'device' => $agent->device(),
            'referer' => $request->header('referer'),
            'language' => json_encode($agent->languages()),
        ];

        if (config('location.testing.enabled')) {
            $log['ip'] = config('location.testing.ip');
        } else {
            $log['ip'] = $request->ip();
        }

        $location = $this->getLocation($log['ip']);
        $log = array_merge($log, $location);

        return $log;
    }

    protected function getLocation($ip): array
    {
        $cityDbReader = new Reader(config('location.database'));
        $record = $cityDbReader->city($ip);
        $location = [
            'country' => $record->country->isoCode,
            'city' => $record->mostSpecificSubdivision->isoCode,
            'latitude' => $record->location->latitude,
            'longitude' => $record->location->longitude,
        ];

        return $location;
    }

    protected function determineRedirectUrl($link, $log): string
    {
        $rules = $link->rules()
            ->where('status', true)
            ->orderBy('priority', 'desc')
            ->get();

        foreach ($rules as $rule) {
            if ($rule->value === $log[$rule->type]) {
                return $rule->target_url;
            }
        }

        return $link->target_url;
    }
}
