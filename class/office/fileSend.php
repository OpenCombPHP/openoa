<?php

namespace org\opencomb\openoa\office;

use org\jecat\framework\db\DB;

use org\jecat\framework\fs\Folder;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class fileSend extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'打卡签到',
		'view' => array (
				'template' => 'office/fileSend.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    if( !empty($_POST['Submit']))
	    {
	        $aFile = Extension::flyWeight('openoa')->filesFolder()->findFolder('file',Folder::FIND_AUTO_CREATE);
	        $filePath = $aFile->httpUrl(). $_FILES["file"]["name"];
	        
	        if (!$_FILES["file"]["error"] > 0)
	        {
	            move_uploaded_file($_FILES["file"]["tmp_name"],$filePath );
	        }
	            
	        $oModel = Model::create("openoa:EmployeeManagement");
	        $oToUser = $oModel->load( $_POST['toname'] , 'name');
	        
	        if($oToUser->rowNum() > 0)
	        {
	            $oMessageModel = Model::create("openoa:message");
	            $oMessageModel->insert( array(
	                'uid'=>$uid,
	                'touid'=>$oToUser['uid'],
	                'title'=>$_POST['title'],
	                'content'=>$_POST['content'],
	                'type'=>'file',
	                'date'=>time()       
                ));
	            
	            $oAttachmentModel = Model::create("openoa:message_attachment");
	            $oAttachmentModel->insert( array(
	                'mid'=>DB::singleton()->lastInsertId(),
	                'file'=>$filePath?:"",
	                'date'=>time()       
                ));
	            $this->messageQueue ()->create ( Message::success, "发送成功" );
	        }else{
	            
	            $this->messageQueue ()->create ( Message::error, "用户不存在" );
	        }
            $this->location('?c=org.opencomb.openoa.office.fileSend');
	    }
	    
	}
}
