<?php
/**
 * 班次计算
 * User: ccl
 * Date: 2018/9/27
 * Time: 14:42
 */

$banConfig = ['白班', '晚班', '休息'];

// 白班开始时间
$startdate = '2018-09-25';

// 计算日
$date = '2019-02-04';

// 两个日期相距天数
$nums = (strtotime($date) - strtotime($startdate))/86400;

$tmp = $nums%3 ;

echo $banConfig[$tmp];




