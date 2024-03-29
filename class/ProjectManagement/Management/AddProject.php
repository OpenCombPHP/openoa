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
class AddProject extends OpenOaController{
	public $arrConfig = array (
			'title' => '新建项目',
			'view' => array (
					'template' => 'ProjectManagement/Management/AddProject.html',
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
		$this->view->variables()->set('sCurrentUser' ,IdManager::singleton()->currentUserName());
		$this->view->variables()->set('sPublisher',IdManager::singleton()->currentUserId());
		$this->model('openoa:ProjectType','type');
		$this->type->load();
		$aDepatmentModel = Model::Create('coresystem:group');
		$aDepatmentModel->load();
		
		$this->view->variables()->set('aDepatmentModel',$aDepatmentModel) ;
		$this->view->variables()->set('aProjectType',$this->type);
		//->belongsTo('coresystem:group','department','gid','group')
		$this->doActions();
	}
	
	public function form(){
		$sName = $this->params['name'];
		$sType = $this->params['type'];
		$sStartTime = strtotime($this->params['starttime']);
		$sEndTime = strtotime($this->params['endtime']);
		$sContent = $this->params['content'];
		$sPublisher = IdManager::singleton()->currentUserId();
		$sResponsiblePerson = $this->params['hide_uid'];
		$sPurview = $this->params['purview'];
		if(count($this->params['remind'])==2)
		{
			$sRemind = 3;
		}else if(count($this->params['remind'])==1){
			$arrRemind = $this->params['remind'];
			if($arrRemind[0] == 1){
				$sRemind = 1;
			}else{
				$sRemind = 2;
			}
		}else{
			$sRemind = 0;
		}
		
		$sDepartment = $this->params['department_select'];
		
		$this->model("openoa:ProjectManagement","project");
		$this->project->load();
		$nUpdateRows = $this->project->replace(
							array(
								'name' => $sName
								,'type' => $sType
								,'starttime' => $sStartTime
								,'endtime' => $sEndTime
								,'content' => $sContent
								,'publisher' => $sPublisher
								,'responsibleperson' => $sResponsiblePerson
								,'purview' => $sPurview
								,'remind' => $sRemind
								,'department' => $sDepartment
							)		
		);
		
		if($nUpdateRows > 0){
			$this->messageQueue()->create(Message::success,"添加项目成功") ;
			$this->location('?c=org.opencomb.openoa.ProjectManagement.Management.ProjectManagement');
		}else{
			$this->view->createMessage(Message::error,"添加项目失败") ;
		}	
	}	
}