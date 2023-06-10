<?php

if (!function_exists('asset_path')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @return string
     */
    function asset_path($path)
    {
        return env('APP_ENV') === 'local' ? asset($path) : secure_asset($path);
    }
}