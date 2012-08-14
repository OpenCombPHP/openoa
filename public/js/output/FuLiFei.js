jquery(function($){
	setTimeout(onLoad , 2300);
	
	function onLoad(){
		var $ = jquery;
		$('#FuLiFei_table')
		// 初始化 表格插件
		.datagrid({
			data: aFuLiFeiSheet
			, table: {
					editable: false
					, style :  "text-align:center;"
			}
			, rows: {
				10 : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
					, style :  "text-align:center;font-weight:bold;color:black"
				}
			}
			, cols: {
				A : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
				}
				, 'type' : { style:'display:none' }
			}
		});
		// ------------------
		// 图表
		var getGraphData = function(startMonth,endMonth,startRow,endRow){
	    	
	    	var sheetData = [] ;
	    	
			for(var m=startMonth;m<=endMonth;m++)
			{
				var month = m ;
				var _startRow = typeof(startRow)=='undefined'? 3: startRow ; 
				var _endRow = typeof(endRow)=='undefined'? 8: endRow ;
				
				// 下半年
				if(month>6)
				{
					month-= 6 ;
					_startRow+= 11 ;
					_endRow+= 11 ;
				}
				
				var col = String.fromCharCode(66+(month-1)*2) ;
				
				var rowData = [] ;
				for(var row=_startRow;row<=_endRow;row++)
				{
					var v = parseFloat(aFuLiFeiSheet[row][col]) ;
					rowData.push( isNaN(v)? 0: v ) ;
				}
				sheetData.push(rowData) ;
			}
			
			return sheetData ;
	    };
	    
		var buildGraph = function(graph)
		{
			graph.Set('chart.colors', ['#f9bf13','#bfd614','#38bef3','#e5298a','#d8470e','#29e5bb']);
			graph.Set('chart.ylabels.count', 5);
		    graph.Set('chart.numyticks', 10);
			graph.Set('chart.ymax', 50000);
		    graph.Set('chart.background.grid.vlines', false);
		    graph.Set('chart.background.grid.border', false);
		    graph.Set('chart.gutter.left', 60);
		    graph.Set('chart.labels', ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月']);
		    graph.Set('chart.shadow', true);
		    graph.Set('chart.shadow.blur', 15);
		    graph.Set('chart.shadow.offsetx', 0);
		    graph.Set('chart.shadow.offsety', 0);
		    graph.Set('chart.shadow.color', '#aaa');
		    graph.Set('chart.strokestyle', 'rgba(0,0,0,0)');
		}
		
	    var bar_A = new RGraph.Bar('canvasFuLiFei_A',  getGraphData(1,6) );			// 上半年支出明细
	    var bar_B = new RGraph.Bar('canvasFuLiFei_B', getGraphData(7,12)  );		// 下半年支出明细
	    bar_C = new RGraph.Bar('canvasFuLiFei_C', getGraphData(1,12,1,2)  );	// 全年收支

	    buildGraph(bar_A) ;
	    bar_A.Set('chart.labels', ['一月','二月','三月','四月','五月','六月']);
	    bar_A.Set('chart.key', ['食堂拨款', '托保费', '洗理费', '职工药费', '其他', '垫付药费']);

	    buildGraph(bar_B) ;
	    bar_B.Set('chart.labels', ['七月','八月','九月','十月','十一月','十二月']);
	    bar_B.Set('chart.key', ['食堂拨款', '托保费', '洗理费', '职工药费', '其他', '垫付药费']);

	    buildGraph(bar_C) ;
	    bar_C.Set('chart.colors', ['e52944','b4ca11']);
	    bar_C.Set('chart.key', ['提取', '支出']);
	    bar_C.Set('chart.ymax', 250000);
	    
	    // New, more compact, "DOM1-esque", style of adding events
	    bar_A.ondraw = bar_B.ondraw = bar_C.ondraw = function (obj)
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
		$(bar_A.canvas).data('bar',bar_A);
		$(bar_A.canvas).on('HuiZhi',function(){
			RGraph.Effects.Bar.Grow($(this).data('bar'));
		});
		
		//动画绘制
		$(bar_B.canvas).data('bar',bar_B);
		$(bar_B.canvas).on('HuiZhi',function(){
			RGraph.Effects.Bar.Grow($(this).data('bar'));
		});
		
		//动画绘制
		$(bar_C.canvas).data('bar',bar_C);
		$(bar_C.canvas).on('HuiZhi',function(){
			RGraph.Effects.Bar.Grow($(this).data('bar'));
		});
	}
});

