<?php


return array(
	'default_setup' => 'default',
	'setups' => array(
		'default' => array(
			'driver' => 'lastrss',
			'limit' => 5,
			'date_format' => 'Y-m-d H:i',
			'order' => array('pubDate', 'DESC'),
			'path' => 'lastRSS.php',
			'class' => 'lastRSS'
		)
	)
);