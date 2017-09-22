<?php

namespace BGPanelDCD;

use BGPanelDCD\BGPanel\Box;

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
    public static function getConfigsByRemoteIp(string $remoteIp) :array
    {
        $boxId = Box::getByIp($remoteIp);

        if ($remoteIp != false) {
            return self::getConfigsByBoxId($boxId);
        }

        return [];
    }

    /**
     * @param int $boxId
     * @return array
     */
    public static function getConfigsByBoxId(int $boxId) : array
    {
        $gameservers = Box::findGameserversById($boxId);
        return ConfigBuilder::buildForGameservers($gameservers);
    }

}
