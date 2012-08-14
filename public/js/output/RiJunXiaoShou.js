jquery(function($){
	setTimeout(onLoad , 1900);
	
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
	
		$('#RiJunXiaoShou_table')
		// 初始化 表格插件
		.datagrid({
			data: aRiJunXiaoShouSheet
			, table: {
					editable: false
					, style :  "text-align:center"
			}
			, cols: {
				A:{
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
				}
				, F :{
					formater:formater
				}
				, G : {
					formater:formater
				}
				, H: { style:"display:none" }
			}
		});

	

		var barData = [] ;
		var lineData = [] ;
		for(var row=0;row<=15;row++)
		{
			var box = [] ;
			var barRow = [] ;
			for(var col in {B:null,C:null,D:null})
			{
				var v = parseFloat(aRiJunXiaoShouSheet[row][col]) ;
				if(isNaN(v))
				{
					v = 0 ;
				}
				else
				{
					box.push(v) ;
				}
				barRow.push(v)
			}
			barData.push(barRow) ;
		
			var sum = 0 ;
			for(var i=0;i<box.length;i++)
			{
				sum+= box[i] ;
			}
			lineData.push( Math.round((sum/box.length)*100)/100 ) ;
		}
		// 删掉数据中的 “季度累计”
		barData.splice(12,1);
		barData.splice(8,1);
		barData.splice(7,1);
		barData.splice(3,1);
		lineData.splice(12,1) ;
		lineData.splice(8,1) ;
		lineData.splice(7,1) ;
		lineData.splice(3,1) ;

		console.log(barData) ;
		console.log(lineData) ;
	
		var graph = new RGraph.Bar('RiJunXiaoShou_canbas', barData);
		graph.Set('chart.colors', ['#2A17B1', '#98ED00', '#541263']); 
		graph.Set('chart.labels', ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月']);
		graph.Set('chart.numyticks', 5);
		graph.Set('chart.ylabels.count', 5);
	   // graph.Set('chart.gutter.left', 60);
		graph.Set('chart.strokestyle', 'transparent');
		graph.Set('chart.hmargin.grouped', 0);
		graph.Set('chart.scale.round', true);
		graph.Set('chart.ymax', 2000);
		
		//动画绘制
		$(graph.canvas).data('bar',graph);
		$(graph.canvas).on('HuiZhi',function(){
			RGraph.Effects.Bar.Grow($(this).data('bar'));
		});
		

		var line = new RGraph.Line('RiJunXiaoShou_canbas', lineData);
		line.Set('chart.shadow', true);
		line.Set('chart.shadow.offsetx', 1);
		line.Set('chart.shadow.offsety', 1);
		line.Set('chart.linewidth', 2);
		line.Set('chart.noaxes', true);
		line.Set('chart.ylabels', false);
		line.Set('chart.background.grid', false);
		line.Set('chart.noendxtick', false);
		line.Set('chart.noendytick', false);
		line.Set('chart.colors', ['bfd81c']);
		
		//动画绘制
		$(line.canvas).data('line',line);
		$(line.canvas).on('HuiZhi',function(){
			RGraph.Effects.Line.Unfold($(this).data('line'));
		});
		
	}
});

