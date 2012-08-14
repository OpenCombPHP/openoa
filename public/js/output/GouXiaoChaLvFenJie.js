jquery(function($){
	setTimeout(onLoad , 1200);
	
	function onLoad(){
		var $ = jquery;
		$('#GouXiaoChaLvFenJie_table1')
		// 初始化 表格插件
		.datagrid({
			data: aGouXiaoChaLvFenJieSheet1
			, table: {
					editable: false
					, style :  "text-align:center"
			}
			, cols : {
				A : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
				}
				, B : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
				}
				, F : { style:"display:none" }
			}
		});
		
		var getGraphData1 = function( row,column){
			
			var value = aGouXiaoChaLvFenJieSheet1[row][column];
			
			value = parseFloat(value) ;
			
			if( value === null || isNaN(value)){
				value = 0;
			}
			
			return value;
	    };
	    
		var buildGraph = function(graph)
		{
			graph.Set('chart.ylabels.count', 5);
			graph.Set('chart.numyticks', 10);
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
		var tips = [] ;
//		for(var row=1;row<=3;row++)
//		{
//			data.push([getGraphData1(row, 'C'),getGraphData1(row, 'D')]) ;
//			tips.push( '计划：'+getGraphData1(row, 'C').toString() ) ;
//			tips.push( '完成：'+getGraphData1(row, 'D').toString() ) ;
//		}
		
//		var data = [
//		            [getGraphData1(1, 'C'),getGraphData1(1, 'D')]
//		           , [getGraphData1(2, 'C'),getGraphData1(2, 'D')]
//		           , [getGraphData1(3, 'C'),getGraphData1(3, 'D')]
//		    		
//		    		
//		    		// 公司、子公司、合计 日均销售水量
////		    		, [0,0], [0,0]
////		    		, [getData(3,'B'),getData(3,'D')]
////		    		, [getData(4,'B'),getData(4,'D')]
////		    		, [getData(5,'B'),getData(5,'D')]
//		    	] ;
		
		for(var row=1;row<=3;row++)
		{
			data.push([getGraphData1(row, 'C'),getGraphData1(row, 'D')]) ;
//			tips.push(getGraphData1(row, 'C').toString()+'%' ) ;
//			tips.push(getGraphData1(row, 'D').toString()+'%' ) ;
		}
		
		var bar5 = new RGraph.Bar('GouXiaoChaLvFenJie_bar1', data);
		
//		var bar5 = new RGraph.Bar('GouXiaoChaLvFenJie_bar', [
//				   [getGraphData(1, 'C'),getGraphData(1, 'D')]
//				   , [getGraphData(2, 'C'),getGraphData(2, 'D')]
//				   , [getGraphData(3, 'C'),getGraphData(3, 'D')]
	//
//				   ]);
		buildGraph(bar5);
		bar5.Set('chart.colors', ['#34beef','#e5298a']); 
		bar5.Set('chart.labels', ['凤凰山', '湾里', '营业所']);
		bar5.Set('chart.tooltips', toTips(data,' %'));
		bar5.Set('chart.key', ['计划','完成']);
		bar5.Set('chart.numyticks', 5);
	    bar5.Set('chart.background.grid.vlines', false);
	    bar5.Set('chart.background.grid.border', false);
		bar5.Set('chart.strokestyle', 'transparent');
		bar5.Set('chart.ymax', 100);
		//bar5.Set('chart.key.position.y', 200);
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
		
		
		
		
		
		
		
		//去年
		$('#GouXiaoChaLvFenJie_table2')
		.datagrid({
			data: aGouXiaoChaLvFenJieSheet2
			, table: {
					editable: false
					, style :  "text-align:center"
			}
			, cols : {
				A : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
				}
				, B : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
				}
				, F : { style:"display:none" }
			}
		});
		
		var getGraphData2 = function( row,column){
			
			var value = aGouXiaoChaLvFenJieSheet2[row][column];
			
			value = parseFloat(value) ;
			
			if( value === null || isNaN(value)){
				value = 0;
			}
			
			return value;
	    };
		
		var buildGraph = function(graph)
		{
			graph.Set('chart.ylabels.count', 5);
			graph.Set('chart.numyticks', 10);
			graph.Set('chart.background.grid.vlines', false);
			graph.Set('chart.background.grid.border', false);
			graph.Set('chart.gutter.left', 60);
			graph.Set('chart.shadow', true);
			graph.Set('chart.shadow.blur', 15);
			graph.Set('chart.shadow.offsetx', 0);
			graph.Set('chart.shadow.offsety', 0);
			graph.Set('chart.shadow.color', '#aaa');
		}
		
		var data = [] ;
		var tips = [] ;
		for(var row=1;row<=3;row++)
		{
			data.push([getGraphData2(row, 'C'),getGraphData2(row, 'D')]) ;
		}
		var bar6 = new RGraph.Bar('GouXiaoChaLvFenJie_bar2', data);
		
		buildGraph(bar6);
		bar6.Set('chart.colors',['#34beef','#e5298a']); 
		bar6.Set('chart.labels', ['凤凰山', '湾里', '营业所']);
		bar6.Set('chart.key', ['计划','完成']);
		bar6.Set('chart.tooltips', toTips(data ,' %'));
		bar6.Set('chart.strokestyle', 'transparent');
		bar6.Set('chart.ymax', 100);
		//bar5.Set('chart.key.position.y', 200);
		bar6.ondraw = function (obj)
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
		$(bar6.canvas).data('bar',bar6);
		$(bar6.canvas).on('HuiZhi',function(){
			RGraph.Effects.Bar.Wave($(this).data('bar'));
		});


		//Pie
		var mapPies1 = {};
		mapPies1[1] = {
				col: 'D'
				, canvas: 'GouXiaoChaLvFenJie_pie1'
				, data: []
				, tips: []
			} ;
		mapPies1[2] = {
				col: 'E'
				, canvas: 'GouXiaoChaLvFenJie_pie2'
				, data: []
				, tips: []
			} ;
		
		//今年
		for(var i =1 ;i<=2; i++)
		{
			var aInfo = mapPies1[i] ;
			for(var row=1;row<=3;row++)
			{
				var v = parseFloat(aGouXiaoChaLvFenJieSheet1[row][aInfo.col]) ;
				v = isNaN(v)?0:v ;
				aInfo.data.push(v) ;
				aInfo.tips.push(v.toString());
			};
		
			var pie = new RGraph.Pie(aInfo.canvas, aInfo.data);
			pie.Set('chart.tooltips', aInfo.tips);
			pie.Set('chart.labels.sticks', true);
			pie.Set('chart.key.colors', ['f9bf13','bfd614','38bef3']);
			pie.Set('chart.labels.sticks.length', 20);
			pie.Set('chart.colors', [
									 RGraph.RadialGradient(pie, 150,150,0,150,150,150, 'fcf914', 'f9bf13'),
                                     RGraph.RadialGradient(pie, 150,150,0,150,150,150, 'dcf400', 'bfd614'),
                                     RGraph.RadialGradient(pie, 150,150,0,150,150,150, '6ad6fc', '38bef3')
			]);
			pie.Set('chart.labels', [
						'凤凰山'
						, '湾里'
						, '营业所'
			]);
			pie.Set('chart.radius', 80);
			pie.Set('chart.strokestyle', 'transparent');
			pie.Set('chart.exploded', [20]);
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
		
		
		//去年
		var mapPies2 = {};
		mapPies2[1] = {
				col: 'D'
				, canvas: 'GouXiaoChaLvFenJie_pie3'
				, data: []
				, tips: []
			} ;
		mapPies2[2] = {
				col: 'E'
				, canvas: 'GouXiaoChaLvFenJie_pie4'
				, data: []
				, tips: []
			} ;
		
		for(var i =1 ;i<=2; i++)
		{
			var aInfo = mapPies2[i] ;
			for(var row=1;row<=3;row++)
			{
				var v = parseFloat(aGouXiaoChaLvFenJieSheet2[row][aInfo.col]) ;
				v = isNaN(v)?0:v ;
				aInfo.data.push(v) ;
				aInfo.tips.push(v.toString());
			}
	
		
			var pie2 = new RGraph.Pie(aInfo.canvas, aInfo.data);
			pie2.Set('chart.tooltips', aInfo.tips);
			pie2.Set('chart.labels.sticks', true);
			pie2.Set('chart.key.colors', ['red','blue','#0f0']);
			pie2.Set('chart.labels.sticks.length', 20);
			pie2.Set('chart.labels', [
						'凤凰山'
						, '湾里'
						, '营业所'
			]);
			
			pie2.Set('chart.radius', 80);
			pie2.Set('chart.strokestyle', 'transparent');
			
			pie2.Set('chart.exploded', [20]);
			pie2.Set('chart.colors', [
										 RGraph.RadialGradient(pie, 150,150,0,150,150,150, 'fcf914', 'f9bf13'),
	                                     RGraph.RadialGradient(pie, 150,150,0,150,150,150, 'dcf400', 'bfd614'),
	                                     RGraph.RadialGradient(pie, 150,150,0,150,150,150, '6ad6fc', '38bef3')
				]);
			pie2.Set('chart.shadow', true);
		
			//动画绘制
			$(pie2.canvas).data('pie',pie2);
			$(pie2.canvas).on('HuiZhi',function(){
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
			setTimeout(function () {pie2.Explode(0,10);}, 250);
		}
	}
});


