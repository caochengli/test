<?php
/**
 * ����ĸ����㷨��
 *
 * $proArr��һ��Ԥ�����õ����飬
 * ��������Ϊ��array(100,200,300��400)��
 * ��ʼ�Ǵ�1,1000 ������ʷ�Χ��ɸѡ��һ�����Ƿ������ĳ��ָ��ʷ�Χ֮�ڣ�
 * ������ڣ��򽫸��ʿռ䣬Ҳ����k��ֵ��ȥ�ոյ��Ǹ����ֵĸ��ʿռ䣬
 * �ڱ������о��Ǽ�ȥ100��Ҳ����˵�ڶ���������1��900�����Χ��ɸѡ�ġ�
 * ���� ɸѡ�����գ��ܻ���һ��������Ҫ��
 * ���൱��ȥһ����������������
 * ��һ�����ǣ��ڶ������ǣ������������ǣ������һ��һ���ǡ�
 * ����㷨�򵥣�����Ч�ʷǳ� �ߣ�
 * �ؼ�������㷨����������ǰ����Ŀ����Ӧ�ã������Ǵ�����������Ŀ��Ч�ʷǳ�����
 */
function get_rand($proArr)
{
	$result = '';

	//����������ܸ��ʾ���
	$proSum = array_sum($proArr);

	//��������ѭ��
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

// ��ʽ���ʲ�
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

// ���ݸ�ʽ����
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