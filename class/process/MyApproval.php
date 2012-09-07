<?php

namespace org\opencomb\openoa\process;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class MyApproval extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/MyApproval.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oGroupModel = Model::create("coresystem:group_user_link");
	    $oGroupModel->load($uid,"uid");
	    $aUGroup = array();
	    foreach ($oGroupModel as $rGroup){
	        $aUGroup[] = $rGroup['gid'];
	    }
	    
	    $oRecordModel = Model::create("openoa:Process_Record");
	    $oRecordModel->hasOne("openoa:EmployeeManagement" ,"uid","uid","user");
	    $oRecordModel->hasOne("openoa:Process_Task" ,"tid","id","task");
	    $oRecordModel->hasOne("openoa:Process_Node" ,"nowNid","id","node");
	    $oRecordModel->hasMany("openoa:Process_Status" ,"nowNid","nid","stat");
	    $oRecordModel->where("node.gid in(".implode(",", $aUGroup).")");
	    $oList = $oRecordModel->load( );
	    
	    $this->view()->variables()->set('list', $oList );
	}
}
