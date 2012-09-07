<?php

namespace org\opencomb\openoa\process;

use org\jecat\framework\db\DB;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class DetailsRecord extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/DetailsRecord.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oModel = Model::create("openoa:Process_Record_Details");
        $oModel->hasOne("openoa:Process_Record","rid","id","record");
	    $oModel->load( array( $this->params()->get('rid')) , array('rid'));
	    
	    $aData = $oModel->alldata();
	    $setp = 1;
	    for($i = 0; $i < sizeof($aData); $i++){
	        
	        if($aData[$i]['type'] == "node")
	        {
	            $oRecordNodeModel = Model::create("openoa:Process_Node");
	            $oRecordNodeModel->hasOne('coresystem:group',"gid","gid");
	            $oRecordNodeModel->load( array( $aData[$i]['ids']) , array('id'));
	            $aData[$i]['name'] = "第".$setp."布：".$oRecordNodeModel['group.name'];
	            $setp++;
	        }
	        if($aData[$i]['type'] == "status")
	        {
	            $oRecordNodeModel = Model::create("openoa:Process_Status");
	            $oRecordNodeModel->load( array( $aData[$i]['ids']) , array('id'));
	            $aData[$i]['name'] = $oRecordNodeModel['name'];
	        }
	        
	    }
	    
	    $this->view()->variables()->set('list', $aData );
	}
}
