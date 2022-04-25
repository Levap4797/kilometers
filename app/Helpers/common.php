<?php

use App\Services\Client\MetroonClient;
use Illuminate\Http\Request;

if (! function_exists('customAsset')) {
    /**
     * Generate an asset path for the application with a specific version
     *
     * @param string $path
     * @param int $version
     * @param bool|null $secure
     * @return string
     */
    function customAsset($path, $version = 1, $secure = null)
    {
        $versionStr = $version ? '?v='. $version:"";
        return app('url')->asset($path, $secure). $versionStr;
    }
}

