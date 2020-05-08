<?php

namespace Admin\Controller;

use Think\Controller;

class ContentController extends CommonController
{

    private $prefix;
    private $focus;
    private $Art;
    private $Prm;
    private $Cate;
    private $Catelis;

    public function _init()
    {
        $this->Art = M('content');
        $this->Cate = M('category');
        $this->Prm = M('product_prm');
        $this->focus = I('get.id');
        if (!empty($this->focus)) {
            $this->setFocus($this->focus);
        }
    }

    public function setFocus($id)
    {
        $this->assign('focusid', $id);
        $focusname = $this->Cate->where('id=' . $id)->getField('catename');
        $this->assign('focusname', $focusname);
        //模板查询
        $this->prefix = $this->Cate->where('id=' . $id)->getField('prefix');
        //子类树
        $catelis = $this->GPSon($id, session('user.catelev'));
        $this->Catelis = $catelis;
        $this->assign('catelis', $catelis);
    }

    public function article()
    {
        $id = $this->focus;
        //$this->setFocus($id);
        //$catelis = $this->GPSon($id,session('user.catelev'));
        //$this->assign('catelis',$catelis);
        //$Model = M('content');
        $parr = I('param.');
        if ($this->Catelis) {
            if (!empty($parr['cateid']) and $parr['cateid'] != -1) {
                $condition = "cateid=" . $parr['cateid'];
                $fullcondition = "cateid=" . $parr['cateid'];
            } else {
                foreach ($catelis as $q) {
                    $idarr .= $q['id'] . ',';
                }
                $idarr .= $id;
                $condition = "cateid in(" . $idarr . ")";
                $fullcondition = "cateid in(" . $idarr . ")";
            }
        } else {
            $condition = "1=1 and cateid=" . $id;
            $fullcondition = "1=1 and cateid=" . $id;
        }
        //dump($catelis);
        $maps = array();
        //dump($parr);
        foreach ($parr as $key => $val) {
            if ($val != "") {
                if ($key == 'title') {
                    $condition .= " and " . $key . " like '%" . urldecode($val) . "%'";
                    $fullcondition .= " and " . $key . " like '%" . urldecode($val) . "%'";
                } else if ($key == 'isgood' || $key == 'isfocus') {
                    if ($val != -1) {
                        $condition .= " and " . $key . "=" . $val;
                        $fullcondition .= " and " . $key . "=" . $val;
                    }
                }
                $maps[$key] = urldecode($val);
            }
        }
        //dump($field);
        //dump($condition);
        $count = $this->Art->where($fullcondition)->count();
        $Page = new \Think\Page($count, 20);
        foreach ($maps as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $pagination = $Page->show();

        //$field = $this->GetExtFields($this->temp);
        $field = "id,title,catename,defaultpic,taxis,addtime,isgood,isfocus";

        $rs = $this->Art->field($field)->where($condition)->order('isgood desc,isfocus desc,taxis desc,id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('rslist', $rs);
        $this->assign('pagination', $pagination);
        //dump($rs);
        $this->display($this->prefix . 'article');
    }

    public function addarticle($id)
    {
        $this->display($this->prefix . 'addarticle');
    }

    public function editarticle()
    {
        $doid = I('get.doid');
        $id = I('get.id');

        if (empty($doid)) {
            $this->error('操作错误：参数传递不完整，无法请求数据', U('/Index'), 5);
        }

        $rsmm = $this->Art->where('id=' . $doid)->find();
        //die($basefield);
        $this->assign('rsshow', $rsmm);
        //产品参数
        $rsprm = $this->Prm->where('aid=' . $doid)->select();
        $this->assign('rsprm', $rsprm);

        //图集
        $rspic = $this->Pic->where('sid=' . $doid)->order('taxis desc,id desc') ->select();
        $this->assign('rspic', $rspic);
        $this->display($this->prefix.'editarticle');
    }

    public function insarticle()
    {

        $data = I('post.');
        $data['catename'] = $this->Cate->where('id=' . $data['cateid'])->getField('catename');

        if (!empty($data['content']) and empty($data['shortcontent'])) {
            $data['shortcontent'] = chinesesubstr(SpHtml2Text($data['content']), 0, 400);
        }

        //产品参数
        $prmData = array();
        $prm_name = $data['prm_name'];
        $prm_val = $data['prm_val'];
        if (is_array($prm_name)) {
            foreach ($prm_name as $i => $q) {
                if (!empty($q) && !empty($prm_val[$i])) {
                    $prmData[] = array(
                        'prm_name' => $q,
                        'prm_val' => $prm_val[$i]
                    );
                }
            }
        }

        unset($data['prm_name'],$data['prm_val']);

        //处理组图
        $imgData = $this->getPicArrayData('picarr');
        unset($data['picarr'],$data['picarr_taxis'],$data['picarr_title'],$data['picarr_desc']);

        $isok = $this->Art->add($data);
        $backurl = U('/Content/article', array('id' => $data['bkid']));
        if ($isok) {
            $savename = date('Ymd').sprintf("%03d",$isok);
            $this->Art->where('id='.$isok)->setField('savename',$savename);
            if (count($prmData) > 0) {
                $prmDataRs = array();
                foreach ($prmData as $i=>$q){
                    $prmDataRs[$i] = $q;
                    $prmDataRs[$i]['aid'] = $isok;
                }
                $this->Prm->addAll($prmDataRs);
            }
            if (count($imgData) > 0) {
                $imgDataRs = array();
                foreach ($imgData as $i=>$q){
                    $imgDataRs[$i] = $q;
                    $imgDataRs[$i]['sid'] = $isok;
                }
                $this->Pic->addAll($imgDataRs);
            }
            $this->success("添加'" . $data['title'] . "'至" . $data['catename'] . "成功", $backurl, 5);
        } else {
            $this->error("添加'" . $data['title'] . "'至" . $data['catename'] . "失败", $backurl, 5);
        }

    }

    public function update()
    {
        $artData = I('post.');

        $artData['catename'] = $this->Cate->where('id=' . $artData['cateid'])->getField('catename');

        if (!empty($artData['content']) and empty($artData['shortcontent'])) {
            $artData['shortcontent'] = chinesesubstr(SpHtml2Text($artData['content']), 0, 400);
        }

        //产品参数
        $prmData = array();
        $prm_name = $artData['prm_name'];
        $prm_val = $artData['prm_val'];
        if (is_array($prm_name)) {
            foreach ($prm_name as $i => $q) {
                if (!empty($q) && !empty($prm_val[$i])) {
                    $prmData[] = array(
                        'aid' => $artData['doid'],
                        'prm_name' => $q,
                        'prm_val' => $prm_val[$i]
                    );
                }
            }
        }
        unset($artData['prm_name'],$artData['prm_val']);

        //处理组图
        $imgData = $this->getPicArrayData('picarr');
        unset($artData['picarr'],$artData['picarr_taxis'],$artData['picarr_title'],$artData['picarr_desc']);
        if(count($imgData) > 0){
            $imgDataRs = array();
            foreach($imgData as $i=>$q){
                $imgDataRs[$i] = $q;
                $imgDataRs[$i]['sid'] = $artData['doid'];
            }
        }

        $rs = $this->Art->where('id=' . $artData['doid'])->find();
        foreach ($rs as $key => $val) {
            if ($artData[$key] == $val) {
                unset($artData[$key]);
            }
        }
        $backurl = U('/Content/article', array('id' => $artData['bkid']));
        if (count($artData) > 0) {
            $this->Art->where('id=' . $artData['doid'])->save($artData);
        }

        //参数更新
        $this->Prm->where('aid='.$artData['doid'])->delete();
        $this->Prm->addAll($prmData);
        //图集更新
        $this->Pic->where('sid='.$artData['doid'])->delete();
        $this->Pic->addAll($imgDataRs);

        $this->success("编辑 '" . $artData['title'] . "' 成功", $backurl, 5);

    }

    public function updateproduct()
    {
        $data = I('post.');
        $data['catename'] = $this->Cate->where('id=' . $data['cateid'])->getField('catename');
        $backurl = U('/Content/article', array('id' => $data['bkid']));

        $prm_name = $data['prm_name'];
        $prm_val = $data['prm_val'];
        $actid = $data['doid'];
        unset($data['bkid'], $data['doid'], $data['prm_name'], $data['prm_val']);

        $rs = $this->Art->where('id=' . $actid)->find();
        foreach ($rs as $key => $val) {
            if ($data[$key] == $val) {
                unset($data[$key]);
            }
        }
        if (count($data) > 0) {
            $this->Art->where('id=' . $actid)->save($data);
        }

        //更新参数
        $this->Prm->where('gid=' . $actid)->delete();
        $prm_data = array();
        if (is_array($prm_name)) {
            foreach ($prm_name as $i => $q) {
                if (!empty($q) && !empty($prm_val[$i])) {
                    $prm_data[] = array(
                        'gid' => $actid,
                        'prm_name' => $q,
                        'prm_val' => $prm_val[$i]
                    );
                }
            }
        }
        if (count($prm_data) > 0) {
            $this->Prm->addAll($prm_data);
        }
        $this->success("编辑 '" . $artData['title'] . "' 成功", $backurl, 5);
    }

    public function page()
    {
        //$id = I('get.id');
        //$Model = M('category');
        $rs = $this->Cate->field('id,pid,catename,shortcontent,content')->where('id=' . $this->focus)->find();
        $this->assign('rs', $rs);
        //$this->setFocus($id);
        $this->display();
    }

    public function updatepage()
    {
        $data = I('post.');
        $data['content'] = I('post.content', '', false);
        $data['shortcontent'] = I('post.shortcontent', '', false);
        //$data['content'] = 'a';
        //$content = I('post.content','',false);
        //die($content);
        //$data['config'] = str_replace('&quot;','');
        $id = $data['doid'];
        //$Model = M('category');
        $isok = $this->Cate->where('id=' . $id)->save($data);
        if ($isok !== false) {
            $this->Redirect('/Content/page/id/' . $id);
        }
    }

    public function GetExtFields($temp)
    {
        //$M = M('content_extend');
        $M = new \Think\Model();
        //$rs = $M->query('SHOW COLUMNS FROM __CONTENT_EXTEND__');
        $rs = $M->query("select COLUMN_NAME from INFORMATION_SCHEMA.Columns where table_name='jw_content_extend' and table_schema='dongying'");
        $fields = '';
        if ($rs) {
            foreach ($rs as $q) {
                $mix = explode('_', $q['column_name']);
                $mixTemp = $mix[1];
                if (strpos($q['column_name'], $temp) || strpos($temp, $mixTemp)) {
                    if (!empty($fields)) {
                        $fields .= ',';
                    }
                    $fields .= 'b.' . $q['column_name'];
                }
            }
        }
        return $fields;
    }

    public function ArrayToString($arr)
    {
        $str = '';
        foreach ($arr as $i => $q) {
            if ($i == 0) {
                $str .= $q;
            } else {
                $str .= '|' . $q;
            }
        }
        return $str;
    }

    public function StringToArray($str)
    {
        $arr = array();
        $str = explode('|', $str);
        foreach ($str as $i => $q) {
            $arr[$i] = $q;
        }
        return $arr;
    }

    public function updateattr()
    {
        $type = I('get.type');
        $idarr = I('post.idarr');
        $attrarr = I('post.attrarr');
        $data[$type] = 0;
        //$do = explode();
        $updateok = 1;
        //$Model = M('content');
        foreach ($idarr as $i => $ids) {
            if ($attrarr[$i] == 0) {
                $data[$type] = 1;
            }
            $isok = $this->Art->where('id=' . $ids)->save($data);
            if ($isok === false) {
                $updateok = 0;
            }
        }
        if ($updateok == 0) {
            $output = array('type' => 'error', 'content' => '更新失败', 'url' => '');
        } else {
            $output = array('type' => 'ok', 'content' => '更新成功', 'url' => '');
        }
        echo json_encode($output);
    }

    public function delete()
    {
        $idarr = I('post.idarr');
        //$table = I('post.table');
        $Ext = M('product_prm');
        if (is_array($idarr)) {
            foreach ($idarr as $i => $q) {
                if ($i > 0) {
                    $p .= ",";
                }
                $p .= $q;
            }
            $idarr = $p;
        }
        $this->Art->where("id in(" . $idarr . ")")->delete();
        $Ext->where("aid in(" . $idarr . ")")->delete();
        //$this->set_ajaxres('ok', '删除成功', '');
        $res = array(
            'type' => 'ok',
            'msg' => '删除成功',
            'url' => ''
        );
        $this->ajaxReturn($res);
    }
}