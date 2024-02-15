<?php

declare(strict_types=1);

return [
    'database' => env('LOCATION_DATABASE', database_path('maxmind/GeoLite2-City.mmdb')),
    'testing' => [
        'ip' => '66.102.0.0',
        'enabled' => env('LOCATION_TESTING', true),
    ],
    'download_url' => sprintf('https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key=%s&suffix=tar.gz', env('MAXMIND_LICENSE_KEY')),
];
