<?php

namespace org\opencomb\openoa\process;

use org\opencomb\openoa\process\api\Process;

use org\opencomb\coresystem\mvc\controller\ControlPanel;

use org\jecat\framework\db\DB;

use org\jecat\framework\mvc\model\Category;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class CreateNode extends ControlPanel
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/CreateNode.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    if( !empty($_POST['Submit']))
	    {
	        $oProcess = new Process();
	        $aRow['gid'] =  $_POST['gid'];
	        $aRow['status'] =  $_POST['status'];
	        if( $oProcess->CreateNode( $aRow, $this->params()->get('tid')))
	        {
	            $this->messageQueue ()->create ( Message::success, "保存成功" );
	            $this->location('?c=org.opencomb.openoa.process.Node&tid='.$this->params()->get('tid'));
	        }else{
	            $this->messageQueue ()->create ( Message::success, "保存失败" );
	            $this->location('?c=org.opencomb.openoa.process.Node&tid='.$this->params()->get('tid'));
	        }
	    }
	    
	    // 节点
	    $oNodeModel = Model::create("openoa:Process_Node");
	    $oNodeModel = $oNodeModel->load( array( $this->params()->get('tid')) , array('tid'));
	    $this->view()->variables()->set('listNode', $oNodeModel );
	    
	    // 群组
	    $aGroupModel = Model::create('coresystem:group');
	    Category::buildTree( $aGroupModel->load() ) ;
	    $this->view()->variables()->set('GroupModel', $aGroupModel );
	    
	}
}
