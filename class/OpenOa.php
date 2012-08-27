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
		//设置首页控制器
		$aAccessRouter = AccessRouter::singleton() ;
	}
}
