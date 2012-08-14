<?php
namespace org\opencomb\oa\PersonnelManagement\Dep;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class AddDepartment extends ControlPanel{
	public $arrConfig = array (
			'title' => '添加部门',
			'view' => array (
					'template' => 'PersonnelManagement/Dep/AddDepartment.html',
					'widgets'=>array(
							array(
									'id'=>'name',
									'class'=>'text',
									'title'=>'部门名称',
							),
							array(
									'id'=>'content',
									'class'=>'text',
									'type'=>'multiple',
									'title'=>'部门描述',
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
		$this->doActions();
	}
	
	public function form(){
		if( empty($this->params['name']) )
		{
			$this->view->createMessage(Message::error,"%s 不能为空",'部门名称') ;
			return ;
		}
		
		$aDepartmentModel = Model::Create('oa:DepartmentManagement');
		$aDepartmentModel->load($this->params['name'] , 'DepartmentName');
		
		if($aDepartmentModel->rowNum() > 0){
			$this->view->createMessage(Message::error,"%s 已存在",'部门名称') ;
			return ;
		}
		
		$aDepartmentModel->addRow(array('DepartmentName'=>$this->params['name'] , "Description"=>$this->params['content']));
		$nUpdateRows = $aDepartmentModel->replace();
		
		if($nUpdateRows > 0){
			$this->messageQueue()->create(Message::success,"添加部门成功") ;
			$this->location('?c=org.opencomb.oa.PersonnelManagement.Dep.DepartmentManagement');
		}else{
			$this->view->createMessage(Message::error,"添加部门失败") ;
		}
	}	
}