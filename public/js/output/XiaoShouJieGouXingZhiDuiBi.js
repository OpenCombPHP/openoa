jquery(function($){
	setTimeout(onLoad , 1700);
	
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
		
		$('#XiaoShouJieGouXingZhiDuiBi_table')
		// 初始化 表格插件
		.datagrid({
			data: aXiaoShouJieGouXingZhiDuiBiSheet
			, table: {
					editable: false
					, style :  "text-align:center"
			}
			, cols: {
				0 : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
				}
				, F: {
					formater:formater
				}
				, G: {
					style:"display:none"
				}
			}
		});
		
		var getGraphData = function( row,column){
			
			var value = aXiaoShouJieGouXingZhiDuiBiSheet[row][column];
			
			value = parseFloat(value) ;
			
			if( value === null || isNaN(value)){
				value = 0;
			}
			
			return value;
	    };
		
		var buildGraph = function(graph)
		{
			graph.Set('chart.ylabels.count', 5);
			//graph.Set('chart.numyticks', 10);
			graph.Set('chart.background.grid.vlines', false);
			graph.Set('chart.background.grid.border', false);
			graph.Set('chart.gutter.left', 60);
			graph.Set('chart.shadow', true);
			graph.Set('chart.shadow.blur', 15);
			graph.Set('chart.shadow.offsetx', 0);
			graph.Set('chart.shadow.offsety', 0);
			graph.Set('chart.shadow.color', '#aaa');
		}
		
		var toTips = function(data,postfix,tips)
	    {
	    	if( typeof(tips)=='undefined' )
	    	{
	    		tips = [] ;
	    	}
	    	for(var i=0;i<data.length;i++)
	    	{
	    		if( typeof(data[i])=='object' )
	    		{
	    			toTips(data[i],postfix,tips) ;
	    		}
	    		else
	    		{
	    			tips.push( (typeof(data[i])=='undefined'? '': data[i].toString()) + postfix) ;
	    		}
	    	}
	    	return tips ;
	    }
		
		var data = [] ;
		
		for(var row=0;row<=4;row++)
		{
			data.push([getGraphData(row, 'A'),getGraphData(row, 'B')]) ;
		}
		
		var bar5 = new RGraph.Bar('XiaoShouJieGouXingZhiDuiBi_bar', data);
		
//		var bar5 = new RGraph.Bar('XiaoShouJieGouXingZhiDuiBi_bar', [
//	  			   [getGraphData(0, 'A'),getGraphData(0, 'B')]
//				   , [getGraphData(1, 'A'),getGraphData(1, 'B')]
//				   , [getGraphData(2, 'A'),getGraphData(2, 'B')]
//				   , [getGraphData(3, 'A'),getGraphData(3, 'B')]
//				   , [getGraphData(4, 'A'),getGraphData(4, 'B')]
//				   ]);
		buildGraph(bar5);
		bar5.Set('chart.colors',['#e52951','#f1bc17']); 
		bar5.Set('chart.labels', ['居民', '大生活', '工业', '商业', '基建']);
		bar5.Set('chart.tooltips', toTips(data,' %'));
		bar5.Set('chart.key', ['今年','去年']);
		bar5.Set('chart.strokestyle', 'transparent');
		bar5.Set('chart.ymax', 100);
		bar5.ondraw = function (obj)
	            {
	                var len = obj.coords.length;
	                
	                obj.context.beginPath();
	                    obj.context.fillStyle = 'rgba(255,255,255,0.15)';
	                    for (var i=0; i<len; ++i) {
	                        obj.context.fillRect(obj.coords[i][0], obj.coords[i][1], obj.coords[i][2] / 2, obj.coords[i][3])
	                    }
	                obj.context.fill();
	            }
	
		//动画绘制
		$(bar5.canvas).data('bar',bar5);
		$(bar5.canvas).on('HuiZhi',function(){
			RGraph.Effects.Bar.Wave($(this).data('bar'));
		});
		
		
		//Pie
		var mapPies = {};
		mapPies[year] = {
					col: 'A'
					, canvas: 'XiaoShouJieGouXingZhiDuiBi_pie1'
					, data: []
					, tips: []
				} ;
		mapPies[year-1] = {
					col: 'B'
					, canvas: 'XiaoShouJieGouXingZhiDuiBi_pie2'
					, data: []
					, tips: []
				} ;
		
		for(var year in mapPies)
		{
			var aInfo = mapPies[year] ;
		
			for(var row=0;row<=4;row++)
			{
				var v = parseFloat(aShuiLiangDuiBiSheet[row][aInfo.col]) ;
				v = isNaN(v)?0:v ;
				aInfo.data.push(v) ;
				aInfo.tips.push(v.toString());
			}
			
			var pie = new RGraph.Pie(aInfo.canvas, aInfo.data);
			pie.Set('chart.tooltips', aInfo.tips);
			pie.Set('chart.labels.sticks', true);
			pie.Set('chart.labels.sticks.length', 20);
			pie.Set('chart.colors', [
										 RGraph.RadialGradient(pie, 150,150,0,150,150,150, 'f5ff4f', 'f9bf13'),
	                                     RGraph.RadialGradient(pie, 150,150,0,150,150,150, 'dcf400', 'bfd614'),
	                                     RGraph.RadialGradient(pie, 150,150,0,150,150,150, '97e4ff', '38bef3'),
										 RGraph.RadialGradient(pie, 150,150,0,150,150,150, 'ff85ef', 'e5298a'),
	                                     RGraph.RadialGradient(pie, 150,150,0,150,150,150, '8bffe5', '29e5bb')
				]);
			pie.Set('chart.labels', [
						'居民'
						, '大生活'
						, '工业'
						, '商业'
						, '基建'
			]);
			pie.Set('chart.radius', 80);
			pie.Set('chart.strokestyle', 'transparent');
			pie.Set('chart.exploded', [20]);
			
			pie.Set('chart.linewidth', 100);
			pie.Set('chart.shadow', true);
			
			//动画绘制
			$(pie.canvas).data('pie',pie);
			$(pie.canvas).on('HuiZhi',function(){
				switch (Math.floor(Math.random()*4))
				{
					case 1:
						RGraph.Effects.Pie.Grow($(this).data('pie'));
						break;
					case 2:
						RGraph.Effects.Pie.Implode($(this).data('pie'));
						break;
					case 3:
						RGraph.Effects.Pie.RoundRobin($(this).data('pie'));
						break;
					default:
						RGraph.Effects.Pie.RoundRobin($(this).data('pie'));
				}
			});
			
			setTimeout(function () {pie.Explode(0,10);}, 250);
		}
		
	}
});

