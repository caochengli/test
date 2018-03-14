<?php
/**
 * php7特性
 * User: ccl
 * Date: 2018/3/8
 * Time: 10:55
 */

/**
 * 1.类型的声明。
 *
 * 可以使用字符串(string), 整数 (int), 浮点数 (float), 以及布尔值 (bool)，来声明函数的参数类型与函数返回值。
*/

declare(strict_types=1);
function add(int $a, int $b): int {
    return $a+$b;
}

echo add(1, 2);
//echo add(1.5, 2.6); // php7会报错

/**
 * 2.set_exception_handler() 不再保证收到的一定是 Exception 对象
 *
 *  在 PHP 7 中，很多致命错误以及可恢复的致命错误，都被转换为异常来处理了。 这些异常继承自 Error 类，此类实现了 Throwable 接口 （所有异常都实现了这个基础接口）。
*/