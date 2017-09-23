<?php

namespace BGPanelDCD;

use BGPanelDCD\BGPanel\Box;
use BGPanelDCD\BGPanel\DCDCallback;
use Westsworld\TimeAgo;

/**
 * Class Dashboard
 *
 * @package BGPanelDCD
 */
class Dashboard
{
    /**
     * @return array
     */
    public static function getOverviewData(): array
    {
        $infoArray = [];
        $boxes     = Box::getAll();

        if ($boxes == false) {
            return [];
        }

        foreach ($boxes as $box) {
            $boxData = $box;
            $boxData['generatedAmount'] = count(ServerConfig::getConfigsByBoxId($box['boxid']));
            $callback = DCDCallback::getLastestCallbackForBoxId($box["boxid"]);
            if (is_array($callback)) {
                $timeAgo = new TimeAgo();
                $callback['timeAgo'] = $timeAgo->inWords($callback['dateTime']);
                $callback['secondsAgo'] = time() - strtotime($callback['dateTime']);
                $boxData = $boxData + $callback;
            }
            $infoArray[$box['name']] = $boxData;
        }

        ksort($infoArray,SORT_NATURAL);

        return $infoArray;
    }
}
