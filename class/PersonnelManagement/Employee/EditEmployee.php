<?php
namespace org\opencomb\openoa\PersonnelManagement\Employee;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class EditEmployee extends ControlPanel{
	protected $arrConfig = array (
			'title' => '编辑',
			'view' => array (
					'template' => 'PersonnelManagement/Employee/EditEmployee.html',
					'widgets'=>array(
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
							array(
									'id'=>'hide_eid',
									'class'=>'text',
									'type' => 'hidden',
									'title'=>'eid',
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
		$aEmployeeModel = Model::Create('openoa:EmployeeManagement');
		$aEmployeeModel->load($this->params['eid'] , 'eid');
		
		$aPositionModel = Model::Create('openoa:PositionManagement');
		$aPositionModel->load();
		
		$this->view()->setModel($aPositionModel);
		$this->view->variables()->set('aPositionModel',$aPositionModel) ;
		
		$aDepatmentModel = Model::Create('openoa:DepartmentManagement');
		$aDepatmentModel->load();
		
		$this->view()->setModel($aDepatmentModel);
		$this->view->variables()->set('aDepatmentModel',$aDepatmentModel) ;
		
		$this->view->widget('name')->setValue($aEmployeeModel['name']);
		$this->view->variables()->set('sPosition',$this->params['position']);
		$this->view->variables()->set('sSex',$aEmployeeModel['sex']);
		//$this->view->widget('birthday')->setValue($aEmployeeModel['name']);
		$this->view->widget('policital')->setValue($aEmployeeModel['policital']);
		$this->view->widget('worktime')->setValue($aEmployeeModel['worktime']);
		$this->view->widget('protitle')->setValue($aEmployeeModel['protitle']);
		//$this->view->widget('graduationtime')->setValue($aEmployeeModel['graduationtime']);
		$this->view->widget('school')->setValue($aEmployeeModel['school']);
		$this->view->widget('major')->setValue($aEmployeeModel['major']);
		//$this->view->widget('factorytime')->setValue($aEmployeeModel['factorytime']);
		$this->view->variables()->set('sDepartment',$aEmployeeModel['department']);
		$this->view->widget('tel')->setValue($aEmployeeModel['tel']);
		$this->view->widget('phone')->setValue($aEmployeeModel['phone']);
		$this->view->variables()->set('sStatus',$aEmployeeModel['status']);
		$this->view->widget('hide_eid')->setValue($this->params['eid']);
		
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
		
		
		$aEmployeeModel = Model::Create('openoa:EmployeeManagement');
		$aEmployeeModel->load();
		
		$aEmployeeModel->update(
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
						
				) , "eid =".$this->params['hide_eid']
		);
		
		$this->messageQueue()->create ( Message::success, "编辑成功" );
		$this->location('?c=org.opencomb.oa.PersonnelManagement.Employee.EmployeeManagement');
	}	
	
}