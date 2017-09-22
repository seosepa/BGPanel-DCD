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

    /**
     * @return Medoo
     */
    public static function getDb()
    {
        if(self::$db != null) {
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
                'prefix'        => 'bgp_',
                'logging'       => false,
            ]
        );

        self::$db = $database;
        return self::$db;
    }

}
