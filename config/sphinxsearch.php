<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/8/27
 * Time: 下午6:22
 */
return array(
    'host'    => '127.0.0.1',
    'port'    => 9312,
    'timeout' => 30,
    'indexes' => array(
        'my_index_name' => array('table' => 'jz_coupon', 'column' => 'id'),
    ),
    'mysql_server' => array(
        'host' => '127.0.0.1',
        'port' => 9306
    )
);
