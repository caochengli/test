<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2018/6/5
 * Time: 17:10
 */
//字体大小
$size = 40;

//字体类型，本例为宋体
//$font ="extension/fonts/simsun.ttc";
$font ="extension/fonts/msyhbd.ttc";


//显示的文字
$text = $_GET['studio_name'];

//创建一个长为500高为80的空白图片
$img = imagecreate(700, 100);

//给图片分配颜色
imagecolorallocate($img, 0,0,0);

//设置字体颜色
$black = imagecolorallocate($img, 250, 128, 10);

//将ttf文字写到图片中
imagettftext($img, $size, 0, 2, 50, $black, $font, $text);

//发送头信息
header('Content-Type: image/png');

//输出图片
imagegif($img);