<?php
namespace org\opencomb\openoa\PersonnelManagement\Contract;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class AddContract extends ControlPanel{
	public $arrConfig = array (
			'title' => '添加部门',
			'view' => array (
					'template' => 'PersonnelManagement/Contract/AddContract.html',
					'widgets'=>array(
							array(
									'id'=>'cid',
									'class'=>'text',
									'title'=>'合同编号',
							),
							array(
									'id'=>'uid',
									'class'=>'text',
									'title'=>'员工id',
							),
							array(
									'id'=>'hide_uid',
									'class'=>'text',
									'title'=>'员工id',
							),
							array(
									'id'=>'starttime',
									'class'=>'text',
									'title'=>'合同时间始',
							),
							array(
									'id'=>'endtime',
									'class'=>'text',
									'title'=>'合同时间止',
							),
							array(
									'id'=>'remindtime',
									'class'=>'text',
									'title'=>'合同时间止',
							),
					)
			),
// 			'perms' => array (
// 					// 权限类型的许可
// 					'perm.purview' => array (
// 							'name' => Water::WATER_CaiWu
// 					)
// 			)
	);
	
	public function process() {
		$sUid = $this->params['uid'];
		$sUserName = $this->params['username'];
		if($sUid && $sUserName)
		{
			$this->view->variables()->set('sUserName',$sUserName) ;
			$this->view->variables()->set('sUid',$sUid) ;
		}
		$this->doActions();
	}
	
	public function form(){
		if( empty($this->params['hide_uid']) )
		{
			$this->view->createMessage(Message::error,"%s 不能为空",'单位员工') ;
			return ;
		}
		
		$sCid = $this->params['cid'];
		$sUid = $this->params['hide_uid'];
		
		$sStartTime = strtotime($this->params['starttime']);
		//echo $sStartTime;exit;
		$sEndTime = strtotime($this->params['endtime']);
		$sRemindTime = strtotime($this->params['remindtime']);

		$aContractModel = Model::Create('openoa:ContractManagement');
		$aContractModel->load();
		
		$aContractModel->addRow(
				array(
						'cid' => $sCid
						,'uid' => $sUid
						,'starttime' => $sStartTime
						,'endtime' => $sEndTime
						,'remindtime' => $sRemindTime
				)
		);
		$nUpdateRows = $aContractModel->replace();
		
		$this->model('openoa:EmployeeManagement','employee');
		$this->employee->load();
		$this->employee->update(
				array('contract' => 1,)
				,'EmployeeManagement.uid ='.$sUid	
		);
		
		if($nUpdateRows > 0){
			$this->messageQueue()->create(Message::success,"添加合同成功") ;
			$this->location('?c=org.opencomb.openoa.PersonnelManagement.Contract.ContractManagement');
		}else{
			$this->view->createMessage(Message::error,"添加合同失败") ;
		}
	}	
}