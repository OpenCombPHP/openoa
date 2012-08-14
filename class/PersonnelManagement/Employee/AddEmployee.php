<?php
namespace org\opencomb\oa\PersonnelManagement\Employee;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class AddEmployee extends ControlPanel{
	public $arrConfig = array (
			'title' => '添加职位',
			'view' => array (
					'template' => 'PersonnelManagement/Employee/AddEmployee.html',
					'widgets'=>array(
							array(
									'id'=>'name',
									'class'=>'text',
									'title'=>'员工姓名',
							),
							array(
									'id'=>'sex',
									'class'=>'text',
									'title'=>'职位名称',
							),
							array(
									'id'=>'birthday',
									'class'=>'text',
									'title'=>'职位名称',
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
									'id'=>'graduation',
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
									'id'=>'factorytime',
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
		$aPositionModel = Model::Create('oa:PositionManagement');
		$aPositionModel->load();
		
		$this->view()->setModel($aPositionModel);
		$this->view->variables()->set('aPositionModel',$aPositionModel) ;
		$this->doActions();
	}
	
	public function form(){
		if( empty($this->params['name']) )
		{
			$this->view->createMessage(Message::error,"%s 不能为空",'员工姓名') ;
			return ;
		}
		
		$aPositionModel = Model::Create('oa:PositionManagement');
		$aPositionModel->load($this->params['name'] , 'PositionName');
		
		if($aPositionModel->rowNum() > 0){
			$this->view->createMessage(Message::error,"%s 已存在",'职位名称') ;
			return ;
		}
		
		$aPositionModel->addRow(array('PositionName'=>$this->params['name'] ));
		$nUpdateRows = $aPositionModel->replace();
		
		if($nUpdateRows > 0){
			$this->messageQueue()->create(Message::success,"添加职位成功") ;
			$this->location('?c=org.opencomb.oa.PersonnelManagement.Position.PositionManagement');
		}else{
			$this->view->createMessage(Message::error,"添加职位失败") ;
		}
	}	
}