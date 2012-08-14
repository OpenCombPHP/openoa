jquery(function($){
	setTimeout(onLoad , 2000);
	
	function onLoad(){
		var $ = jquery;
		var formater = function(value,row,col,cell)
		{
			var cellDiv = cell.find('>div.datagrid-value')
				.removeClass('w_goDown')
				.removeClass('w_goUp') ;
			if(value>0)
			{
				cellDiv.addClass( 'w_goUp' ) ;
			}
			else if(value<0)
			{
				cellDiv.addClass( 'w_goDown' ) ;
			}
			
			return $.fn.datagrid.defaults.table.formater(value,row,col,cell) ;
		}
		
		$('#JingYingZhuangKuangDuiBi_table')
		// 初始化 表格插件
		.datagrid({
			data: aJingYingZhuangKuangDuiBiSheet
			, table: {
					editable: false
					, style :  "text-align:center"
			}
			, cols :{
				A : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
				}
				,H :{
					formater:formater
				}
				,I :{
					formater:formater
				}
			}
		});
	}
});

