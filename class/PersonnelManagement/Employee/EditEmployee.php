<?php
namespace org\opencomb\openoa\PersonnelManagement\Employee;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class EditEmployee extends OpenOaController{
	protected $arrConfig = array (
			'title' => '编辑',
			'view' => array (
					'template' => 'PersonnelManagement/Employee/EditEmployee.html',
					'widgets'=>array(
							array(
									'id'=>'e_id',
									'class'=>'text',
									'title'=>'员工工号',
							),
							array(
									'id'=>'e_name',
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
		$aEmployeeModel = Model::Create('openoa:EmployeeManagement','employee')
							->hasOne('coresystem:userinfo','uid','uid','userinfo')
							->hasOne('coresystem:user','uid','uid','user')
							->belongsTo('coresystem:group','department','gid','groups')
							->belongsTo('openoa:PositionManagement','position','pid','position');
	
		$aEmployeeModel->load($this->params['eid'] , 'uid');
		$aPositionModel = Model::Create('openoa:PositionManagement');
		$aPositionModel->load();
		
		$this->view()->setModel($aPositionModel);
		$this->view->variables()->set('aPositionModel',$aPositionModel) ;
		
		$aDepatmentModel = Model::Create('coresystem:group');
		$aDepatmentModel->load();
		
		$this->view()->setModel($aDepatmentModel);
		$this->view->variables()->set('aDepatmentModel',$aDepatmentModel) ;
		
		$this->view->widget('e_id')->setValue($aEmployeeModel['eid']);
		$this->view->widget('e_name')->setValue($aEmployeeModel['user.username']);
		$this->view->variables()->set('sPosition',$aEmployeeModel['position']);
		$this->view->variables()->set('sSex',$aEmployeeModel['sex']);
		$this->view->variables()->set('sBirthday',date('Y-m-d',$aEmployeeModel['userinfo.birthday']));
		$this->view->widget('policital')->setValue($aEmployeeModel['policital']);
		$this->view->widget('worktime')->setValue($aEmployeeModel['worktime']);
		$this->view->widget('protitle')->setValue($aEmployeeModel['protitle']);
		$this->view->widget('education')->setValue($aEmployeeModel['education']);
		$this->view->variables()->set('sGraduationTime',date('Y-m-d',$aEmployeeModel['graduationtime']));
		$this->view->widget('school')->setValue($aEmployeeModel['school']);
		$this->view->widget('major')->setValue($aEmployeeModel['major']);
		$this->view->variables()->set('sFactoryTime',date('Y-m-d',$aEmployeeModel['factorytime']));
		$this->view->variables()->set('sDepartment',$aEmployeeModel['department']);
		$this->view->widget('tel')->setValue($aEmployeeModel['userinfo.tel']);
		$this->view->widget('phone')->setValue($aEmployeeModel['phone']);
		$this->view->variables()->set('sStatus',$aEmployeeModel['status']);
		$this->view->widget('hide_eid')->setValue($this->params['eid']);
		
		$this->doActions();
	}
	
	public function form(){
		
		if( empty($this->params['e_name']) )
		{
			$this->view->createMessage(Message::error,"%s 不能为空",'员工姓名') ;
			return ;
		}
		$sEid = $this->params['e_id'];
		$sName = $this->params['e_name'];
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
		
		$this->model('openoa:EmployeeManagement','employee')
					->hasOne('coresystem:userinfo','uid','uid','userinfo')
					->hasOne('coresystem:user','uid','uid','user');

		$this->model('openoa:EmployeeManagement')->update(
				array(
						'eid' => $sEid
						,'name' => $sName
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
		
				) , "EmployeeManagement.uid =". $this->params['hide_eid']
		);
		
		$this->model('coresystem:user')->update(
				array(
						'username' => $sName
				) , "user.uid =".$this->params['hide_eid']
		);

		$this->model('coresystem:userinfo')->update(
				array(
						'birthday' => $sBirthday
						,'tel' => $sTel
				) , "userinfo.uid =".$this->params['hide_eid']
		);
		
		$this->messageQueue()->create ( Message::success, "编辑成功" );
		$this->location('?c=org.opencomb.openoa.PersonnelManagement.Employee.EmployeeManagement');
	}	
	
}