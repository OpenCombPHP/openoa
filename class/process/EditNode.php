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

class EditNode extends ControlPanel
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/EditNode.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    if( !empty($_POST['Submit']))
	    {
	        $oProcess = new Process();
	        if( $oProcess->EditNode( $_POST, $this->params()->get('nid')))
	        {
	            $this->messageQueue ()->create ( Message::success, "保存成功" );
	            $this->location('?c=org.opencomb.openoa.process.Node&tid='.$_POST['tid']);
	        }else{
	            $this->messageQueue ()->create ( Message::success, "保存失败" );
	            $this->location('?c=org.opencomb.openoa.process.Node&tid='.$_POST['tid']);
	        }
	    }
	    
	    
	    $oModel = Model::create("openoa:Process_Node");
        $oModel->hasMany("openoa:Process_Status","id","nid","stat");
	    $oRow = $oModel->load( array( $this->params()->get('nid')) , array('id'));
	    $this->view()->variables()->set('row', $oRow );
	    
	    // 节点
	    $oNodeModel = Model::create("openoa:Process_Node");
	    $oNodeModel->hasOne('coresystem:group',"gid","gid");
	    $oNodeModel = $oNodeModel->load( array( $this->params()->get('tid')) , array('tid'));
	    $this->view()->variables()->set('listNode', $oNodeModel );
	    
	    // 群组
	    $aGroupModel = Model::create('coresystem:group');
	    Category::buildTree( $aGroupModel->load() ) ;
	    $this->view()->variables()->set('GroupModel', $aGroupModel );
	    
	}
}
