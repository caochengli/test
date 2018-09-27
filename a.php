<?php
include 'common_function.php';

//$proArr = array(0 => 1);
//$proArr = array( 1 => 0.01, 2 => 0.05, 3 => 0.00090, 7 => 50);
//$proArr = array(1 => 0.01, 2 => 0.05, 3 => 0.00090);
$proArr = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 90);
$m = get_rand_new($proArr);
echo $m;exit;


$arrUsers = array(
    array(
        'id'   => 1,
        'name' => '张三',
        'age'  => 25,
    ),
    array(
        'id'   => 2,
        'name' => '李四',
        'age'  => 23,
    ),
    array(
        'id'   => 3,
        'name' => '王五',
        'age'  => 40,
    ),
    array(
        'id'   => 4,
        'name' => '赵六',
        'age'  => 31,
    ),
    array(
        'id'   => 5,
        'name' => '黄七',
        'age'  => 20,
    ),
);

$return = array_sort($arrUsers, 'age', 'SORT_DESC');
echo '<pre>';
print_r($return);
exit;