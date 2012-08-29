<?php
namespace org\opencomb\openoa\ProjectManagement;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class ProjectManagement extends ControlPanel{
	public $arrConfig = array (
			'title' => '添加职位',
			'view' => array (
					'template' => 'ProjectManagement/ProjectManagement.html',
					'widgets'=>array(
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
		$this->model('openoa:ProjectManagement','ProjectManagement');
				//->belongsTo('openoa:ProjectType','type','type','ProjectType');
		$this->ProjectManagement->load();
		
		//var_dump($this->ProjectManagement);exit;
		$this->view()->setModel($this->ProjectManagement);
		$this->view->variables()->set('aProjectManagement',$this->ProjectManagement) ;
		//$this->view->variables()->set('sNow',strtotime(date('Y-m-d'))) ;
		$this->doActions();
	}
	
	public function form(){
		if( empty($this->params['name']) )
		{
			$this->view->createMessage(Message::error,"%s 不能为空",'员工姓名') ;
			return ;
		}
		
		$sName = $this->params['name'];
		$sPosition = $this->params['position_select'];
		$sSex = $this->params['sex'];
		$sBirthday = $this->params['brithday_y'].'-'.$this->params['brithday_m'].'-'.$this->params['brithday_d'];
		$sPolicital = $this->params['policital'];
		$sWorkTime = $this->params['worktime'];
		$sProtile = $this->params['protitle'];
		$sEducation = $this->params['education'];
		$sGraduationTime = $this->params['graduation_y'].'.'.$this->params['graduation_m'].'.'.$this->params['graduation_d'];
		$sSchool = $this->params['school'];
		$sMajor = $this->params['major'];
		$sFactoryTime = $this->params['factory_y'].'.'.$this->params['factory_m'].'.'.$this->params['factory_d'];
		$sDepartment = $this->params['department_select'];
		$sTel = $this->params['tel'];
		$sPhone = $this->params['phone'];
		$sStatus = $this->params['status'];
		
		
		
		
		$aEmployeeModel = Model::Create('oa:EmployeeManagement');
		$aEmployeeModel->load();
		$aEmployeeModel->addRow(
				array(
						'name' => $sName
						,'position' => $sPosition
						,'sex' => $sSex
						,'birthday' => $sBirthday
						,'policital' => $sPolicital
						,'worktime' => $sWorkTime
						,'prtitle' => $sProtile
						,'education' => $sEducation
						,'graduation' => $sGraduationTime
						,'school' => $sSchool
						,'major' => $sMajor
						,'factorytime' => $sFactoryTime
						,'department' => $sDepartment
						,'tel' => $sTel
						,'phone' => $sPhone
						,'status' => $sStatus
				)
		);
		$nUpdateRows = $aEmployeeModel->replace();
		
		if($nUpdateRows > 0){
			$this->messageQueue()->create(Message::success,"添加员工成功") ;
			$this->location('?c=org.opencomb.oa.PersonnelManagement.Employee.EmployeeManagement');
		}else{
			$this->view->createMessage(Message::error,"添加员工失败") ;
		}
	}	
}