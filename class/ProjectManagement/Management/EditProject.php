<?php
namespace org\opencomb\openoa\ProjectManagement\Management;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\jecat\framework\auth\IdManager ;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class EditProject extends OpenOaController{
	public $arrConfig = array (
			'title' => '新建项目',
			'view' => array (
					'template' => 'ProjectManagement/Management/EditProject.html',
					'widgets'=>array(
							array(
									'id'=>'name',
									'class'=>'text',
									'title'=>'项目名称',
							),
							array(
									'id'=>'content',
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
		
		$aProjectModel = Model::Create('openoa:ProjectManagement','ProjectManagement')
						->hasOne('coresystem:user','uid','uid','user')
						->belongsTo('coresystem:group','department','gid','groups')
						->belongsTo('openoa:ProjectType','type','type','ProjectType');
		
		$aProjectModel->load($this->params['pid'] , 'pid');

		
		$this->view()->setModel($aProjectModel);
		$this->view->variables()->set('aProjectModel',$aProjectModel) ;
		
		$aDepatmentModel = Model::Create('coresystem:group');
		$aDepatmentModel->load();
		
		$this->view()->setModel($aDepatmentModel);
		$this->view->variables()->set('aDepatmentModel',$aDepatmentModel) ;
		
		//$this->view->widget('e_id')->setValue($aEmployeeModel['eid']);
		$this->view->widget('e_name')->setValue($aProjectModel['name']);
		$this->view->widget('e_type')->setValue($aProjectModel['ProjectType.type']);
		$this->view->widget('e_starttime')->setValue($aProjectModel['name']);
		$this->view->widget('e_endtime')->setValue($aProjectModel['name']);
		$this->view->variables()->set('sPosition',$aEmployeeModel['position']);
		$this->view->variables()->set('sSex',$aEmployeeModel['sex']);
		$arrBrithday = explode('.',$aEmployeeModel['userinfo.birthday']);
		
		
		$this->view->variables()->set('sCurrentUser' ,IdManager::singleton()->currentUserName());
		$this->view->variables()->set('sAssignUid',IdManager::singleton()->currentUserId());
		$this->model('openoa:ProjectType','type');
		$this->type->load();
		$this->view->variables()->set('aProjectType',$this->type);
		//->belongsTo('coresystem:group','department','gid','group')
		$this->doActions();
	}
	
	public function form(){
		$sName = $this->params['name'];
		$sType = $this->params['type'];
		$sStartTime = strtotime($this->params['starttime']);
		$sEndTime = strtotime($this->params['endtime']);
		//echo $sStartTime.' ddd '.$sStartTime;exit;
		$sContent = $this->params['content'];
		$sPublisher = IdManager::singleton()->currentUserName();
		$sResponsiblePerson = $this->params['hide_uid'];
		$sPurview = $this->params['purview'];
		$sStatus = $this->params['status'];
		$sRates = $this->params['rates'];
		
		$this->model("openoa:ProjectManagement","project");
		$this->project->load();
		$this->project->replace(
				array(
					'name' => $sName
					,'type' => $sType
					,'starttime' => $sStartTime
					,'endtime' => $sEndTime
					,'content' => $sContent
					,'publisher' => $sPublisher
					,'responsibleperson' => $sResponsiblePerson
					,'purview' => $sPurview
					,'status' => $sStatus
					,'completerates' => $sRates
						
				)		
		);
		//exit;	
	}	
}