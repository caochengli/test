<?php
/**
 * 物流接口
 * User: ccl
 * Date: 2017/9/30
 * Time: 16:20
 */

include_once 'common_function.php';

$url = 'http://36.7.144.43:8005/ABCDAPI/GetToken?appkey=BP02041101&appsecret=D6F2E5B047374A99BF69538F9276EDC7';
$data = ['appkey' => 'BP02041101', 'appsecret' => 'D6F2E5B047374A99BF69538F9276EDC7'];

$return = http($url, 'GET', $data);

if ($return[0] != 200)
{
    echo '<pre>';
    print_r($return);
}
else
{
    $res = json_decode($return[1]);

    echo '<pre>';
    print_r($res);
}
