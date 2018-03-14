<?php
/**
 * 扣税工资计算
 * User: ccl
 * Date: 2018/3/14
 * Time: 11:45
 */

include_once 'common_function.php';


$money = getUserTaxfee(12308);
echo $money;

/**
 *  获取税费
 *
 * 应纳税所得额 = 劳务报酬（少于4000元）- 800元
   应纳税所得额 = 劳务报酬（超过4000元） × （1 - 20%）
  应纳税额 = 应纳税所得额 × 适用税率 - 速算扣除数
（1）不超过20,000元的，税率20%，速算扣除数为0；
（2）超过20,000元到50,000元的部分，税率30%，速算扣除数为2,000；
（3）超过50,000元的部分，税率 40%，速算扣除数为7,000；
 */
function getUserTaxfee($salary)
{
    // 应纳税所得额
    if ($salary <= 800)
    {
        $tax_income = 0.00;
    }
    else if ($salary <= 4000)
    {
        $tax_income = smath($salary, 800.00, '-', 2);
    }
    else if ($salary > 4000)
    {
        $tax_income = smath($salary, 0.8, '*', 2);
    }

    // 不超过20000元的
    if ($tax_income <= 20000)
    {
        $tax_percent = 0.2;
        $susuan = 0.00;
    }
    // 超过20000元到50000元的部分
    else if ($tax_income > 20000 && $tax_income <= 50000)
    {
        $tax_percent = 0.3;
        $susuan = 2000.00;
    }
    // 超过50000
    else if ($tax_income > 50000)
    {
        $tax_percent = 0.4;
        $susuan = 7000.00;
    }

    // 全部税费
    $all_taxfee = gettaxfee($tax_income, $tax_percent, $susuan);

    $actualmoney = smath($salary, $all_taxfee, '-', 2);

    return $actualmoney;
}

/**
 * 应纳税额 = 应纳税所得额 × 适用税率 - 速算扣除数
 */
function gettaxfee($tax_income = 0.00, $tax_percent = 0.00, $susuan = 0.00)
{
    $taxfeetmp = smath($tax_income, $tax_percent, '*', 2);
    $taxfee = smath($taxfeetmp, $susuan, '-', 2);

    if ($taxfee < 0)
    {
        $taxfee = 0.00;
    }

    return $taxfee;
}