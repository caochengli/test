<?php

    function cateLinks($id){
        $cate = M('category');
        $dirname = $cate->where('id='.$id)->getField('dirname');
        return C('SITE_URL').'/'.$dirname.'/index.html';
    }

    function emnick($str)
    {//昵称转换
        $str = str_replace("\"", "", $str);
        $str = '{"result_str":"' . $str . '"}'; //JSON格式
        $strarray = json_decode($str, true);
        return $strarray['result_str'];
    }

    function nickname($str)
    {
        $tmpStr = json_encode($str);
        $tmpStr = preg_replace("#(\\\ue[0-9a-f]{3})#ie", "addslashes('\\1')", $tmpStr);
        return $tmpStr;
    }

    function randpw($len = 8, $format = 'ALL')
    {

        $is_abc = $is_numer = 0;

        $password = $tmp = '';

        switch ($format) {

            case 'ALL':

                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

                break;

            case 'CHAR':

                $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                break;

            case 'NUMBER':

                $chars = '0123456789';

                break;

            default :

                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

                break;

        }

        mt_srand((double)microtime() * 1000000 * getmypid());

        while (strlen($password) < $len) {

            $tmp = substr($chars, (mt_rand() % strlen($chars)), 1);

            if (($is_numer <> 1 && is_numeric($tmp) && $tmp > 0) || $format == 'CHAR') {

                $is_numer = 1;

            }

            if (($is_abc <> 1 && preg_match('/[a-zA-Z]/', $tmp)) || $format == 'NUMBER') {

                $is_abc = 1;

            }

            $password .= $tmp;

        }

        if ($is_numer <> 1 || $is_abc <> 1 || empty($password)) {

            $password = randpw($len, $format);

        }

        return $password;

    }

    function seoFun($t, $s)
    {
        switch ($t) {
            case 't':
                $defaultRes = C('SITE_TITLE');
                break;
            case 'k':
                $defaultRes = C('SITE_KEYWORDS');
                break;
            case 'd':
                $defaultRes = C('SITE_DESC');
                break;
        }
        if (!empty($s)) {
            $defaultRes = $s;
        }
        return $defaultRes;
    }

    function skipstr($str, $h = 'p', $s = '')
    {
        $str = explode('|', $str);
        foreach ($str as $q) {
            $strRes .= "<" . $h . " class='" . $s . "'>" . $q . "</" . $h . ">";
        }
        return $strRes;
    }

    function getConfigList($s = 'qq', $exp = 1)
    {
        switch ($s) {
            case 'qq':
                $str = C('SITE_WORK_QQ');
                break;
            case 'phone':
                $str = C('SITE_WORK_TEL');
                break;
        }
        $rs = explode('|', $str);
        if ($s == 'qq' || $exp == 2) {
            foreach ($rs as $i => $q) {
                $res[$i] = explode('：', $q);
            }
        } else {
            $res = $rs;
        }
        return $res;
    }

    function getFirstCharter($str)
    {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'gb2312', $str);
        $s2 = iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) return 'A';
        if ($asc >= -20283 && $asc <= -19776) return 'B';
        if ($asc >= -19775 && $asc <= -19219) return 'C';
        if ($asc >= -19218 && $asc <= -18711) return 'D';
        if ($asc >= -18710 && $asc <= -18527) return 'E';
        if ($asc >= -18526 && $asc <= -18240) return 'F';
        if ($asc >= -18239 && $asc <= -17923) return 'G';
        if ($asc >= -17922 && $asc <= -17418) return 'H';
        if ($asc >= -17417 && $asc <= -16475) return 'J';
        if ($asc >= -16474 && $asc <= -16213) return 'K';
        if ($asc >= -16212 && $asc <= -15641) return 'L';
        if ($asc >= -15640 && $asc <= -15166) return 'M';
        if ($asc >= -15165 && $asc <= -14923) return 'N';
        if ($asc >= -14922 && $asc <= -14915) return 'O';
        if ($asc >= -14914 && $asc <= -14631) return 'P';
        if ($asc >= -14630 && $asc <= -14150) return 'Q';
        if ($asc >= -14149 && $asc <= -14091) return 'R';
        if ($asc >= -14090 && $asc <= -13319) return 'S';
        if ($asc >= -13318 && $asc <= -12839) return 'T';
        if ($asc >= -12838 && $asc <= -12557) return 'W';
        if ($asc >= -12556 && $asc <= -11848) return 'X';
        if ($asc >= -11847 && $asc <= -11056) return 'Y';
        if ($asc >= -11055 && $asc <= -10247) return 'Z';
        return null;
    }

    /*
    ## SetCateLink
    ## 栏目链接
    ## @param int $id 栏目ID
    ## @return $linkstr string
    */
    function SetCateLink($id)
    {
        $linkstr = '';
        $Model = M('Category');
        $rs = $Model->field('id,pid,model,links')->where('id=' . $id)->find();
        if ($rs) {
            if ($rs['links'] == 'http://') {
                switch ($rs['model']) {
                    case 0:
                        $url = U('/Page/index', array('id' => $rs['id']));
                        break;
                    case 1:
                        $url = U('/Article/index', array('id' => $rs['id']));
                        break;
                }
                $linkstr = $url;
            } else {
                $linkstr = $rs['links'];
            }
        }
        return $linkstr;
    }

    function SpHtml2Text($str)
    {
        $str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU", "", $str);
        $alltext = "";
        $start = 1;
        for ($i = 0; $i < strlen($str); $i++) {
            if ($start == 0 && $str[$i] == ">") {
                $start = 1;
            } else if ($start == 1) {
                if ($str[$i] == "<") {
                    $start = 0;
                    $alltext .= " ";
                } else if (ord($str[$i]) > 31) {
                    $alltext .= $str[$i];
                }
            }
        }
        $alltext = str_replace("　", " ", $alltext);
        $alltext = preg_replace("/&([^;&]*)(;|&)/", "", $alltext);
        $alltext = preg_replace("/[ ]+/s", " ", $alltext);
        return $alltext;
    }

    function chinesesubstr($str, $start, $len)
    { // $str指字符串,$start指字符串的起始位置，$len指字符串长度
        $str = SpHtml2Text($str);
        $strlen = $start + $len; // 用$strlen存储字符串的总长度，即从字符串的起始位置到字符串的总长度
        for ($i = $start; $i < $strlen;) {
            if (ord(substr($str, $i, 1)) > 0xa0) { // 如果字符串中首个字节的ASCII序数值大于0xa0,则表示汉字
                $tmpstr .= substr($str, $i, 3); // 每次取出三位字符赋给变量$tmpstr，即等于一个汉字
                $i = $i + 3; // 变量自加3
            } else {
                $tmpstr .= substr($str, $i, 1); // 如果不是汉字，则每次取出一位字符赋给变量$tmpstr
                $i++;
            }
        }
        if (strlen($str) > $len) {
            $tmpstr .= '…';
        }
        return $tmpstr; // 返回字符串
    }

?>