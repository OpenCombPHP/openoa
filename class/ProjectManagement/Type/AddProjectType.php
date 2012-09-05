<?php
namespace org\opencomb\openoa\ProjectManagement\Type;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class AddProjectType extends OpenOaController{
	public $arrConfig = array (
			'title' => '添加职位',
			'view' => array (
					'template' => 'ProjectManagement/Type/AddProjectType.html',
					'widgets'=>array(
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
		
		$sName = $this->params['name'];
		
		$this->model('openoa:ProjectType','type');
		$this->type->load();
		$nUpdateRows = $this->type->replace(array('type'=>$sName));
		
		if($nUpdateRows > 0){
			$this->messageQueue()->create(Message::success,"添加项目类别成功") ;
			$this->location('?c=org.opencomb.openoa.ProjectManagement.Type.ProjectTypeManagement');
		}else{
			$this->view->createMessage(Message::error,"添加项目类别失败") ;
		}
	}	
}