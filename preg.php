<?php
include_once 'extension/PingYing.php';
$a = '<dl class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);"><dd class="swiper-slide swiper-slide-active" data-code="1"><span class="name" data-en-name="Electrical and Information Science and Technology">电气信息类</span></dd><dd class="swiper-slide swiper-slide-next" data-code="2"><span class="name" data-en-name="Electronic and Information Science">电子信息科学类</span></dd><dd class="swiper-slide" data-code="3"><span class="name" data-en-name="Instrument and Apparatus">仪器仪表类</span></dd><dd class="swiper-slide" data-code="4"><span class="name" data-en-name="Business Administration">工商管理类</span></dd><dd class="swiper-slide" data-code="5"><span class="name" data-en-name="Management Science and Engineering">管理科学与工程类</span></dd><dd class="swiper-slide" data-code="6"><span class="name" data-en-name="Economics">经济学类</span></dd><dd class="swiper-slide" data-code="7"><span class="name" data-en-name="Energy and Power">能源动力学</span></dd><dd class="swiper-slide" data-code="8"><span class="name" data-en-name="Educational Studies">教育学类</span></dd><dd class="swiper-slide" data-code="9"><span class="name" data-en-name="Science of Traffic &amp; Transportation">交通运输类</span></dd><dd class="swiper-slide" data-code="10"><span class="name" data-en-name="Aeronautics">航空航天类</span></dd><dd class="swiper-slide" data-code="11"><span class="name" data-en-name="Machinery">机械类</span></dd><dd class="swiper-slide" data-code="12"><span class="name" data-en-name="Statistical Sciences">统计学类</span></dd><dd class="swiper-slide" data-code="13"><span class="name" data-en-name="Science of Engineering Mechanics">工程力学类</span></dd><dd class="swiper-slide" data-code="14"><span class="name" data-en-name="Materials">材料类</span></dd><dd class="swiper-slide" data-code="15"><span class="name" data-en-name="Mathematics">数学类</span></dd><dd class="swiper-slide" data-code="16"><span class="name" data-en-name="Physical Sciences">物理学类</span></dd><dd class="swiper-slide" data-code="17"><span class="name" data-en-name="Chemical Sciences">化学类</span></dd><dd class="swiper-slide" data-code="18"><span class="name" data-en-name="Chinese Language &amp;Literature">中国语言文学类</span></dd><dd class="swiper-slide" data-code="19"><span class="name" data-en-name="Foreign Language &amp;Literature">外国语言文学类</span></dd><dd class="swiper-slide" data-code="20"><span class="name" data-en-name="Geological Sciences">地质学类</span></dd><dd class="swiper-slide" data-code="21"><span class="name" data-en-name="Geographical Science">地理科学类</span></dd><dd class="swiper-slide" data-code="22"><span class="name" data-en-name="Geophysics">地球物理学类</span></dd><dd class="swiper-slide" data-code="23"><span class="name" data-en-name="Atmospheric Sciences">大气科学类</span></dd><dd class="swiper-slide" data-code="24"><span class="name" data-en-name="Oceanographic Sciences">海洋科学类</span></dd><dd class="swiper-slide" data-code="25"><span class="name" data-en-name="Sciences of Mechanics">力学类</span></dd><dd class="swiper-slide" data-code="26"><span class="name" data-en-name="Journalism &amp; Communication">新闻传播学类</span></dd><dd class="swiper-slide" data-code="27"><span class="name" data-en-name="Material Science">材料科学类</span></dd><dd class="swiper-slide" data-code="28"><span class="name" data-en-name="Environmental Science">环境科学类</span></dd><dd class="swiper-slide" data-code="29"><span class="name" data-en-name="Psychological Sciences">心理学类</span></dd><dd class="swiper-slide" data-code="30"><span class="name" data-en-name="Law">法学类</span></dd><dd class="swiper-slide" data-code="31"><span class="name" data-en-name="Geological Prospecting and Mining">地矿类</span></dd><dd class="swiper-slide" data-code="32"><span class="name" data-en-name="Astronomy">天文学类</span></dd><dd class="swiper-slide" data-code="33"><span class="name" data-en-name="Art">艺术类</span></dd><dd class="swiper-slide" data-code="34"><span class="name" data-en-name="Historical Sciences">历史学类</span></dd><dd class="swiper-slide" data-code="35"><span class="name" data-en-name="Philosophical Sciences">哲学类</span></dd><dd class="swiper-slide" data-code="36"><span class="name" data-en-name="Civil Engineering and Architecture">土建类</span></dd><dd class="swiper-slide" data-code="37"><span class="name" data-en-name="Water Conservancy and Hydraulic Engineering">水利类</span></dd><dd class="swiper-slide" data-code="38"><span class="name" data-en-name="Science of Surveying &amp; mapping">测绘类</span></dd><dd class="swiper-slide" data-code="39"><span class="name" data-en-name="Preclinical Medicine">基础医学类</span></dd><dd class="swiper-slide" data-code="40"><span class="name" data-en-name="Clinical Medicine and Associated Medical Sciences">临床医学</span></dd><dd class="swiper-slide" data-code="41"><span class="name" data-en-name="Traditional Chinese Medicine">中医学类</span></dd><dd class="swiper-slide" data-code="42"><span class="name" data-en-name="Forensic Medicine">法医学类</span></dd><dd class="swiper-slide" data-code="43"><span class="name" data-en-name="Nursing Science">护理学类</span></dd><dd class="swiper-slide" data-code="44"><span class="name" data-en-name="Weapons Systems">武器类</span></dd><dd class="swiper-slide" data-code="45"><span class="name" data-en-name="Biological Sciences">生物科学类</span></dd><dd class="swiper-slide" data-code="46"><span class="name" data-en-name="Science of Chemical &amp; Pharmaceutical Engineering">化工与制药类</span></dd><dd class="swiper-slide" data-code="47"><span class="name" data-en-name="Biotechnology">生物工程类</span></dd><dd class="swiper-slide" data-code="48"><span class="name" data-en-name="Agricultural Engineering">农业工程类</span></dd><dd class="swiper-slide" data-code="49"><span class="name" data-en-name="Forestry Engineering">林业工程类</span></dd><dd class="swiper-slide" data-code="50"><span class="name" data-en-name="Public Security &amp; Technology">公安技术类</span></dd><dd class="swiper-slide" data-code="51"><span class="name" data-en-name="Plant Production Sciences">植物生产类</span></dd><dd class="swiper-slide" data-code="52"><span class="name" data-en-name="Pratacultural">草业科学类</span></dd><dd class="swiper-slide" data-code="53"><span class="name" data-en-name="Science OF Forest resources">森林资源类</span></dd><dd class="swiper-slide" data-code="54"><span class="name" data-en-name="Environmental and Ecological Sciences">环境生态类</span></dd><dd class="swiper-slide" data-code="55"><span class="name" data-en-name="Animal Production Sciences">动物生产类</span></dd><dd class="swiper-slide" data-code="56"><span class="name" data-en-name="Science of Veterinary  Medicine">动物医学类</span></dd><dd class="swiper-slide" data-code="57"><span class="name" data-en-name="Fishery Science">水产类</span></dd><dd class="swiper-slide" data-code="58"><span class="name" data-en-name="Science of Environment &amp; Satety Engineering">环境与安全类</span></dd><dd class="swiper-slide" data-code="59"><span class="name" data-en-name="Pharmacy">药学类</span></dd><dd class="swiper-slide" data-code="60"><span class="name" data-en-name="Science of Ocean Engineering">海洋工程类</span></dd><dd class="swiper-slide" data-code="61"><span class="name" data-en-name="Science of Textile &amp; food Engineering">轻工纺织食品类</span></dd><dd class="swiper-slide" data-code="62"><span class="name" data-en-name="Agricultural Economy Management">农业经济管理类</span></dd><dd class="swiper-slide" data-code="63"><span class="name" data-en-name="Public Administration">公共管理类</span></dd><dd class="swiper-slide" data-code="64"><span class="name" data-en-name="Science of Public Security">公安学类</span></dd><dd class="swiper-slide" data-code="65"><span class="name" data-en-name="Library and Archive Science">图书档案学类</span></dd><dd class="swiper-slide" data-code="66"><span class="name" data-en-name="Life Sciences">生命科学</span></dd><dd class="swiper-slide" data-code="67"><span class="name" data-en-name="Public Health">公共卫生学</span></dd><dd class="swiper-slide" data-code="68"><span class="name" data-en-name="Political Science">政治学类</span></dd><dd class="swiper-slide" data-code="69"><span class="name" data-en-name="Marxist Theoretical Studies">马克思主义理论类</span></dd><dd class="swiper-slide" data-code="70"><span class="name" data-en-name="Sociological Sciences">社会学类</span></dd><dd class="swiper-slide" data-code="71"><span class="name" data-en-name="Physical Education And Sports Science">体育学类</span></dd><dd class="swiper-slide" data-code="72"><span class="name" data-en-name="Others">其他</span></dd></dl>';

//preg_match('/<dd class="swiper-slide swiper-slide-active" data-code="\d+"><span class="name" data-en-name=".*">.*<\/span><\/dd>/i', $a, $match);

//preg_match_all('/<dd class="swiper-slide swiper-slide-active" data-code="(\d+)"><span class="name" data-en-name="(.*)">(.+)<\/span><\/dd>/i', $a, $match);
$a = strip_tags($a);
$arr = explode('类', $a);

$py = new PingYing;
$conn = conn();

$data = [];
foreach ($arr as  $row) {
    if (substr($row, -strlen($row)-1, 1) == '学') {
        $tmp = explode('学', $row);
        if (count($tmp) > 1) {
            foreach ($tmp as $r) {
                if ($r) {
                    $data[] = $r.'学';
                }

            }
        } else {
            $data[] = $row.'类';
        }
    }else {
        $data[] = $row.'类';
    }

}

foreach ($data as $row)
{
    $time = time();
    $simplepy = $py->getFirstPY($row);
    $allpy = $py->getAllPY($row);
    $sql = "INSERT INTO iwk_data.sys_major(pid,name, simplepy, allpy, `status`, `addtime`) "
        ."VALUES(0, '{$row}', '{$simplepy}', '{$allpy}', 1, {$time});";

    mysqli_query($conn, $sql);
}

/*echo '<pre>';
print_r($data);exit;*/


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
