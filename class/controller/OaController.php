<?php
namespace org\opencomb\openoa\controller;

use org\opencomb\coresystem\mvc\controller\Controller;
/*
 * 成本对比分析
 * */
class OaController extends Controller{
	protected function defaultFrameConfig()
	{
		return array(
				'class'=>'webframe' ,
				'frameview:frameView' => array(
						'template' => 'oa:frame/FrontFrame.html' ,
				) ,
		) ;
	}
}