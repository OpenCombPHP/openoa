<?php
namespace org\opencomb\openoa\controller;

use org\jecat\framework\mvc\view\widget\Widget;

use org\jecat\framework\util\EventManager;

use org\opencomb\coresystem\mvc\controller\Controller;
/*
 * 成本对比分析
 * */
class OpenOaController extends Controller{
	protected function defaultFrameConfig()
	{
		return array(
				'class'=>'webframe' ,
				'frameview:frameView' => array(
						'template' => 'openoa:frame/FrontFrame.html' ,
				) ,
		) ;
	}
	
	static public function registerMenuHandler($fnHandler)
	{
		EventManager::singleton()->registerEventHandle(
		'org\jecat\framework\mvc\view\widget\Widget'
		, Widget::beforeBuildBean
		, $fnHandler
		, null
		, 'water:frame/FrontFrame.html-mainMenu'
		) ;
	}
}