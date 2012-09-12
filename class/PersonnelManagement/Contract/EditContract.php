<?php
namespace org\opencomb\openoa\PersonnelManagement\Contract;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class EditContract extends OpenOaController{
	public $arrConfig = array (
			'title' => '添加部门',
			'view' => array (
					'template' => 'PersonnelManagement/Contract/EditContract.html',
					'widgets'=>array(
							
							array(
									'id'=>'name',
									'class'=>'text',
									'title'=>'员工',
									'disabled' => 'true',
							),
							array(
									'id'=>'cid',
									'class'=>'text',
									'title'=>'合同编号',
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
									'title'=>'到期提醒时间',
							),
							array(
									'id'=>'hide_id',
									'class'=>'text',
									'type' => 'hidden',
									'title'=>'合同id',
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
		$aContractModel = Model::Create('openoa:ContractManagement')
						->hasOne('coresystem:userinfo','uid','uid','userinfo')
						->hasOne('coresystem:user','uid','uid','user');
		$aContractModel->load($this->params['id'],'id');
		
		$this->view->widget('hide_id')->setValue($aContractModel['id']);
		$this->view->widget('name')->setValue($aContractModel['user.username']);
		$this->view->widget('cid')->setValue($aContractModel['cid']);
		$this->view->widget('starttime')->setValue(date('Y-m-d',$aContractModel['starttime']));
		$this->view->widget('endtime')->setValue(date('Y-m-d',$aContractModel['endtime']));
		$this->view->widget('remindtime')->setValue(date('Y-m-d',$aContractModel['remindtime']));
		
		$this->doActions();
	}
	
	public function form(){
// 		if( empty($this->params['hide_id']) )
// 		{
// 			$this->view->createMessage(Message::error,"%s 不能为空",'单位员工') ;
// 			return ;
// 		}
		
		$sCid = $this->params['cid'];
		$sId = $this->params['hide_id'];
		
		$sStartTime = strtotime($this->params['starttime']);
		$sEndTime = strtotime($this->params['endtime']);
		$nRemindDays = mktime(0,0,0,12,1,2001)-mktime(0,0,0,10,1,2001);
		$sRemindTime = $sEndTime - $nRemindDays;

		$aContractModel = Model::Create('openoa:ContractManagement');
		$aContractModel->load($sId,'id');
		$aContractModel->update(
				array(
					'cid' => $sCid
					,'starttime' => $sStartTime
					,'endtime' => $sEndTime
					,'remindtime' => $sRemindTime
				) , "id =".$sId
		);
		
		$this->messageQueue()->create ( Message::success, "编辑成功" );
		$this->location('?c=org.opencomb.openoa.PersonnelManagement.Contract.ContractManagement');
	}	
}