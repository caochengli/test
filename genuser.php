<?php
/**
 * 生成用户数据并导入excel
 * User: ccl
 * Date: 2018/9/6
 * Time: 14:12
 */

include_once 'extension/phpexcel/PHPExcel.php';

$objPHPExcel = new \PHPExcel();

$num = 1;

$objPHPExcel->setActiveSheetIndex(0);
$objActSheet = $objPHPExcel->getActiveSheet();

//设置当前活动sheet的名称
$objActSheet->setTitle('Sheet1');


//设置单元格内容
$objActSheet->setCellValue('A'.$num, '姓名');
$objActSheet->setCellValue('B'.$num, '手机号');
$objActSheet->setCellValue('C'.$num, '身份证号');
$objActSheet->setCellValue('D'.$num, '员工编号');
$objActSheet->setCellValue('E'.$num, '入职岗位');
$objActSheet->setCellValue('F'.$num, '入职时间');

for ($i = 0; $i < 1000; $i++) {
    $num++;

    $objActSheet->setCellValue('A'.$num, getName());
    $objActSheet->setCellValue('B'.$num, getMobile());
    $objActSheet->setCellValue('C'.$num, getIdcard());
    $objActSheet->setCellValue('D'.$num, 'NO.'.($i+1));
    $objActSheet->setCellValue('E'.$num, '电工');
    $objActSheet->setCellValue('F'.$num, '2018-09-06 11:00');
}

// 自适应单元格宽度
$objActSheet->getColumnDimension('A')->setAutoSize(true);
$objActSheet->getColumnDimension('B')->setAutoSize(true);
$objActSheet->getColumnDimension('C')->setAutoSize(true);
$objActSheet->getColumnDimension('D')->setAutoSize(true);
$objActSheet->getColumnDimension('E')->setAutoSize(true);
$objActSheet->getColumnDimension('F')->setAutoSize(true);

$name = date('导入人才数据YmdHis');
header('Content-Type : application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$name.'.xls"');

$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');


// 获取名字
function getName($type=0)
{
    $name = '' ;
    switch($type)
    {
        case 1:    //2字
            $name = getXing().getMing();
            break;
        case 2:    //随机2、3个字
            $name = getXing().getMing();
            if(mt_rand(0,100)>50)$name .= getMing();
            break;
        case 3: //只取姓
            $name = getXing();
            break;
        case 4: //只取名
            $name = getMing();
            break;
        case 0:
        default: //默认情况 1姓+2名
            $name = getXing().getMing().getMing();


    }

    return $name;
}

// 随机生成手机号
function getMobile(){
    $arr = array(
        130,131,132,133,134,135,136,137,138,139,
        144,147,
        150,151,152,153,155,156,157,158,159,
        176,177,178,
        180,181,182,183,184,185,186,187,188,189,
    );
    $rs = $arr[array_rand($arr)].mt_rand(1000,9999).mt_rand(1000,9999);
    return $rs;
}

// 随机生成身份证号
function getIdcard() {
    $pow = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);//权重
    $szVerCode = array('1','0','X','9','8','7','6','5','4','3','2');//检验码
    $end = FALSE;
    $idcard = '440982' . date('Ymd' , rand(strtotime('1960-01-01') , time() - 18 * 86400 * 365));;
    do {
        if (strlen($idcard) < 18) {
            $idcard = str_pad($idcard , 18 , '0' , STR_PAD_RIGHT);
        }
        $last = substr($idcard , -4);
        $last++;
        if ($last > 9999) {
            $end = TRUE;
            return;
        }
        $idcard = substr($idcard , 0 , -4) . sprintf('%04d' , $last);
        if ($end) return;

        $total = 0;
        for ($i = 0, $len = strlen($idcard); $i < ($len-1) ; $i++) {
            $power = $idcard[$i] * $pow[$i];
            $total += $power;
        }
        $mod = $total % 11;
    }while(substr($idcard , 17 , 1) != $szVerCode[$mod]);
    return $idcard;
}

// 获取姓
function getXing()
{
    $arrXing=array(
        '赵','钱','孙','李','周','吴','郑','王','冯','陈','褚','卫','蒋',
        '沈','韩','杨','朱','秦','尤','许','何','吕','施','张','孔','曹','严','华','金','魏',
        '陶','姜','戚','谢','邹','喻','柏','水','窦','章','云','苏','潘','葛','奚','范','彭',
        '郎','鲁','韦','昌','马','苗','凤','花','方','任','袁','柳','鲍','史','唐','费','薛',
        '雷','贺','倪','汤','滕','殷','罗','毕','郝','安','常','傅','卞','齐','元','顾','孟',
        '平','黄','穆','萧','尹','姚','邵','湛','汪','祁','毛','狄','米','伏','成','戴','谈',
        '宋','茅','庞','熊','纪','舒','屈','项','祝','董','梁','杜','阮','蓝','闵','季','贾',
        '路','娄','江','童','颜','郭','梅','盛','林','钟','徐','邱','骆','高','夏','蔡','田',
        '樊','胡','凌','霍','虞','万','支','柯','管','卢','莫','柯','房','裘','缪','解','应',
        '宗','丁','宣','邓','单','杭','洪','包','诸','左','石','崔','吉','龚','程','嵇','邢',
        '裴','陆','荣','翁','荀','于','惠','甄','曲','封','储','仲','伊','宁','仇','甘','武',
        '符','刘','景','詹','龙','叶','幸','司','黎','溥','印','怀','蒲','邰','从','索','赖',
        '卓','屠','池','乔','胥','闻','莘','党','翟','谭','贡','劳','逄','姬','申','扶','堵',
        '冉','宰','雍','桑','寿','通','燕','浦','尚','农','温','别','庄','晏','柴','瞿','阎',
        '连','习','容','向','古','易','廖','庾','终','步','都','耿','满','弘','匡','国','文',
        '寇','广','禄','阙','东','欧','利','师','巩','聂','关','荆','司马','上官','欧阳','夏侯',
        '诸葛','闻人','东方','赫连','皇甫','尉迟','公羊','澹台','公冶','宗政','濮阳','淳于','单于',
        '太叔','申屠','公孙','仲孙','轩辕','令狐','徐离','宇文','长孙','慕容','司徒','司空');

    $numbXing = count($arrXing); //姓总数
    // mt_rand() 比rand()方法快四倍，而且生成的随机数比rand()生成的伪随机数无规律。
    return $arrXing[mt_rand(0,$numbXing-1)];

}

// 获取名字
function getMing()
{
    $arrMing=array(
        '伟','刚','勇','毅','俊','峰','强','军','平','保','东','文','辉','力','明','永','健','世','广','志','义',
        '兴','良','海','山','仁','波','宁','贵','福','生','龙','元','全','国','胜','学','祥','才','发','武','新',
        '利','清','飞','彬','富','顺','信','子','杰','涛','昌','成','康','星','光','天','达','安','岩','中','茂',
        '进','林','有','坚','和','彪','博','诚','先','敬','震','振','壮','会','思','群','豪','心','邦','承','乐',
        '绍','功','松','善','厚','庆','磊','民','友','裕','河','哲','江','超','浩','亮','政','谦','亨','奇','固',
        '之','轮','翰','朗','伯','宏','言','若','鸣','朋','斌','梁','栋','维','启','克','伦','翔','旭','鹏','泽',
        '晨','辰','士','以','建','家','致','树','炎','德','行','时','泰','盛','雄','琛','钧','冠','策','腾','楠',
        '榕','风','航','弘','秀','娟','英','华','慧','巧','美','娜','静','淑','惠','珠','翠','雅','芝','玉','萍',
        '红','娥','玲','芬','芳','燕','彩','春','菊','兰','凤','洁','梅','琳','素','云','莲','真','环','雪','荣',
        '爱','妹','霞','香','月','莺','媛','艳','瑞','凡','佳','嘉','琼','勤','珍','贞','莉','桂','娣','叶','璧',
        '璐','娅','琦','晶','妍','茜','秋','珊','莎','锦','黛','青','倩','婷','姣','婉','娴','瑾','颖','露','瑶',
        '怡','婵','雁','蓓','纨','仪','荷','丹','蓉','眉','君','琴','蕊','薇','菁','梦','岚','苑','婕','馨','瑗',
        '琰','韵','融','园','艺','咏','卿','聪','澜','纯','毓','悦','昭','冰','爽','琬','茗','羽','希','欣','飘',
        '育','滢','馥','筠','柔','竹','霭','凝','晓','欢','霄','枫','芸','菲','寒','伊','亚','宜','可','姬','舒',
        '影','荔','枝','丽','阳','妮','宝','贝','初','程','梵','罡','恒','鸿','桦','骅','剑','娇','纪','宽','苛',
        '灵','玛','媚','琪','晴','容','睿','烁','堂','唯','威','韦','雯','苇','萱','阅','彦','宇','雨','洋','忠',
        '宗','曼','紫','逸','贤','蝶','菡','绿','蓝','儿','翠','烟','小','轩');

    // 名总数
    $numbMing = count($arrMing);
    return $arrMing[mt_rand(0, $numbMing-1)];
}