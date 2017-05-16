<?php

/**
 * 相册服务
 * 640x314
 * 640x444
 * 720x500
 * 750x520
 * o
 * 
  房源图：640x444 720x500
  一级资讯：600x200 664x220
  二级资讯：640x300  720x338
  缩略图：202x152
 */
return array(
    'allsize' => array(
        '640x314',
        '640x444',
        '720x500',
        '750x520',
        '720x338',
        '640x500',
        '126x126',
        '1250x380',
        '1920x380',
    ),
    'source' => array(
        'house' => array('default' => '720x500'),
        'news' => array('default' => '720x338'),
        'invest' => array('default' => '640x500'),
        'citythumb' => array('default' => '1920x380'),
        'city' => array('default' => '720x520'),
        'state' => array('default' => '720x500'),
        'country' => array('default' => '1250x380'),
        'avatar' => array('default' => '126x126'),
    ),
    'task' => array(
        'small' => '90x70',
        'middle' => '280x160',
        'big' => '640x320',
//        'detail'=>'700x500',
//        'earn_brokerage'=>'720x500',
//        'house_index'=>'300x80',
//        'list'=>'90x70',
    ),
	'mall' => array(
			'small' => '90x70',
			'middle' => '280x160',
			'big' => '640x320',
	),
);
