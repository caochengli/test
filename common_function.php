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

/* 正则匹配 */
function regMobile($mobile)
{
    return preg_match('/1[\d]{10}/', $mobile);
}
function regEmail($email)
{
    return preg_match('/\w[\w\-\.]+\@\w[\w\-]+\.\w[\w\-]+/Ui', $email);
}

/* 表单验证 */
function formHash($new=0)
{
    if ($new == 1)
    {
        $_SESSION['formhash'] = srandsalt(4);
    }

    return $_SESSION['formhash'];
}
function formCheck($formhash)
{
    if ($formhash == formHash())
    {
        unset($_SESSION['formhash']);
        return true;
    }
    return false;
}

function gbk2utf8($str)
{
    return sencode($str, 'gbk', 'utf-8');
}

function utf82gbk($str)
{
    return sencode($str, 'utf-8', 'gbk');
}

// 转换编码
function sencode($str, $from, $to)
{
    $str = is_array($str) ? $str : array($str);

    foreach ($str as $key => $value)
    {
        if (is_array($value))
        {
            $str[$key] = sencode($value, $from, $to);
            continue;
        }
        $str[$key] = mb_convert_encoding($value, $to, $from);
    }

    return $str;
}

function getClientIP()
{
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR')
        && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']
        && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

/* SQL ADDSLASHES 参数可以是字符串或者数组 */
function saddslashes($string)
{
    if (is_array($string))
    {
        foreach($string as $key => $val)
        {
            $string[$key] = saddslashes($val);
        }
    }
    else
    {
        $string = addslashes($string);
    }

    return $string;
}

function conn($db='db')
{
    global $_SGLOBAL, $_SC;
    $_SGLOBAL[$db] = mysqli_connect($_SC[$db.'_host'], $_SC[$db.'_user'], $_SC[$db.'_upwd']);
    mysqli_set_charset($_SC['charset'], 'utf8');
}

/*
    返回随机字符串或者数组
    Params:
        $count: 返回个数
        $addchars: 增加其他随机字符
        $arrayout: 是否数组输出
        $unique: 是否允许重复
*/
function srandsalt($count=6, $addchars='', $arrayout=0, $unique=0)
{
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addchars;
    if ($unique)
    {
        $tmp = range(0, strlen($chars)-1);
        shuffle($tmp);
        $keys = array_slice($tmp, 0, $count);
        unset($tmp);
    }
    else
    {
        $keys = array_rand(range(0, strlen($chars)-1), $count);
    }

    $buff = array();
    foreach($keys as $value)
    {
        $buff[] = $chars{$value};
    }

    if ($arrayout)
    {
        return $buff;
    }
    else
    {
        return implode('', $buff);
    }
}

/* 生成缩略图 */
function imageResize($srcFile, $toW, $toH, $toFile="")
{
    $toFile = $toFile ? $toFile : $srcFile;
    $info = "";
    $data = GetImageSize($srcFile, $info);

    switch ($data[2])
    {
        case 1:
            if(!function_exists("imagecreatefromgif"))
            {
                echo 'curl_imagecreatefromgif';
                exit();
            }

            $im = ImageCreateFromGIF($srcFile);
            break;
        case 2:
            if(!function_exists("imagecreatefromjpeg"))
            {
                echo 'curl_imagecreatefromjpeg';
                exit();
            }

            $im = ImageCreateFromJpeg($srcFile);
            break;
        case 3:
            $im = ImageCreateFromPNG($srcFile);
            break;
    }

    $srcW=ImageSX($im);
    $srcH=ImageSY($im);
    $toWH=$toW/$toH;   // 缩放后
    $srcWH=$srcW/$srcH;

    if($toWH<=$srcWH)  // 比率
    {
        $ftoW=$toW;
        $ftoH=$ftoW*($srcH/$srcW);
    }
    else
    {
        $ftoH=$toH;
        $ftoW=$ftoH*($srcW/$srcH);
    }

    /*if( $srcW>$toW || $srcH>$toH )
    {*/
    if(function_exists("imagecreatetruecolor"))
    {
        @$ni = ImageCreateTrueColor($ftoW,$ftoH);
        if($ni)
        {
            ImageCopyResampled($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
        }
        else
        {
            $ni=ImageCreate($ftoW,$ftoH);
            ImageCopyResized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
        }
    }
    else
    {
        $ni=ImageCreate($ftoW,$ftoH);
        ImageCopyResized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
    }

    if(function_exists('imagejpeg'))
    {
        ImageJpeg($ni,$toFile);
        return true;
    }
    else
    {
        ImagePNG($ni,$toFile);
        return true;
    }
    ImageDestroy($ni);

    /*}*/

    ImageDestroy($im);
    return false;
}

/**
 * 加密和解密函数
 *
 * <code>
 * // 加密用户ID和用户名
 * $auth = authcode("{$uid}\t{$username}", 'ENCODE');
 * // 解密用户ID和用户名
 * list($uid, $username) = explode("\t", authcode($auth, 'DECODE'));
 * </code>
 *
 * @access public
 * @param  string  $string    需要加密或解密的字符串
 * @param  string  $operation 默认是DECODE即解密 ENCODE是加密
 * @param  string  $key       加密或解密的密钥 参数为空的情况下取全局配置encryption_key
 * @param  integer $expiry    加密的有效期(秒)0是永久有效 注意这个参数不需要传时间戳
 * @return string
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    global $_SC;

    if ($operation == 'DECODE')
    {
        $string = str_replace('_', '+', $string);
    }

    $ckey_length = 4;
    $key = md5($key != '' ? $key : $_SC['encryption_key']);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        $result = str_replace('=', '', base64_encode($result));
        //$result = str_replace('+', '_', $result);
        return $keyc . $result;
    }
}

/**
 * 二维数组排序 按照指定的key 对数组进行排序
 *
 * @param array $arr 将要排序的数组
 * @param string $keys 指定排序的key
 * @param string $type 排序类型 asc | desc
 *
 * @return array
 */
function arraySort($arr, $keys, $type = 'asc')
{
    $keysvalue = $new_array = array();

    foreach ($arr as $k => $v)
    {
        $keysvalue[$k] = $v[$keys];
    }

    $type == 'asc' ? asort($keysvalue) : arsort($keysvalue);
    reset($keysvalue);

    foreach ($keysvalue as $k => $v)
    {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}

/**
 * curl请求
 */
function http($url, $method = 'GET', $postfields = null, $headers = array(), $https = false)
{
    $ci = curl_init();

    /* Curl settings */
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($ci, CURLOPT_USERAGENT, 'zhzcl');
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ci, CURLOPT_TIMEOUT, 5);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);

    switch ($method)
    {
        case 'POST':
            curl_setopt($ci, CURLOPT_POST, true);
            if (!empty($postfields))
            {
                curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
            }

            break;
    }

    if ($https)
    {
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, true);
    }

    curl_setopt($ci, CURLOPT_URL, $url);
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);

    $response = curl_exec($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);


    if ($http_code != 200)
    {
        return array($http_code, 'Curl error: ' . curl_error($ci));
    }

    curl_close($ci);

    return array($http_code, $response);
}

/**
 * 权重算法
 */
function countWeight($data)
{
    $weight = 0;
    $temp = array();
    foreach($data as $v)
    {
        $weight += $v['weight'];
        for($i=0; $i<$v['weight']; $i++)
        {
            $temp[] = $v;//放大数组
        }
    }

    $int = mt_rand(0, $weight-1);//获取一个随机数
    $result = $temp[$int];
    return $result;
}

// 二维数组按某个字段排序
function array_sort($array, $field, $direction = 'SORT_DESC')
{
    if (!$field || !in_array($direction, ['SORT_DESC', 'SORT_ASC']))
    {
        return $array;
    }
    $sort = array(
        'direction' => $direction, //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
        'field'     => $field,       //排序字段
    );
    $arrSort = array();
    foreach($array AS $uniqid => $row) {
        foreach($row AS $key=>$value) {
            $arrSort[$key][$uniqid] = $value;
        }
    }
    if($sort['direction']) {
        array_multisort($arrSort[$sort['field']], constant($sort['direction']), $array);
    }

    return $array;
}

function force_download($filename = '', $data = '')
{
    if ($filename == '' OR $data == '')
    {
        return FALSE;
    }


    $mime = 'image/png';

    // Generate the server headers
    if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== FALSE)
    {
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Content-Transfer-Encoding: binary");
        header('Pragma: public');
        header("Content-Length: ".strlen($data));
    }
    else
    {
        header('Content-Type: "'.$mime.'"');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: no-cache');
        header("Content-Length: ".strlen($data));
    }

    exit($data);
}

/**
 * 经典的概率算法2，兼容概率为小数，小于1的情况
 *
 * $proArr为预设数组
 */
function get_rand_new($prizeArr)
{
    $minPrize = min($prizeArr);
    $len = 0;
    if ($index = strpos($minPrize, '.') !== false)
    {
        $len = strlen(substr($minPrize, $index, -1));
    }
    $len += 2;
    $basenum = pow(10, $len);

    $min = 1;
    foreach ($prizeArr as $key => $value)
    {
        $max = $min + ($basenum * $value / 100) - 1;
        $prizeArr[$key] = array($min, $max);

        $min = $max + 1;
    }

    $randNum = rand(1, $basenum);
    $result = 0;

    foreach ($prizeArr as $key => $value)
    {
        if ($randNum >= $value[0] && $randNum <= $value[1])
        {
            $result = $key;
            break;
        }
    }

    return $result;
}

