function ExportToWord(obj){
	if( typeof(ActiveQtObject) == 'object' 
		&& typeof( WaterShellObject ) == 'object' 
	){
		copyObject(obj);
		return pasteToWord();
	}else{
		alert('无法在网页中使用此功能，请使用water shell');
	}
	
}
// ExportToWord( document.getElementById("frame-1") );

function copyObject(eDiv){
	SelectObject(eDiv);
	
	// QWebPage::Copy	13
	WaterShellObject.triggerAction(13,true);
}

function SelectObject(elemToSelect){
	if (window.getSelection) {  // all browsers, except IE before version 9
		var selection = window.getSelection ();
		var rangeToSelect = document.createRange ();
		rangeToSelect.selectNodeContents (elemToSelect);
		
		selection.removeAllRanges ();
		selection.addRange (rangeToSelect);
	} else {
		if (document.body.createTextRange) {    // Internet Explorer
			var rangeToSelect = document.body.createTextRange ();
			rangeToSelect.moveToElementText (elemToSelect);
			rangeToSelect.select ();
		}
	}
}

function pasteToWord(){
	var strword = ActiveQtObject.createActiveObject();
	
	var scRtn = ActiveQtObject.setControl(strword,"Word.Application");
	if(!scRtn){
		alert("您的系统上未安装Word，无法使用此功能");
	}
	
	var axo = eval( strword );
	axo.Visible = true ;

	var strdoc = ActiveQtObject.querySubObject(strword,'Documents');
	var stroDc = ActiveQtObject.querySubObject( strdoc , "Add(QString,int,int)","",0,0);
	var stroRange = ActiveQtObject.querySubObject( stroDc , "Range(int,int)",0,1);
	
	ActiveQtObject.dynamicCall( stroRange , "Paste()");
	
	return stroDc;
}
