<?php
namespace org\opencomb\openoa\PersonnelManagement\Dep;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\jecat\framework\lang\Exception;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class DepartmentManagement extends OpenOaController{
	public $arrConfig = array (
			'title' => '部门管理',
			'view' => array (
					'template' => 'openoa:PersonnelManagement/Dep/DepartmentManagement.html',
			),
			
			'widgets'=>array(
					array(
							'id'=>'paginator',
							'class'=>'paginator',
							'count' => 10, //每页10项
							'nums' => 5   //显示5个页码
					),
			),
// 			'widget:paginator' => array(  //分页器bean
// 					'class' => 'paginator' ,
// 					'count' => 10, //每页10项
// 					'nums' => 5   //显示5个页码
// 			) ,
// 			'widget:paginator' => array(
// 					'class' => 'paginator' ,
// 			) ,
// 			'perms' => array (
// 					// 权限类型的许可
// 					'perm.purview' => array (
// 							'name' => Water::WATER_CaiWu
// 					)
// 			)
	);
	
	public function process() {
		$aDepartmentModel = Model::Create('coresystem:group');
		$aDepartmentModel->load();
		
		$this->view()->setModel($aDepartmentModel);
		$this->view->variables()->set('aDepartmentModel',$aDepartmentModel) ;
		$this->doActions();
	}
}