<?php

defined('ROOT_PATH') or define('ROOT_PATH',dirname(__DIR__));
defined('APP_PATH') or define('APP_PATH',ROOT_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR);
defined('RESOURCES_PATH') or define('RESOURCES_PATH',ROOT_PATH.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR);
defined('CLOTHES_PATH') or define('CLOTHES_PATH',RESOURCES_PATH.DIRECTORY_SEPARATOR.'clothes'.DIRECTORY_SEPARATOR);

// +----------------------------------------------------------------------
// | 数据表定义
// +----------------------------------------------------------------------
defined('TABLE_CATEGORY') or define('TABLE_CATEGORY','category');
defined('TABLE_CLOTHES') or define('TABLE_CLOTHES','clothes');