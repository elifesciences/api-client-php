<?php

namespace eLife\ApiClient;

use PackageVersions\Versions;

final class Version
{
    private static $version;

    private function __construct()
    {
    }

    public static function get() : string
    {
        if (empty(self::$version)) {
            self::create();
        }

        return self::$version;
    }

    private static function create()
    {
        $originalVersion = Versions::getVersion('elife/api-client');
        list($version, $reference) = explode('@', $originalVersion);
        if (false !== strpos($version, 'dev')) {
            if (40 === strlen($reference)) {
                $version = implode('@', [$version, substr($reference, 0, 7)]);
            } else {
                $version = $originalVersion;
            }
        }

        self::$version = $version;
    }
}
