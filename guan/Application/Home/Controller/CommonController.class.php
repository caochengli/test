<?php

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller
{
    protected $Help;
    protected $WebUser;

    public function _initialize()
    {
        $this->Help = A('Help');
        if(!S('navbar')){
            $navbar = $this->Help->GetSubMenu(0);
            S('navbar',$navbar);
        }
        $this->assign('navbar',S('navbar'));

        $friend = $this->Help->SuperSlide(5);
        $this->assign('rsfriend',$friend);

        $this->autoLoad();
    }

    public function autoLoad()
    {

    }

}