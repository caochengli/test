<?php
/**
 * 数据导入
 * User: ccl
 * Date: 2017/9/29
 * Time: 11:31
 */

include_once 'extension/phpexcel/PHPExcel/IOFactory.php';
include_once 'extension/PingYing.php';

$filePath = 'd:/store.xlsx';
$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
$PHPExcel = $reader->load($filePath); // 载入excel文件
$sheet = $PHPExcel->getSheet(1); // 读取第一個工作表
$highestRow = $sheet->getHighestRow(); // 取得总行数
$highestColumm = $sheet->getHighestColumn(); // 取得总列数

$py = new PingYing;
$conn = conn();

/** 循环读取每个单元格的数据 */
for ($row = 2; $row <= $highestRow; $row++)
{
    //行数是以第1行开始
    $dataset[] = [
        'phone' =>  $sheet->getCell('A'.$row)->getValue(),
        'storename' =>  $sheet->getCell('B'.$row)->getValue(),
        'address' =>  $sheet->getCell('C'.$row)->getValue(),
        'bankno' =>  $sheet->getCell('D'.$row)->getValue(),
        'branchname' =>  $sheet->getCell('E'.$row)->getValue()
    ];
}

if ($dataset)
{
    foreach ($dataset as $row)
    {
        $time = time();
        $row['simplepy'] = $py->getFirstPY($row['storename']);
        $row['allpy'] = $py->getAllPY($row['storename']);
        $sql = "INSERT INTO zzcl_fx.fx_store(uid,storename,phone,address,bankno, branchname, simplepy, allpy, `status`, `addtime`) "
             ."VALUES(5, '{$row['storename']}', '{$row['phone']}', '{$row['address']}', '{$row['bankno']}', '{$row['branchname']}', '{$row['simplepy']}', '{$row['allpy']}', 1, {$time});";

        mysqli_query($conn, $sql);
    }
}


echo '<pre>';
print_r($dataset);
exit;

function conn()
{
    $mysql_server_name='192.168.1.5'; //改成自己的mysql数据库服务器
    $mysql_username='root'; //改成自己的mysql数据库用户名
    $mysql_password='666'; //改成自己的mysql数据库密码
    $mysql_database='zzcl_fx'; //改成自己的mysql数据库名

    $conn = mysqli_connect(
        $mysql_server_name,  /* The host to connect to 连接MySQL地址 */
        $mysql_username,      /* The user to connect as 连接MySQL用户名 */
        $mysql_password,  /* The password to use 连接MySQL密码 */
        $mysql_database);

    mysqli_set_charset($conn,'utf8');
    return $conn;
}

