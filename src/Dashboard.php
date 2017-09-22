<?php

namespace BGPanelDCD;

use BGPanelDCD\BGPanel\Box;
use BGPanelDCD\BGPanel\DCDCallback;

/**
 * Class ServerConfig
 *
 * @package BGPanelDCD
 */
class ServerConfig
{

    /**
     * @param string $remoteIp
     * @return array
     */
    public static function getConfigsByRemoteIp(string $remoteIp): array
    {
        $boxId = Box::getByIp($remoteIp);

        if ($boxId != false) {
            return self::getConfigsByBoxId($boxId);
        }

        return [];
    }

    /**
     * @param int $boxId
     * @return array
     */
    public static function getConfigsByBoxId(int $boxId): array
    {
        $gameservers = Box::findGameserversById($boxId);
        return ConfigBuilder::buildForGameservers($gameservers);
    }

    /**
     * @param string $remoteIp
     * @param int    $totalAmount
     * @param int    $successAmount
     * @param int    $errorAmount
     */
    public static function processCallback(string $remoteIp, int $totalAmount, int $successAmount, int $errorAmount)
    {
        $boxId = Box::getByIp($remoteIp);

        if ($boxId == false) {
            return;
        }

        $callback = new DCDCallback();
        $callback->setBoxId($boxId);
        $callback->setTotalAmount($totalAmount);
        $callback->setSuccessAmount($successAmount);
        $callback->setErrorAmount($errorAmount);
        $callback->insert();
    }

}
