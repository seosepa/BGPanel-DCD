<?php

namespace BGPanelDCD\BGPanel;

use Medoo\Medoo;

/**
 * Class Db
 *
 * @package BGPanelDCD\BGPanel
 */
class Db
{

    private static $db = null;

    private static $prefix = 'bgp_';

    /**
     * @return Medoo
     */
    public static function getDb()
    {
        if (self::$db != null) {
            return self::$db;
        }

        $database = new Medoo(
            [
                'database_type' => 'mysql',
                'database_name' => 'bgp',
                'server'        => '',
                'username'      => 'bgp',
                'password'      => '',
                'charset'       => 'utf8',
                'port'          => 3306,
                'prefix'        => self::$prefix,
                'logging'       => false,
            ]
        );

        self::$db = $database;
        return self::$db;
    }

    /**
     *
     */
    public static function addDCDCallBackTable()
    {
        $db     = self::getDb();
        $prefix = self::$prefix;
        $db->query(
            "CREATE TABLE IF NOT EXISTS `{$prefix}dcd_callback` (
                  `id` int(11) NOT NULL,
                  `boxId` int(11) NOT NULL,
                  `totalAmount` int(11) NOT NULL,
                  `successAmount` int(11) NOT NULL,
                  `errorAmount` int(11) NOT NULL,
                  `dateTime` datetime NOT NULL,
                  KEY `boxId` (`boxId`),
                  KEY `dateTime` (`dateTime`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );
    }

}
