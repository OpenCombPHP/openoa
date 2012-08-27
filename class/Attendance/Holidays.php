<?php

namespace org\opencomb\openoa\Attendance;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class Holidays extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'打卡签到',
		'view' => array (
				'template' => 'Attendance/Holidays.html',
		),
	) ;
	
	public function process()
	{
	    $aSetting = Extension::flyweight('openoa')->setting();
	    
	    if($_POST)
	    {
	        $Holidays = $aSetting->setItem("/",'openoa_holidays',$_POST['Holidays']);
	    }else {
	        $Holidays = $aSetting->item("/",'openoa_holidays');
	    }
	    
	    $this->view()->variables()->set('Holidays', $Holidays );
	}
}
