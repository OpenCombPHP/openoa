<?php
namespace org\opencomb\openoa;

use org\opencomb\openoa\controller\OpenOaController;

use org\opencomb\coresystem\auth\PurviewSetting;

use org\jecat\framework\system\AccessRouter;

use org\opencomb\platform\ext\Extension;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/**
 * 
 * @wiki /蜂巢/oa
 * @author anubis
 *
 */
class OpenOa extends Extension
{
	
	/**
	 * 载入扩展
	 */
	public function load()
	{	
		
		//OpenOaController::registerMenuHandler( array(__CLASS__,'buildOpenOaControllerMenu') ) ;
		
		ControlPanel::registerMenuHandler( array(__CLASS__,'buildControlPanelMenu') ) ;
		
		//设置首页控制器
		$aAccessRouter = AccessRouter::singleton() ;
	}
	
	static public function buildControlPanelMenu(array & $arrConfig)
	{
		$arrConfig['item:openoapersonel'] = array(
				'title'=> '流程管理' ,
				'link' => '?c=org.opencomb.openoa.process.Task' ,
				'query' => 'c=org.opencomb.openoa.process.Task' ,
				'menu' => 1,
				'item:CreateTask' => array(
						'title' => '新建流程' ,
						'link' => '?c=org.opencomb.openoa.process.CreateTask' ,
						'query' => 'c=org.opencomb.openoa.process.CreateTask' ,
				),
				'item:Task' => array(
						'title' => '流程管理' ,
						'link' => '?c=org.opencomb.openoa.process.Task' ,
						'query' => array(
					            'c=org.opencomb.openoa.process.CreateNode',
						        'c=org.opencomb.openoa.process.EditNode' ,
						        'c=org.opencomb.openoa.process.Node' ,
				        ) ,
				),

		);
	}
}
