<?php
require 'vendor/autoload.php';

use BGPanelDCD\Dashboard;

$loader = new Twig_Loader_Filesystem('templates');
$twig   = new Twig_Environment($loader);

$data['info'] = Dashboard::getOverviewData();
echo $twig->render("dashboard.twig", $data);
