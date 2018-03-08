<?php
/**
 * 约瑟夫环
 * User: ccl
 * Date: 2017/7/17
 * Time: 14:58
 */
/*define('N', 1000);        //总数
define('P', rand(1,N));   //开始报数的位置
define('M', rand(1,N/2)); //报数的间距*/

define('N', 41);        //总数
define('P', 1);   //开始报数的位置
define('M', 3);

getSucessUserNum2();

/**
 * 方法一：通过循环遍历得到结果
 *  如果 N,M 比较大的话，此方法不建议使用，因为实在太LOW了
 */

function getSucessUserNum1()
{
    $data = range(0, N);
    unset($data[0]);

    if(empty($data)) return false;

    //第一个开始报数的位置
    $p = P;

    while(count($data) > 1)
    {
        for($i=1; $i < M; $i++)
        {
            $p = (isset($data[$p])) ? $p : getExistNumPosition($data, $p);
            $p++;
            $p = ($p == N) ? $p : $p % N;
        }

        $p = (isset($data[$p])) ? $p : getExistNumPosition($data, $p);

        unset($data[$p]);

        $p = ($p == N) ? 1 : $p + 1;
    }

    $data = array_values($data);

    echo  "<br> successful num : " . $data[0] . "<br><br>";
}
/**
 * 获取下一个报数存在的下标
 * $data   当前存在的数据
 * $p  上一个报名数的下标
 */
function getExistNumPosition($data, $p)
{
    if(isset($data[$p])) return $p;

    $p++;

    $p = ($p == N) ? $p : $p % N;

    return getExistNumPosition($data, $p);
}

/**
 * 方法二：通过算法得到结果
 *  此方法比方法一快多了，不行自己试一下
 */
function getSucessUserNum2()
{
    $data = range(1, N);

    if(empty($data)) return false;

    //第一个报数的位置
    $start_p = (P-1);

    while(count($data) > 1)
    {
        //报到数出列的位置
        $del_p = ($start_p  + M - 1) % count($data);

        if(isset($data[$del_p]))
        {
            unset($data[$del_p]);
        }
        else
        {
            break;
        }

        //数组从新排序
        $data = array_values($data);

        $new_count = count($data);

        //计算出在新的$data中，开始报数的位置
        $start_p = ($del_p >= $new_count) ? ($del_p % $new_count) : $del_p;
    }

    echo  "<br> successful num : " . $data[0] . "<br><br>";
}