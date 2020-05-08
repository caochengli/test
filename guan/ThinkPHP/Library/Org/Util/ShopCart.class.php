<?php
namespace Org\Util;
/*
  ## ShopCart
  ## 购物车类
  ## 管理购物车商品
*/

class ShopCart{

    public function __construct() {
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = array();
        }
    }
	 
    /*
    添加商品
    param int $id 商品主键
          string $name 商品名称
          float $price 商品价格
          int $num 购物数量
    */
    public  function addItem($id,$arr) {
        //如果该商品已存在则直接加其数量
        if (isset($_SESSION['cart'][$id])) {
            //$this->incNum($id,$num);
            return;
        }
		//清空购物车
	    session('order_flag_num',null);
	    session('cartitem',null);
        $item = array();
        $_SESSION['cart'][$id] = $arr;
    }
 
    /*
    修改购物车中的商品数量
    int $id 商品主键
    int $num 某商品修改后的数量，即直接把某商品
    的数量改为$num
    */
    public function modNum($id,$num=1) {
        if (!isset($_SESSION['cart'][$id])) {
            return false;
        }
        $_SESSION['cart'][$id]['num'] = $num;
    }
 
    /*
    商品数量+1
    */
    public function incNum($id,$num=1) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['num'] += $num;
        }
    }
 
    /*
    商品数量-1
    */
    public function decNum($id,$num=1) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['num'] -= $num;
        }
 
        //如果减少后，数量为0，则把这个商品删掉
        if ($_SESSION['cart'][$id]['num'] <1) {
            $this->delItem($id);
        }
    }
 
    /*
    删除商品
    */
    public function delItem($id) {
        session('order_flag_num',null);
	    session('cartitem',null);
		unset($_SESSION['cart'][$id]);
    }
     
    /*
    获取单个商品
    */
    public function getItem($id) {
        return $_SESSION['cart'][$id];
    }
 
    /*
    查询购物车中商品的种类
    */
    public function getCnt() {
        return count($_SESSION['cart']);
    }
     
    /*
    查询购物车中商品的个数
    */
    public function getNum(){
        if ($this->getCnt() == 0) {
            //种数为0，个数也为0
            return 0;
        }
 
        $sum = 0;
        $data = $_SESSION['cart'];
        foreach ($data as $item) {
            $sum += $item['num'];
        }
        return $sum;
    }
 
    /*
    购物车中商品的总金额
    */
    public function getPrice() {
        //数量为0，价钱为0
        if ($this->getCnt() == 0) {
            return 0;
        }
        $price = 0.00;
        $data = $_SESSION['cart'];
        foreach ($data as $item) {
            $price += $item['goods_price'];
        }
        return sprintf("%01.2f", $price);
    }
	
	/*
	  ## getItemattr
	  ## 购物车商品属性
	*/
	public function getItemattr($id,$field='goods_name'){
	   return $_SESSION['cart'][$id][$field];
	}
 
    /*
    清空购物车
    */
    public function clear() {
        $_SESSION['cart'] = array();
    }
}