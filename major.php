<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2018/5/21
 * Time: 17:15
 */

include_once 'extension/PingYing.php';

$conn = conn();

$url = 'https://m.zhaopin.com/resume/GetMajor';

$py = new PingYing;

$time = 1526893111;

for ($i = 68; $i < 73; $i++) {
    $return = http($url, 'POST', ['code' => $i], [], false);
    $majorArr = json_decode($return[1], true);
    foreach ($majorArr as $row) {

        $simplepy = $py->getFirstPY($row['name']);
        $allpy = $py->getAllPY($row['name']);
        $sql = "INSERT INTO iwk_data.sys_major(mjid, pid,name, simplepy, allpy, `status`, `addtime`) "
            ."VALUES({$row['code']}, {$i}, '{$row['name']}', '{$simplepy}', '{$allpy}', 1, {$time});";

        mysqli_query($conn, $sql);
    }
}




function conn()
{
    $mysql_server_name='192.168.1.5'; //改成自己的mysql数据库服务器
    $mysql_username='root'; //改成自己的mysql数据库用户名
    $mysql_password='666'; //改成自己的mysql数据库密码
    $mysql_database='iwk_data'; //改成自己的mysql数据库名

    $conn = mysqli_connect(
        $mysql_server_name,  /* The host to connect to 连接MySQL地址 */
        $mysql_username,      /* The user to connect as 连接MySQL用户名 */
        $mysql_password,  /* The password to use 连接MySQL密码 */
        $mysql_database);

    mysqli_set_charset($conn,'utf8');
    return $conn;
}

function http($url, $method, $postfields = null, $headers = array(), $debug = false) {
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($ci, CURLOPT_USERAGENT, 'PP OAuth V0.1');
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ci, CURLOPT_TIMEOUT, 30);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE);

    switch ($method) {
        case 'POST':
            curl_setopt($ci, CURLOPT_POST, true);
            if (!empty($postfields)) {
                curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                //$this->postdata = $postfields;guth 貌似有bug啊，我在别的地方调用，会报错
            }
            break;
    }

    curl_setopt($ci, CURLOPT_URL, $url);
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);

    $response = curl_exec($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);

    if ($debug) {
        echo "=====post data======\r\n";
        var_dump($postfields);

        echo '=====info=====' . "\r\n";
        print_r(curl_getinfo($ci));

        echo '=====$response=====' . "\r\n";
        print_r($response);

        echo '=====error=====' . "\r\n";
        print_r(curl_error($ci));
    }


    curl_close($ci);



    //请求失败日志记录 mckee 2014-6-11
    if($http_code != 200) {
        @my_log_message("curl", "{$url}--{$http_code}--{$response}");
    }

    return array($http_code, $response);
}
