<?php
namespace org\opencomb\openoa\PersonnelManagement\Employee;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class AddEmployee extends OpenOaController{
	public $arrConfig = array (
			'title' => '添加职位',
			'view' => array (
					'template' => 'PersonnelManagement/Employee/AddEmployee.html',
					'widgets'=>array(
							array(
									'id'=>'eid',
									'class'=>'text',
									'title'=>'员工工号',
							),
							array(
									'id'=>'name',
									'class'=>'text',
									'title'=>'员工姓名',
							),
							array(
									'id'=>'policital',
									'class'=>'text',
									'title'=>'职位名称',
							),
							array(
									'id'=>'worktime',
									'class'=>'text',
									'title'=>'职位名称',
							),
							array(
									'id'=>'protitle',
									'class'=>'text',
									'title'=>'职位名称',
							),
							array(
									'id'=>'education',
									'class'=>'text',
									'title'=>'职位名称',
							),
							array(
									'id'=>'school',
									'class'=>'text',
									'title'=>'职位名称',
							),
							array(
									'id'=>'major',
									'class'=>'text',
									'title'=>'职位名称',
							),
							array(
									'id'=>'department',
									'class'=>'text',
									'title'=>'职位名称',
							),
							array(
									'id'=>'tel',
									'class'=>'text',
									'title'=>'职位名称',
							),
							array(
									'id'=>'phone',
									'class'=>'text',
									'title'=>'职位名称',
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
		$aPositionModel = Model::Create('openoa:PositionManagement');
		$aPositionModel->load();
		
		$this->view()->setModel($aPositionModel);
		$this->view->variables()->set('aPositionModel',$aPositionModel) ;
		
		$aDepatmentModel = Model::Create('coresystem:group');
		$aDepatmentModel->load();
		
		$this->view()->setModel($aDepatmentModel);
		$this->view->variables()->set('aDepatmentModel',$aDepatmentModel) ;
		$this->view->variables()->set('arrY',array('birthday'=>'b','graduation'=>'g','factory'=>'f')) ;
		$this->doActions();
	}
	
	public function form(){
		if( empty($this->params['name']) )
		{
			$this->view->createMessage(Message::error,"%s 不能为空",'员工姓名') ;
			return ;
		}
		
		$sEid = $this->params['eid'];
		$sName = $this->params['name'];
		$sPosition = $this->params['position_select'];
		$sSex = $this->params['sex'];
		$sBirthday = strtotime($this->params['birthday']) == false ? null:strtotime($this->params['birthday']) ;
		$sPolicital = $this->params['policital'];
		$sWorkTime = $this->params['worktime'];
		$sProtile = $this->params['protitle'];
		$sEducation = $this->params['education'];
		$sGraduationTime = strtotime($this->params['graduation_time']) == false ? null:strtotime($this->params['graduation_time']) ;
		$sSchool = $this->params['school'];
		$sMajor = $this->params['major'];
		$sFactoryTime = strtotime($this->params['factory_time']) == false ? null:strtotime($this->params['factory_time']) ;
		$sDepartment = $this->params['department_select'];
		$sTel = $this->params['tel'];
		$sPhone = $this->params['phone'];
		$sStatus = $this->params['status'];
		
		
		
		
		$aEmployeeModel = Model::Create('openoa:EmployeeManagement','employee')
							->hasOne('coresystem:userinfo','uid','uid','userinfo')
							->hasOne('coresystem:user','uid','uid','user');
		$aEmployeeModel->load();
		$aEmployeeModel->addRow(
				array(
						'eid' => $sEid
						,'user.username' => $sName
						,'position' => $sPosition
						,'sex' => $sSex
						,'userinfo.birthday' => $sBirthday
						,'policital' => $sPolicital
						,'worktime' => $sWorkTime
						,'prtitle' => $sProtile
						,'education' => $sEducation
						,'graduationtime' => $sGraduationTime
						,'school' => $sSchool
						,'major' => $sMajor
						,'factorytime' => $sFactoryTime
						,'department' => $sDepartment
						,'userinfo.tel' => $sTel
						,'phone' => $sPhone
						,'status' => $sStatus
				)
		);
		$nUpdateRows = $aEmployeeModel->replace();
		
		if($nUpdateRows > 0){
			$this->messageQueue()->create(Message::success,"添加员工成功") ;
			$this->location('?c=org.opencomb.openoa.PersonnelManagement.Employee.EmployeeManagement');
		}else{
			$this->view->createMessage(Message::error,"添加员工失败") ;
		}
	}	
}