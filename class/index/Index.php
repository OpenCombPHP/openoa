<?php
namespace org\opencomb\openoa\index;

use org\opencomb\openoa\controller\OaController;

class Index extends OaController
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


