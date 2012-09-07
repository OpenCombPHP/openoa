<?php

namespace org\opencomb\openoa\process;

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
	    
	    $oStatusModel = Model::create("openoa:Process_Status");
	    $oStatusRow = $oStatusModel->load( array($this->params()->get('sid')), array("id"));
	    
	    $oRecordModel = Model::create("openoa:Process_Record");
	    $oRecordModel->update(array(
	            'nowNid'=>$oStatusRow['tonid'],
        ),"id = ".$this->params()->get('rid'));
	    
	    
	    $oRecordDetailsModel = Model::create("openoa:Process_Record_Details");
	    $oRecordDetailsModel->insert(array(
	            'rid'=>$this->params()->get('rid'),
	            'ids'=>$this->params()->get('sid'),
	            'type'=>'status',
	            'datetime'=>date("Y-m-d H:i:s"),
	    ));
	    
	    $oRecordDetailsModel->insert(array(
	        'rid'=>$this->params()->get('rid'),        
	        'ids'=>$oStatusRow['tonid'],        
	        'type'=>'node',        
	        'datetime'=>date("Y-m-d H:i:s"),        
        ));
	    
	    $this->messageQueue ()->create ( Message::success, "成功" );
	    $this->location('?c=org.opencomb.openoa.process.MyApproval');
	    
	}
}
