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
	        $aSetting->setItem("/",'openoa_am',$_POST['am']);
	        $aSetting->setItem("/",'openoa_pm',$_POST['pm']);
	        $aSetting->setItem("/",'openoa_wxs',$_POST['wxs']);
	        $aSetting->setItem("/",'openoa_wxt',$_POST['wxt']);
	        
	        $this->view()->variables()->set('message', "保存成功" );
	        $this->location('?c=org.opencomb.openoa.Attendance.Setting');
	    }else {
	        $am = $aSetting->item("/",'openoa_am');
	        $pm = $aSetting->item("/",'openoa_pm');
	        $wxs = $aSetting->item("/",'openoa_wxs');
	        $wxt = $aSetting->item("/",'openoa_wxt');
	        
    	    $this->view()->variables()->set('am', $am );
    	    $this->view()->variables()->set('pm', $pm );
    	    $this->view()->variables()->set('wxs', $wxs );
    	    $this->view()->variables()->set('wxt', $wxt );
	    }
	    
	    
	}
}
