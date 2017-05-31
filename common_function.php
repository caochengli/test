<?php
/**
 * 经典的概率算法，
 *
 * $proArr是一个预先设置的数组，
 * 假设数组为：array(100,200,300，400)，
 * 开始是从1,1000 这个概率范围内筛选第一个数是否在他的出现概率范围之内，
 * 如果不在，则将概率空间，也就是k的值减去刚刚的那个数字的概率空间，
 * 在本例当中就是减去100，也就是说第二个数是在1，900这个范围内筛选的。
 * 这样 筛选到最终，总会有一个数满足要求。
 * 就相当于去一个箱子里摸东西，
 * 第一个不是，第二个不是，第三个还不是，那最后一个一定是。
 * 这个算法简单，而且效率非常 高，
 * 关键是这个算法已在我们以前的项目中有应用，尤其是大数据量的项目中效率非常棒。
 */
function get_rand($proArr)
{
	$result = '';

	//概率数组的总概率精度
	$proSum = array_sum($proArr);

	//概率数组循环
	foreach ($proArr as $key => $proCur)
	{
		$randNum = mt_rand(1, $proSum);

		if ($randNum <= $proCur)
		{
			$result = $key;
			break;
		}
		else
		{
			$proSum -= $proCur;
		}
	}

	unset ($proArr);
	return $result;
}

// 格式化资产
function handleMoney($money, $num=4, $func='')
{
    $code = pow(10, $num);

    switch ($func)
    {
        case 'round':
            $money = round($money, $num);
            break;
        case 'ceil':
            $money = ceil($money*$code)/$code;
            break;
        case 'floor':
            $money = floor($money*$code)/$code;
            break;
        default:
            $money = floor($money*$code)/$code;
            break;
    }

    return $money;
}

// 数据格式处理
function smath($a, $b, $math='+', $num=4, $func='floor')
{
    $code = pow(10, $num);

    $a = handleMoney($a, $num, $func);
    $b = handleMoney($b, $num, $func);

    switch ($math)
    {
        case '+':
            $re = round($a*$code + $b*$code)/$code;
            break;
        case '-':
            $re = round($a*$code - $b*$code)/$code;
            break;
        case '*':
            $re = round($a*$b*$code)/$code;
            break;
        case '/':
            $re = round($a*10000/$b)/10000;
            break;
        default:
            break;
    }

    return handleMoney($re, $num, $func);
}