var TableValue = {};
TV = TableValue;
TV.addition = function (input,inputRs)
{
	var aInput = input.split(",");
	var val = 0;
	for (var i=0 ; i< aInput.length ; i++)
	{
		var v = jQuery("input[name='"+aInput[i]+"']").val();
		if(v){
			val = val + parseInt(v);
		}
		
	}
	jQuery("input[name='"+inputRs+"']").val(val);
}
TV.subtraction = function (input,inputRs)
{
	var aInput = input.split(",");
	
	var v1 = jQuery("input[name='"+aInput[0]+"']").val();
	var v2 = jQuery("input[name='"+aInput[1]+"']").val();
	if(v1 && v2){
		var val = parseInt(v1) - parseInt(v2) ;
		jQuery("input[name='"+inputRs+"']").val( val.toFixed(2) );
	}
}

TV.division = function (input,inputRs)
{
	var aInput = input.split(",");
	
	var v1 = jQuery("input[name='"+aInput[0]+"']").val();
	var v2 = jQuery("input[name='"+aInput[1]+"']").val();
	if(v1 && v2){
		var val = (parseInt(v1) / parseInt(v2)) * 100 ;
		jQuery("input[name='"+inputRs+"']").val( val.toFixed(2) );
	}
}