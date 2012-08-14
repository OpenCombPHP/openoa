<?php
namespace org\opencomb\oa\PersonnelManagement\Position;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class EditPosition extends ControlPanel{
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
									'id'=>'hide_old_name',
									'class'=>'text',
									'type'=>'hidden',
									'title'=>'old职位名称',
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
		$this->view->widget('hide_old_name')->setValue($this->params['name']);
		$this->view->widget('hide_pid')->setValue($this->params['pid']);
		$this->view->widget('edit_name')->setValue($this->params['name']);
		$aPositionModel = Model::Create('oa:PositionManagement');
		$aPositionModel->load($this->params['pid'] , 'pid');
		$this->doActions();
	}
	
	public function form(){
		if( empty($this->params['edit_name']) )
		{
			$this->view->createMessage(Message::error,"%s 不能为空",'职位名称') ;
			return ;
		}
		
		$aPositionModel = Model::Create('oa:PositionManagement');
		$aPositionModel->load($this->params['edit_name'] , 'PositionName');
		
		if($aPositionModel->rowNum() > 0 && $this->params['hide_old_name']!=$this->params['edit_name']){
			$this->view->createMessage(Message::error,"%s 已存在",'职位名称') ;
			return ;
		}
		
		$aPositionModel->load();
		$aPositionModel->update(array('PositionName'=>$this->params['edit_name']) , "pid =".$this->params['hide_pid']);
		
		$this->messageQueue()->create ( Message::success, "编辑成功" );
		$this->location('?c=org.opencomb.oa.PersonnelManagement.Position.PositionManagement');
	}	
	
}