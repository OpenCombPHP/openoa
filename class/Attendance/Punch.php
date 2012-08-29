<?php

namespace org\opencomb\openoa\Attendance;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class Punch extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'打卡签到',
		'view' => array (
				'template' => 'Attendance/Punch.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId();
	    
	    $oModel = Model::create("openoa:attendance_detail"); 
	    $oData = $oModel->load( array( $uid, date("Y-m-d")),array( 'uid', 'date'));
	    
	    if( empty($_GET["a"]) )
	    {
	        $this->view()->variables()->set('data', $oData);
	        return ;
	        
	    }else{
	        if( $oData->rowNum() > 0 )
	        {
                $aRs = array(
                        $_GET["a"]=>date("H:i:s"),
                );
	            $oModel->update( $aRs , "date = '".date('Y-m-d')."' AND uid='{$uid}'");
	        }else{
	            
                $aRs = array(
	                'uid'=>$uid,
	                'date'=>date("Y-m-d"),
	                $_GET["a"]=>date("H:i:s"),
	            );
    	        $oModel->insert( $aRs);
	        }
	        
	        
	    }
	    $this->view()->variables()->set('message', "打卡成功" );
	}
}
