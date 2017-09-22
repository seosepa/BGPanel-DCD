<?php

namespace BGPanelDCD\GameConfig;

use BGPanelDCD\ConfigBuilder;

/**
 * Class Cod4
 *
 * @package BGPanelDCD\GameConfig
 */
class CoD4 extends ConfigBuilder
{
    protected $templatePath = "cod4/main";

    /**
     * @param array $gameserver
     */
    public function parseConfigToData(array $gameserver)
    {
        $templateData = [
            "server.cfg" => [
                'name' => $gameserver['name'],
            ],
        ];

        $this->gameserverPath = str_replace("/srcds_run", '', $gameserver['path']);

        $this->templateData = $templateData;
    }
}
