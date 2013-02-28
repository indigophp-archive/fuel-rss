<?php

Autoloader::add_core_namespace('RSS');

Autoloader::add_classes(array(
	'RSS\\RSS'                     => __DIR__.'/classes/rss.php',
	'RSS\\RSS_Driver'              => __DIR__.'/classes/rss/driver.php',
	'RSS\\RSS_Driver_Lastrss'      => __DIR__.'/classes/rss/driver/lastrss.php',
));