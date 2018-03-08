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
echo add(1.5, 2.6);