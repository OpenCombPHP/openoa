<?php

namespace org\opencomb\openoa\process;

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
	        $oNodeModel = Model::create("openoa:Process_Node");
	        $oNodeModel->insert( array(
	                'tid'=>$_POST['tid'],
	                'gid'=>$_POST['gid'],
	                'name'=>$_POST['name'],
	        ));
	        $nid = DB::singleton()->lastInsertId();
	        
	        for($i = 1; $i <= 5; $i++)
	        {
	            if( !empty($_POST['status'][$i]))
	            {
	                $oStatusModel = Model::create("openoa:Process_Status");
	                $oStatusModel->insert( array(
	                        'nid'=>$nid,
	                        'name'=>$_POST['status'][$i],
	                        'tonid'=>0,
	                ));
	            }
	        }
	        
            $this->messageQueue ()->create ( Message::success, "成功" );
            $this->location('?=org.opencomb.openoa.process.Node&tid='.$this->params()->get('tid'));
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
