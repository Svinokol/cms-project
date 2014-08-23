<?php
/**
 * Created by PhpStorm.
 * User: efim
 * Date: 04.02.14
 * Time: 17:08
 */
namespace install
{
    function main(\ConfigController $configController)
    {
        $configController->setValue("install","1");
        $configController->setValue("template_name","Clear");
        $configController->setValue("template_main","main.tpl");
        $configController->save();
    }
}

?>