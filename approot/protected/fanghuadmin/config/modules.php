<?php
$modules = array(
    // uncomment the following to enable the Gii tool
    'gii' => array(
        'class' => 'system.gii.GiiModule',
        'password' => 'ares_gii_0910',
        // If removed, Gii defaults to localhost only. Edit carefully to taste.
        'ipFilters' => array('127.0.0.1', '::1', '*'),
    ),
    'event',
    'mtask',
    'points',
    'friend',
    'test',
);
return $modules;
