<?php

return [

	'online_listen_ip' => '192.168.121.129',

	'online_listen_port' => 9502,

	'redis' => [

        'cluster' => false,

        'default' => [
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'database' => 0,
        ],

    ],
];