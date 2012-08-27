<?php

namespace org\opencomb\openoa\Attendance;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class Setting extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'打卡签到',
		'view' => array (
				'template' => 'Attendance/Setting.html',
		),
	) ;
	
	public function process()
	{
	    $aSetting = Extension::flyweight('openoa')->setting();
	    
	    if($_POST)
	    {
	        $am = $aSetting->setItem("/",'openoa_am',$_POST['am']);
	        $pm = $aSetting->setItem("/",'openoa_pm',$_POST['pm']);
	    }else {
	        $am = $aSetting->item("/",'openoa_am');
	        $pm = $aSetting->item("/",'openoa_pm');
	    }
	    
	    $this->view()->variables()->set('am', $am );
	    $this->view()->variables()->set('pm', $pm );
	}
}
