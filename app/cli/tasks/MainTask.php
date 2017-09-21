<?php
namespace App\Cli\Tasks;


// use App\BaseController;
// use App\Models\SysuserAccount;

class MainTask extends \Phalcon\Cli\Task
{
    public function mainAction()
    {
        // $a = SysuserAccount::findFirst();
        // print_r($a->toArray());die;
        echo "Congratulations! You are now flying with Phalcon CLI!";
    }

}
