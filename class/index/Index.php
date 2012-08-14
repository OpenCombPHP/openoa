<?php
namespace org\opencomb\oa\index;

use org\opencomb\oa\controller\OaController;

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


