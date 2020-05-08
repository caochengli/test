<?php

namespace Admin\Controller;

use Overtrue\Pinyin\Pinyin;
use Think\Controller;

class CategoryController extends CommonController
{

    private $Pinyin;
    private $Cate;

    public function _init()
    {
        $rscate = categorytree('category');
        $this->assign('catelis', $rscate);
        $this->Pinyin = new Pinyin();
        $this->Cate = M('category');
    }

    public function add()
    {
        $this->display();
    }

    /*  edit
     ## 编辑分类
     ## @return empty
    */
    public function edit()
    {
        $id = I('get.id');
        if (empty($id)) {
            $this->error('抱歉，参数不完整，操作失败！', U('/Category'), 5);
        }
        $rs = $this->Cate->where('id=' . $id)->find();
        //$rs['focusid'] = $id;
        $rsmm = $this->Cate->where('pid=' . $id)->find();
        $rs['isson'] = ($rsmm) ? 1 : 0;
        $dirarr = $this->dirPart($rs['dirname']);
        $rs['dirname'] = $dirarr;
        $this->assign('rs', $rs);
        $this->display();
    }

    public function dirPart($dirname){
        $len = strripos($dirname,'/');
        //$res = $dirname;
        if($len){
            $res = array(
                'prefix' => substr($dirname,0,$len+1),
                'realname' => substr($dirname,$len+1)
            );
        }else{
            $res = array(
                'prefix' => '',
                'realname' => $dirname
            );
        }
        return $res;
    }

    /*  insert
     ## 写入分类
     ## @return empty
    */
    public function insert()
    {
        //$this->success('操作失败',U('/Category'),50);
        $data = I('post.');
        $data['content'] = I('post.content', '', false);
        $data['shortcontent'] = I('post.shortcontent', '', false);
        $pid = $data['pid'];
        if (empty($data['taxis'])) {
            $data['taxis'] = 0;
        }
        if (empty($data['dirname'])) {
            $data['dirname'] = $this->Pinyin->abbr($data['catename']);
        }

        if ($pid != 0) {
            $rs = $this->Cate->field('dirname,level')->where('id=' . $pid)->find();
            $data['level'] = $rs['level'] + 1;
            $data['dirname'] = $rs['dirname'].'/'.$data['dirname'];
        }

        if (empty($data['pagesize']) || $data['pagesize'] < 0) {
            $data['pagesize'] = 20;
        }

        $isok = $this->Cate->add($data);
        if ($isok) {
            $isdir = $this->Help->creatDir($data['dirname']);
            if($isdir){
                $this->success('新增分类信息成功', U('/Category'), 5);
            }else{
                $this->success('新增分类信息成功，但是创建目录失败', U('/Category'), 5);
            }
        } else {
            $this->error('新增分类信息失败', U('/Category'), 5);
        }
        //echo json_encode($output);
    }

    /*  update
     ## 更新分类
     ## @return empty
    */
    public function update($id)
    {
        $data = I('post.');
        $catename = $data['catename'];

        $dirname = empty($data['dirname']) ? $this->Pinyin->abbr($catename) : $data['dirname'];
        $data['dirname'] = empty($data['abprefix']) ? $dirname : $data['abprefix'].$dirname;
        unset($data['abprefix']);

        $pid = $data['pid'];
        $data['content'] = I('post.content', '', false);
        $data['shortcontent'] = I('post.shortcontent', '', false);

        //$pdir = $this->Cate->where('pid='.$data['pid'])->getField('dirname');
        //$data['dirname'] = $pdir.'/'.$data['dirname'];

        $rs = $this->Cate->where('id='.$id)->find();

        foreach($rs as $key => $val){
            if($data[$key] == $val){
                unset($data[$key]);
            }
        }

        if(count($data) > 0){
            if(array_key_exists('pid',$data)){
                //操作了父类
                if($data['pid'] == 0){
                    $data['level'] = 0;
                    $data['dirname'] = $dirname;
                }else{
                    $rsnew = $this->Cate->field('dirname,level')->where('id='.$data['pid'])->find();
                    $data['level'] = $rsnew['level'] + 1;
                    $data['dirname'] = $rsnew['dirname'].'/'.$dirname;
                }
            }else{
                if(array_key_exists('dirname',$data)){
                    /*$rsnew = $this->Cate->field('dirname')->where('id='.$pid)->find();
                    if((int)$pid !== 0){
                        $data['dirname'] = $rsnew['dirname'].'/'.$data['dirname'];
                    }else{
                        $rsnew = $this->Cate->field('dirname')->where('id='.$id)->find();
                    }*/
                    $rsnew = $this->Cate->field('dirname')->where('id='.$id)->find();
                    $this->replaceChildDirName($id,$rsnew['dirname'],$data['dirname']);
                }
            }
            $isok = $this->Cate->where('id=' . $id)->save($data);
            if($isok !== false){
                $isdir = $this->Help->creatDir($data['dirname']);
                if($isdir){
                    $this->success('更新分类信息成功', U('/Category'), 5);
                }else{
                    $this->success('更新分类信息成功，但是创建目录失败', U('/Category'), 5);
                }
            }else{
                $this->error('更新分类信息失败', U('/Category'), 5);
            }
        }else{
            $this->success('更新分类信息成功', U('/Category'), 5);
        }
    }

    public function replaceChildDirName($id,$str1,$str2){
        $idarr = $this->GetSonArr($id);
        $sql = "update jw_category set dirname=replace(dirname,'".$str1."','".$str2."') where id in(".$idarr.")";
        $Model = new \Think\Model();
        $row = $Model->execute($sql);
        $result = ($row === false) ? $row : true;
        return $result;
        //$rs = $this->Cate->field('dirname')->where('id in('.$idarr.')')->select();
    }

    public function showdir()
    {
        $type = I('get.type');
        $dir = APP_PATH . 'Home/View/' . $type . '/';
        //echo $dir;
        $f = @ opendir($dir);
        $err = 0;
        $i = 0;
        while (($file = readdir($f)) != false) {
            $i++;
            if (!($file == '.' || $file == '..')) {
                $output .= "<div class='callout callout-light'><a href='javascript:void(0);' onclick='javascript:settemp(this);' data-temp='" . $file . "'>" . $file . "</a></div>";
            }
        }
        if ($i <= 1) {
            $err = 1;
            $output = "<div class='callout callout-danger'>未能在" . $type . "目录找到模板文件</div>";
        }
        closedir($f);
        //echo $output;
        $ret = array('err' => $err, 'Htm' => $output);
        $this->ajaxReturn($ret);
    }

    public function checkextends()
    {
        $id = I('get.id');
        $rs = $this->Cate->field('isextends,listtemp,contenttemp')->where('id=' . $id)->find();
        $output = array('type' => 'error');
        if ($rs) {
            if ($rs['isextends'] == 1) {
                $output = array('type' => 'ok', 'listtemp' => $rs['listtemp'], 'contenttemp' => $rs['contenttemp']);
            } else {
                $output = array('type' => 'error');
            }
        }
        echo json_encode($output);
    }

}