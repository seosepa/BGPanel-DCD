<?php

/**
 * Class ConfigGetter
 */
class ConfigGetter
{

    private static $dcdConfigUrl = 'http://confomator.event.thereality.nl/';

    /**
     *
     */
    public static function getAndApplyConfigs()
    {
        $rawConfigs = file_get_contents(self::$dcdConfigUrl);
        $configs    = json_decode($rawConfigs, true);

        $confCount = count($configs);
        self::debugLog("fetched {$confCount} configs");

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
                    return;
                }

                self::debugLog("writing to {$fullpath}");
                file_put_contents($fullpath, $configContent);
            }
        }
    }

    /**
     * @param string $message
     */
    public static function debugLog($message)
    {
        $date = date('Y-m-d H:i:s');
        echo "[$date] {$message}" . PHP_EOL;
    }
}

ConfigGetter::getAndApplyConfigs();
