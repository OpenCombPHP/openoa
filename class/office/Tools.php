<?php

namespace org\opencomb\openoa\office;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\mvc\model\Model;

class Tools
{
    static protected  $aDraft = array(
                '0'=>'否',
                '1'=>'是',
    );
    
	static public function getDraftStr( $id)
	{
	    return !empty(self::$aDraft[$id])?self::$aDraft[$id]:"";
	}
    
}
