<?php
namespace org\opencomb\openoa\index;

use org\opencomb\openoa\controller\OpenOaController;

class Index extends OpenOaController
{
	protected $arrConfig = array(
		'title'=>'首页',
		'view'=>array(
			'template'=>'index/Index.html'
		)
	) ;

	public function process()
	{
	}
}


