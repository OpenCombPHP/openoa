<?php
namespace org\opencomb\oa\PersonnelManagement\Employee;

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
		
		$this->view->widget('name')->setValue($aEmployeeModel['user.username']);
		$this->view->variables()->set('sPosition',$aEmployeeModel['position']);
		$this->view->variables()->set('sSex',$aEmployeeModel['sex']);
		$arrBrithday = explode('.',$aEmployeeModel['userinfo.birthday']);
		$this->view->variables()->set('birthday_y',array_key_exists(0,$arrBrithday)==true ?$arrBrithday[0] :null);
		$this->view->variables()->set('birthday_m',array_key_exists(1,$arrBrithday)==true ?$arrBrithday[1] :null);
		$this->view->variables()->set('birthday_d',array_key_exists(2,$arrBrithday)==true ?$arrBrithday[2] :null);
		$this->view->widget('policital')->setValue($aEmployeeModel['policital']);
		$this->view->widget('worktime')->setValue($aEmployeeModel['worktime']);
		$this->view->widget('protitle')->setValue($aEmployeeModel['protitle']);
		$this->view->widget('education')->setValue($aEmployeeModel['education']);
		$arrGraduation = explode('.',$aEmployeeModel['graduationtime']);
		$this->view->variables()->set('graduation_y',array_key_exists(0,$arrGraduation)==true ?$arrGraduation[0] :null);
		$this->view->variables()->set('graduation_m',array_key_exists(1,$arrGraduation)==true ?$arrGraduation[1] :null);
		$this->view->variables()->set('graduation_d',array_key_exists(2,$arrGraduation)==true ?$arrGraduation[2] :null);
		$this->view->widget('school')->setValue($aEmployeeModel['school']);
		$this->view->widget('major')->setValue($aEmployeeModel['major']);
		$arrFactory = explode('.',$aEmployeeModel['factorytime']);
		$this->view->variables()->set('factory_y',array_key_exists(0,$arrFactory)==true ?$arrFactory[0] :null);
		$this->view->variables()->set('factory_m',array_key_exists(1,$arrFactory)==true ?$arrFactory[1] :null);
		$this->view->variables()->set('factory_d',array_key_exists(2,$arrFactory)==true ?$arrFactory[2] :null);
		$this->view->variables()->set('sDepartment',$aEmployeeModel['department']);
		$this->view->widget('tel')->setValue($aEmployeeModel['userinfo.tel']);
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
		$sBirthday = $this->params['birthday_y'].'.'.$this->params['birthday_m'].'.'.$this->params['birthday_d'];
		echo $sBirthday;
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
		
		
// 		$aEmployeeModel = Model::Create('openoa:EmployeeManagement','employee')
// 							->hasOne('coresystem:userinfo','uid','uid','userinfo')
// 							->hasOne('coresystem:user','uid','uid','user');
// 		$aEmployeeModel->load();
// 		$aEmployeeModel->update(
// 				array(
// 					'user.username' => $sName
// 					,'position' => $sPosition
// 					,'sex' => $sSex
// 					,'userinfo.birthday' => $sBirthday
// 					,'policital' => $sPolicital
// 					,'worktime' => $sWorkTime
// 					,'protitle' => $sProtile
// 					,'education' => $sEducation
// 					,'graduationtime' => $sGraduationTime
// 					,'school' => $sSchool
// 					,'major' => $sMajor
// 					,'factorytime' => $sFactoryTime
// 					,'department' => $sDepartment
// 					,'userinfo.tel' => $sTel
// 					,'phone' => $sPhone
// 					,'status' => $sStatus
						
// 				) , "user.uid =".$this->params['hide_eid']
// 		);
		
		$this->model('openoa:EmployeeManagement','employee')
					->hasOne('coresystem:userinfo','uid','uid','userinfo')
					->hasOne('coresystem:user','uid','uid','user');
		
		$this->model('openoa:EmployeeManagement')->update(
				array(
						'name' => $sName
						,'position' => $sPosition
						,'sex' => $sSex
						//,'userinfo.birthday' => $sBirthday
						,'policital' => $sPolicital
						,'worktime' => $sWorkTime
						,'prtitle' => $sProtile
						,'education' => $sEducation
						,'graduationtime' => $sGraduationTime
						,'school' => $sSchool
						,'major' => $sMajor
						,'factorytime' => $sFactoryTime
						,'department' => $sDepartment
						//,'userinfo.tel' => $sTel
						,'phone' => $sPhone
						,'status' => $sStatus
		
				) , "EmployeeManagement.uid =".$this->params['hide_eid']
		);
		
		$this->model('coresystem:user')->update(
				array(
						'username' => $sName
				) , "user.uid =".$this->params['hide_eid']
		);
		
		$this->model('coresystem:userinfo')->update(
				array(
						'userinfo.birthday' => $sBirthday
						,'userinfo.tel' => $sTel
				) , "userinfo.uid =".$this->params['hide_eid']
		);
		
		$this->messageQueue()->create ( Message::success, "编辑成功" );
		$this->location('?c=org.opencomb.oa.PersonnelManagement.Employee.EmployeeManagement');
	}	
	
}