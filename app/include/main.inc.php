<?php
/**
 * 常量定义
 * Created by PhpStorm.
 * User: 10574
 * Date: 2017/11/2
 * Time: 14:00
 */

// 根网址
define('__ROOT__', 'http://'.$_SERVER['HTTP_HOST']);

define('DEV', !strpos($_SERVER['HTTP_HOST'], 'zhuzhu'));

