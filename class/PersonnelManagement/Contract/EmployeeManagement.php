<?php
namespace org\opencomb\openoa\PersonnelManagement\Contract;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class EmployeeManagement extends OpenOaController{
	public $arrConfig = array (
			'title' => '人员管理',
			'view' => array (
					'template' => 'PersonnelManagement/Contract/EmployeeManagement.html',
			),
			'widget:paginator' => array(  //分页器bean
					'class' => 'paginator' ,
					'count' => 10, //每页10项
					'nums' => 5   //显示5个页码
			) ,
// 			'perms' => array (
// 					// 权限类型的许可
// 					'perm.purview' => array (
// 							'name' => Water::WATER_CaiWu
// 					)
// 			)
	);
	
	public function process() {
		
		$this->model('openoa:EmployeeManagement','employee')
					->hasOne('coresystem:userinfo','uid','uid','userinfo')
					->hasOne('coresystem:user','uid','uid','user')
					->belongsTo('coresystem:group','department','gid','group')
					->belongsTo('openoa:PositionManagement','position','pid','position');
				
		$this->employee->load();
// 		echo $this->employee->data('groups.name');
// 		exit;
		
		
		
		//this->model('coresystem:user') ;
		
// 		$aEmployeeModel = Model::Create('openoa:EmployeeManagement');
// 		$aEmployeeModel->load(5,'uid');
		
		$this->view()->setModel($this->employee);
		$this->view->variables()->set('aEmployeeModel',$this->employee) ;
		$this->doActions();
	}
	
	public function form(){
		$sSearchKey = $this->params['searchkey'];
		$sSearchType = $this->params['searchtype'];
		
		if($sSearchType=='eid')
		{
			$this->employee->load($sSearchKey,'eid');
		}else if($sSearchType=='name'){
			$this->employee->load($sSearchKey,'user.username');
		}
		
		$this->view->variables()->set('aEmployeeModel',$this->employee) ;
	}
	
}