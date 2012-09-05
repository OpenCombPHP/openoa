<?php

namespace org\opencomb\openoa\office;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class Send extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'打卡签到',
		'view' => array (
				'template' => 'office/Send.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    if( !empty($_POST['Submit']))
	    {
	        $oModel = Model::create("openoa:EmployeeManagement");
	        $oToUser = $oModel->load( $_POST['toname'] , 'name');
	        
	        if($oToUser->rowNum() > 0)
	        {
	            
	            
	            
	            
	            $oMessageModel = Model::create("openoa:message");
	            $oMessageModel->insert( array(
	                'uid'=>$uid,
	                'touid'=>$oToUser['uid'],
	                'title'=>$_POST['title'],
	                'content'=>$_POST['content'],
	                'draft'=>$_POST['draft'],
	                'type'=>'msg',
	                'date'=>time()       
                ));
	            $this->messageQueue ()->create ( Message::success, "发送成功" );
	        }else{
	            
	            $this->messageQueue ()->create ( Message::error, "用户不存在" );
	        }
            $this->location('?c=org.opencomb.openoa.office.Send');
	    }
	    
	}
}
