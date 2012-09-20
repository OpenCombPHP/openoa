<?php

namespace org\opencomb\openoa\process;

use org\jecat\framework\db\DB;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class DetailApproval extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/DetailApproval.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oRecordModel = Model::create("openoa:Process_Record","record");
	    $oRecordModel->hasOne("openoa:Process_Node" ,"nowNid","id","node");
	    $oRecordModel->hasMany("openoa:Process_Status" ,"nowNid","nid","stat");
	    $oRecordModel->where("record.id = {$this->params()->get('rid')}");
	    $oList = $oRecordModel->load( )->alldata();
	    
	    for($i = 0; $i < sizeof($oList); $i++)
	    {
	        if($oList[$i]['nowNid'] > 0)
	        {
	            $aGroupModel = Model::create('coresystem:group');
	            $aGroupModel->load($oList[$i]['node.gid'],'gid');
	            $oList[$i]['statname'] = "等待(".$aGroupModel['name'].")审核";
	        }elseif($oList[$i]['nowNid'] == "-1"){
	            $oList[$i]['statname'] = "完成";
	        }elseif($oList[$i]['nowNid'] == "-2"){
	            $oList[$i]['statname'] = "拒绝";
	        }elseif($oList[$i]['nowNid'] == "-3"){
	            $oList[$i]['statname'] = "终止";
	        }
	    }
	    
	    $this->view()->variables()->set('row', $oList );
	}
}
