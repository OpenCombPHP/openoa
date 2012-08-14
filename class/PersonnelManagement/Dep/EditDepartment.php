<?php
namespace org\opencomb\oa\PersonnelManagement\Dep;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class EditDepartment extends ControlPanel{
	protected $arrConfig = array (
			'title' => '编辑',
			'view' => array (
					'template' => 'PersonnelManagement/Dep/EditDepartment.html',
					'widgets'=>array(
							array(
									'id'=>'edit_name',
									'class'=>'text',
									'title'=>'部门名称',
							),
							array(
									'id'=>'edit_content',
									'class'=>'text',
									'type'=>'multiple',
									'title'=>'部门描述',
							),
							array(
									'id'=>'hide_old_name',
									'class'=>'text',
									'type'=>'hidden',
									'title'=>'old部门名称',
							),
							array(
									'id'=>'hide_did',
									'class'=>'text',
									'type'=>'hidden',
									'title'=>'部门id',
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
		$this->view->widget('hide_old_name')->setValue($this->params['name']);
		$this->view->widget('hide_did')->setValue($this->params['did']);
		$this->view->widget('edit_name')->setValue($this->params['name']);
		$aDepartmentModel = Model::Create('oa:DepartmentManagement');
		$aDepartmentModel->load($this->params['did'] , 'did');
		$this->view->widget('edit_content')->setValue($aDepartmentModel['Description']);
		$this->doActions();
	}
	
	public function form(){
		if( empty($this->params['edit_name']) )
		{
			$this->view->createMessage(Message::error,"%s 不能为空",'部门名称') ;
			return ;
		}
		
		$aDepartmentModel = Model::Create('oa:DepartmentManagement');
		$aDepartmentModel->load($this->params['edit_name'] , 'DepartmentName');
		
		if($aDepartmentModel->rowNum() > 0 && $this->params['hide_old_name']!=$this->params['edit_name']){
			$this->view->createMessage(Message::error,"%s 已存在",'部门名称') ;
			return ;
		}
		
		$aDepartmentModel->load();
		$aDepartmentModel->update(array('Description'=>$this->params['edit_content']) , "did =".$this->params['hide_did']);
		
		$this->messageQueue()->create ( Message::success, "编辑成功" );
		$this->location('?c=org.opencomb.oa.PersonnelManagement.Dep.DepartmentManagement');
	}	
	
}