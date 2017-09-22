<?php

/**
 * Class ConfigGetter
 */
class ConfigGetter
{

    private static $commit = true;

    private static $debugMode = false;

    private static $dcdConfigUrl = 'http://confomator.event.thereality.nl/';

    /**
     *
     */
    public static function getAndApplyConfigs()
    {
        $url        = self::$dcdConfigUrl;
        $rawConfigs = file_get_contents($url);
        $configs    = json_decode($rawConfigs, true);

        $confCount = count($configs);
        self::debugLog("fetched {$confCount} configs from DCD {$url}");

        if ($configs != false) {
            self::writeConfigs($configs);
        }
    }

    /**
     * @param array $configs
     */
    public static function writeConfigs($configs)
    {
        foreach ($configs as $gamePath => $gameConfig) {
            foreach ($gameConfig as $confPath => $configContent) {

                $fullpath = "{$gamePath}/{$confPath}";

                if (!file_exists($gamePath)) {
                    self::debugLog("GamePath[={$gamePath}] does not exist, skipping", true);
                    continue;
                }

                self::debugLog("writing config to {$fullpath}");

                if (self::$commit) {
                    file_put_contents($fullpath, $configContent);
                } else {
                    self::debugLog("[DRY-RUN] would have written: {$configContent}");
                }
            }
        }
    }

    /**
     * @param string $message
     * @param bool   $isError
     */
    public static function debugLog($message, $isError = false)
    {
        if (self::$debugMode == false && !$isError) {
            return;
        }

        $date = date('Y-m-d H:i:s');
        echo "[$date] {$message}" . PHP_EOL;
    }
}

ConfigGetter::getAndApplyConfigs();
