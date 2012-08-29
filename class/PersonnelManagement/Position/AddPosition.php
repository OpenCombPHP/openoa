<?php
namespace org\opencomb\openoa\PersonnelManagement\Position;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class AddPosition extends OpenOaController{
	public $arrConfig = array (
			'title' => '添加职位',
			'view' => array (
					'template' => 'PersonnelManagement/Position/AddPosition.html',
					'widgets'=>array(
							array(
									'id'=>'name',
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
		$this->doActions();
	}
	
	public function form(){
		if( empty($this->params['name']) )
		{
			$this->view->createMessage(Message::error,"%s 不能为空",'职位名称') ;
			return ;
		}
		
		$aPositionModel = Model::Create('openoa:PositionManagement');
		$aPositionModel->load($this->params['name'] , 'name');
		
		if($aPositionModel->rowNum() > 0){
			$this->view->createMessage(Message::error,"%s 已存在",'职位名称') ;
			return ;
		}
		
		$aPositionModel->addRow(array('name'=>$this->params['name'] ));
		$nUpdateRows = $aPositionModel->replace();
		
		if($nUpdateRows > 0){
			$this->messageQueue()->create(Message::success,"添加职位成功") ;
			$this->location('?c=org.opencomb.openoa.PersonnelManagement.Position.PositionManagement');
		}else{
			$this->view->createMessage(Message::error,"添加职位失败") ;
		}
	}	
}