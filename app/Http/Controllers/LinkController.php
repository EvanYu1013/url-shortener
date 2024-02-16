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
        $link = Link::with('scripts', 'parameters')
            ->where('slug', $slug)
            ->where('status', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->firstOrFail();

        $agent = new Agent();
        $log = $this->prepareLog($link, $request, $agent);

        $redirectUrl = $this->determineRedirectUrl($link, $log);
        $log['url'] = $this->appendParametersToUrl($redirectUrl, $link->parameters);
        $log['meta'] = json_encode([
            'execution_time' => microtime(true) - $start,
        ]);

        $scripts = $this->getScripts($link);

        return view('links.show', compact('log', 'scripts'));
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

    protected function appendParametersToUrl(string $url, $parameters): string
    {
        $query = $parameters->pluck('value', 'key')->toArray();
        if (! empty($query)) {
            $url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?').http_build_query($query);
        }

        return $url;
    }

    protected function getScripts($link): string
    {
        $scripts = $link->scripts()
            ->where('status', true)
            ->orderBy('priority', 'desc')
            ->get();

        $content = '';
        foreach ($scripts as $script) {
            $content .= $script->content;
        }

        return $content;
    }
}
