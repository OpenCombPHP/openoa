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
									'id'=>'edit_name',
									'class'=>'text',
									'title'=>'项目名称',
							),
							array(
									'id'=>'edit_type',
									'class'=>'text',
									'title'=>'员工id',
							),
							array(
									'id'=>'edit_starttime',
									'class'=>'text',
									'title'=>'员工id',
							),
							array(
									'id'=>'edit_endtime',
									'class'=>'text',
									'title'=>'合同时间始',
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
		
		$aProjectModel = Model::Create('openoa:ProjectManagement','ProjectManagement');
// 						->belongsTo('coresystem:user','publisher','uid','user1')
// 						//->belongsTo('coresystem:user','responsibleperson','uid','user2')
// 						->belongsTo('coresystem:group','department','gid','groups')
// 						->belongsTo('openoa:ProjectType','type','type','ProjectType');
		
		$aProjectModel->load($this->params['pid'] , 'pid');
		//var_dump($aProjectModel);exit;
		
		$this->view()->setModel($aProjectModel);
		$this->view->variables()->set('aProjectModel',$aProjectModel) ;
		
		$aDepatmentModel = Model::Create('coresystem:group');
		$aDepatmentModel->load();
		
		$this->view()->setModel($aDepatmentModel);
		$this->view->variables()->set('aDepatmentModel',$aDepatmentModel) ;
		
		$this->view->widget('edit_name')->setValue($aProjectModel['name']);
		$this->view->widget('edit_type')->setValue($aProjectModel['ProjectType.type']);
		$this->view->widget('edit_starttime')->setValue(date('Y-m-d',$aProjectModel['starttime']));
		$this->view->widget('edit_endtime')->setValue(date('Y-m-d',$aProjectModel['endtime']));
		$this->view->variables()->set('pid',$this->params['pid']);
		$this->view->variables()->set('sContent',$aProjectModel['content']);
		$this->view->variables()->set('sPublicsher',$aProjectModel['user1.username']);
		$this->view->variables()->set('sPublicsherId',$aProjectModel['publisher']);
		$this->view->variables()->set('sResponsibleName',$aProjectModel['user2.username']);
		$this->view->variables()->set('sResponsibleId',$aProjectModel['responsibleperson']);
		$this->view->variables()->set('sDepartment',$aProjectModel['department']);
		$this->view->variables()->set('sStatus',$aProjectModel['status']);
		$this->view->variables()->set('sRates',$aProjectModel['rates']);
		
		
		$this->view->variables()->set('sCurrentUser' ,IdManager::singleton()->currentUserName());
		$this->view->variables()->set('sAssignUid',IdManager::singleton()->currentUserId());
		$this->model('openoa:ProjectType','type');
		$this->type->load();
		$this->view->variables()->set('aProjectType',$this->type);
		$this->doActions();
	}
	
	public function form(){
		$sName = $this->params['edit_name'];
		$sType = $this->params['edit_type'];
		$sStartTime = strtotime($this->params['edit_starttime']);
		$sEndTime = strtotime($this->params['edit_endtime']);
		//echo $this->params['edit_content'];exit;
		$sContent = $this->params['edit_content'];
		$sDepartment = $this->params['department_select'];
		$sPublisher = IdManager::singleton()->currentUserName();
		$sResponsiblePerson = $this->params['hide_responsible_id'];
		$sPurview = $this->params['purview'];
		$sRemind = $this->params['remind'];
		$sStatus = $this->params['status'];
		$sRates = $this->params['rates'];
		
		$aProjectModeldd = Model::Create('openoa:ProjectManagement','ProjectManagement');
		//var_dump($this->model('openoa:ProjectManagement'));
		$nUpdateRow = $this->model('openoa:ProjectManagement')->update(
				array(
					'name' => $sName
					,'type' => $sType
					,'starttime' => $sStartTime
					,'endtime' => $sEndTime
					,'content' => $sContent
					,'department' =>$sDepartment
					,'reponsibleperson' => $sResponsiblePerson
// 					,'ProjectManagement.purview' => $sPurview
// 					,'ProjectManagement.remind' => $sRemind
					,'status' => $sStatus
					,'rates' => $sRates
						
				),"ProjectManagement.pid =".$this->params['pid']		
		);
// 		$this->model("openoa:ProjectManagement","ProjectManagement");
// 		$this->model("openoa:ProjectManagement")->load();
// 		$ss = $this->model("openoa:ProjectManagement")->update(
// 				array(
// 					'ProjectManagement.name' => $sName
// 					,'ProjectManagement.type' => $sType
// 					,'ProjectManagement.starttime' => $sStartTime
// 					,'ProjectManagement.endtime' => $sEndTime
// 					,'ProjectManagement.content' => $sContent
// 					,'ProjectManagement.department' =>$sDepartment
// 					,'ProjectManagement.reponsibleperson' => $sResponsiblePerson
// 					,'ProjectManagement.purview' => $sPurview
// 					,'ProjectManagement.remind' => $sRemind
// 					,'ProjectManagement.status' => $sStatus
// 					,'ProjectManagement.rates' => $sRates
						
// 				),'ProjectManagement.pid='.$this->params['pid']		
// 		);
		if($nUpdateRow)
		{
			$this->messageQueue()->create(Message::success,"更新项目成功") ;
			$this->location('?c=org.opencomb.openoa.ProjectManagement.Management.ProjectManagement');
		}else{
			$this->messageQueue()->create(Message::success,"更新项目失败") ;
			$this->location('?c=org.opencomb.openoa.ProjectManagement.Management.ProjectManagement');
		}
	}	
}