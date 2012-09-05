<?php
namespace org\opencomb\openoa\AssetsManagement\Type;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\jecat\framework\lang\Exception;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class EditAssetType extends OpenOaController{
	protected $arrConfig = array (
			'title' => '编辑',
			'view' => array (
					'template' => 'AssetsManagement/Type/EditAssetType.html',
					'widgets'=>array(
							array(
									'id'=>'edit_name',
									'class'=>'text',
									'title'=>'类别名称',
							),
							array(
									'id'=>'hide_tid',
									'class'=>'text',
									'type'=>'hidden',
									'title'=>'类别id',
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
		$this->view->widget('hide_tid')->setValue($this->params['tid']);
		$this->view->widget('edit_name')->setValue($this->params['name']);
		$aTypeModel = Model::Create('openoa:AssetType');
		$aTypeModel->load($this->params['tid'] , 'tid');
		$this->doActions();
	}
	
	public function form(){
		if( empty($this->params['edit_name']) )
		{
			$this->view->createMessage(Message::error,"%s 不能为空",'职位名称') ;
			return ;
		}
		
		$aTypeModel = Model::Create('openoa:AssetType');
		$aTypeModel->load($this->params['hide_tid'] , 'tid');
		
		try{
			$aTypeModel->update(array('type'=>$this->params['edit_name']) , "tid =".$this->params['hide_tid']);
			$this->messageQueue ()->create ( Message::success, "编辑成功" );
		}catch (Exception $e){
			$this->messageQueue ()->create ( Message::error, "已存在此类别" );
		}
		$this->location('?c=org.opencomb.openoa.AssetTypeManagement.Type.AssetTypeManagement');
	}	
	
}