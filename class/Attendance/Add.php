<?php

namespace org\opencomb\openoa\Attendance;

use org\opencomb\openoa\controller\OpenOaController;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

class Add extends OpenOaController
{
    
    
	protected $arrConfig = array
	(
		'title'=>'打卡签到',
		'view' => array (
				'template' => 'Attendance/Add.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    if($_POST)
	    {
    	    /*$aSort = array(
                '1'=>'事假',
                '2'=>'病假',
                '3'=>'婚假',
                '4'=>'产假',
                '5'=>'探亲假',
                '6'=>'丧假',
                '7'=>'年假',
                '8'=>'出差',
                '9'=>'外出',
                '10'=>'调休',
                '11'=>'旷工',
                '12'=>'加班',
            );*/
    	    
    	    $oModel = Model::create("openoa:attendance_detail"); 
    	            
            $aRs = array(
                'uid'=>$uid,
                'date'=>$_POST['date'],
                'am'=>$_POST['am'],
                'pm'=>$_POST['pm'],
                'sort'=>$_POST['sort'],
                'explain'=>$_POST['explain'],
            );
            $oModel->insert( $aRs);
            $this->view()->variables()->set('message', "保存成功" );
            $this->location('?c=org.opencomb.openoa.Attendance.Detail');
	    }
	        
	}
}
