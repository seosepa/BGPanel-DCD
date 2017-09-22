<?php

namespace BGPanelDCD\BGPanel;

/**
 * Class Box
 *
 * @package BGPanelDCD/BGPanel
 */
class Box
{
    /**
     * @param string $ip
     * @return int|bool
     */
    public static function getByIp(string $ip)
    {
        $db = Db::getDb();
        return $db->get("boxIp", "boxid", ["ip" => $ip]);
    }

    /**
     * @param int $boxId
     * @return array|bool
     */
    public static function findGameserversById(int $boxId)
    {
        $db = Db::getDb();
        return $db->select("server", "*", ["boxid" => $boxId]);
    }


}
