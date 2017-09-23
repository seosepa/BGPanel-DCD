<?php

/**
 * Class ConfigGetter
 */
class ConfigGetter
{

    private $commit = true;

    private $randomSleepTime = true;

    private $debugMode = false;

    private $dcdConfigUrl = 'http://confomator.event.thereality.nl/';

    private $amountSuccess = 0;

    private $amountError = 0;

    /**
     *  Do awesome stuff
     */
    public function getAndApplyConfigs()
    {
        // rand sleep so not all gameserver request at the same time
        if ($this->randomSleepTime) {
            sleep(rand(0, 45));
        }

        $url        = $this->dcdConfigUrl;
        $rawConfigs = file_get_contents($url);
        $configs    = json_decode($rawConfigs, true);

        $confCount = $this->getConfigCount($configs);
        $this->debugLog("fetched {$confCount} configs from DCD {$url}");

        if ($configs != false) {
            try {
                $this->writeConfigs($configs);
            } catch (Exception $e) {
                $this->debugLog($e->getMessage(), true);
                $this->amountError++;
            }
        }

        $this->performCallback($confCount, $this->amountSuccess, $this->amountError);
    }

    /**
     * @param array $configs
     */
    private function writeConfigs($configs)
    {
        foreach ($configs as $gamePath => $gameConfig) {
            foreach ($gameConfig as $confPath => $configContent) {

                $fullpath = "{$gamePath}/{$confPath}";

                if (!file_exists($gamePath)) {
                    $this->debugLog("GamePath[={$gamePath}] does not exist, skipping", true);
                    $this->amountError++;
                    continue;
                }

                $this->debugLog("writing config to {$fullpath}");

                if ($this->commit) {
                    if (file_put_contents($fullpath, $configContent)) {
                        $this->amountSuccess++;
                    } else {
                        $this->amountError++;
                    }
                } else {
                    $this->debugLog("[DRY-RUN] would have written: {$configContent}");
                }
            }
        }
    }

    /**
     * @param string $message
     * @param bool   $isError
     */
    private function debugLog($message, $isError = false)
    {
        if ($this->debugMode == false && !$isError) {
            return;
        }

        $date = date('Y-m-d H:i:s');
        echo "[$date] {$message}" . PHP_EOL;
    }

    /**
     * @param int $totalAmount
     * @param int $successAmount
     * @param int $errorAmount
     */
    private function performCallback($totalAmount, $successAmount, $errorAmount)
    {
        $url = $this->dcdConfigUrl;
        file_get_contents("{$url}callback.php?total={$totalAmount}&success={$successAmount}&error={$errorAmount}");
    }

    /**
     * @param $gameServerConfigs
     * @return int
     */
    private function getConfigCount($gameServerConfigs)
    {
        $count = 0;
        foreach ($gameServerConfigs as $configs) {
            $count = $count + count($configs);
        }

        return $count;
    }
}

$configGetter = new ConfigGetter();
$configGetter->getAndApplyConfigs();
