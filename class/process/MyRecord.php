<?php

namespace org\opencomb\openoa\process;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class MyRecord extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/MyRecord.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oRecordModel = Model::create("openoa:Process_Record");
	    $oRecordModel->hasOne("openoa:Process_Task" ,"tid","id","task");
	    $oRecordModel->hasOne("openoa:Process_Node" ,"nowNid","id","node");
	    $oList = $oRecordModel->load( array($uid), array("uid"))->alldata();
	    
	    for($i = 0; $i < sizeof($oList); $i++){
	        
	        if($oList[$i]['nowNid'] > 0)
	        {
	            $aGroupModel = Model::create('coresystem:group');
	            $aGroupModel->load($oList[$i]['node.gid'],'gid');
	            $oList[$i]['stat'] = "等待(".$aGroupModel['name'].")审核";
	        }elseif($oList[$i]['nowNid'] == "-1"){
	            $oList[$i]['stat'] = "完成";
	        }elseif($oList[$i]['nowNid'] == "-2"){
	            $oList[$i]['stat'] = "拒绝";
	        }elseif($oList[$i]['nowNid'] == "-3"){
	            $oList[$i]['stat'] = "终止";
	        }
	        
	    }
	    $this->view()->variables()->set('list', $oList );
	}
}
