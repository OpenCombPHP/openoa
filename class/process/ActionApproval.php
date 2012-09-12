<?php

namespace org\opencomb\openoa\process;

use org\opencomb\openoa\process\api\Process;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class ActionApproval extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'',
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oProcess = new Process();
	    if( $oProcess->ActionApproval( $this->params()->get('rid'), $this->params()->get('sid')))
	    {
	        $this->messageQueue ()->create ( Message::success, "保存成功" );
	        $this->location('?c=org.opencomb.openoa.process.MyApproval');
	    }else{
	        $this->messageQueue ()->create ( Message::success, "保存失败" );
	        $this->location('?c=org.opencomb.openoa.process.MyApproval');
	    }
	}
}
