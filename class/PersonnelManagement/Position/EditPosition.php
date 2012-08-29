<?php
namespace org\opencomb\openoa\PersonnelManagement\Position;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\jecat\framework\lang\Exception;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class EditPosition extends OpenOaController{
	protected $arrConfig = array (
			'title' => '编辑',
			'view' => array (
					'template' => 'PersonnelManagement/Position/EditPosition.html',
					'widgets'=>array(
							array(
									'id'=>'edit_name',
									'class'=>'text',
									'title'=>'职位名称',
							),
							array(
									'id'=>'hide_pid',
									'class'=>'text',
									'type'=>'hidden',
									'title'=>'职位pid',
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
		$this->view->widget('hide_pid')->setValue($this->params['pid']);
		$this->view->widget('edit_name')->setValue($this->params['name']);
		$aPositionModel = Model::Create('openoa:PositionManagement');
		$aPositionModel->load($this->params['pid'] , 'pid');
		$this->doActions();
	}
	
	public function form(){
		if( empty($this->params['edit_name']) )
		{
			$this->view->createMessage(Message::error,"%s 不能为空",'职位名称') ;
			return ;
		}
		
		$aPositionModel = Model::Create('openoa:PositionManagement');
		$aPositionModel->load($this->params['hide_pid'] , 'pid');
		
		try{
			$aPositionModel->update(array('name'=>$this->params['edit_name']) , "pid =".$this->params['hide_pid']);
			$this->messageQueue ()->create ( Message::success, "编辑成功" );
		}catch (Exception $e){
			$this->messageQueue ()->create ( Message::error, "已存在此职位" );
		}
		$this->location('?c=org.opencomb.oa.PersonnelManagement.Position.PositionManagement');
	}	
	
}