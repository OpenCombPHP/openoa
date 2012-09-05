<?php

namespace org\opencomb\openoa\office;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class DraftsDetail extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'已收消息',
		'view' => array (
				'template' => 'office/DraftsDetail.html',
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
        	    $oMessageModel->update( array(
        	            'draft'=>'0'        
                ),"id = {$this->params()->get('id')}");
        	    
	            $this->messageQueue ()->create ( Message::success, "发送成功" );
	        }else{
	    
	            $this->messageQueue ()->create ( Message::error, "用户不存在" );
	        }
	        $this->location('?c=org.opencomb.openoa.office.Outbox');
	    }
	    
	    $oModel = Model::create("openoa:message");
        $oModel->hasOne("openoa:EmployeeManagement","uid","uid","userinfo");
	    $oRow = $oModel->load( $this->params()->get('id') , 'id');
	    
	    $this->view()->variables()->set('row', $oRow );
	}
}
