<?php
define('APP_ROOT', __DIR__ . DIRECTORY_SEPARATOR);

return [
    "mysql" => [
        'host' => 'localhost',
        'database' => 'dustcloud',
        'username' => 'user123',
        'password' => '',
    ],
    'cmd.server' => 'http://localhost:1121/',
    "twig.cache" => "cache",
    "twig.templates" => "templates",
    'debug' => true,
];
