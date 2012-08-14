jquery(function($){
	setTimeout(onLoad , 2200);
	
	function onLoad(){
		var $ = jquery;
		$('#ZhaoDaiFei_table')
		// 初始化 表格插件
		.datagrid({
			data: aZhaoDaiFeiSheet
			, table: {
					editable: false
					, style :  "text-align:center"
			}
			, rows : {
				2 : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
					, style :  "text-align:center;color:black;font-weight:bold;"
				}
			}
			, cols: {
				A : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
					
				}
				, 'type': {
					style:"display:none;"
				}
			}
		});
		
		// ---------------------------
		// 图表
		var gutterLeft = 150;
		var gutterRight = 10;
		
		var line1 = new RGraph.Line('cvs', [
	       		aZhaoDaiFeiSheet[0].B? aZhaoDaiFeiSheet[0].B: 0
	       		, aZhaoDaiFeiSheet[0].D? aZhaoDaiFeiSheet[0].D: 0
	       		, aZhaoDaiFeiSheet[0].F? aZhaoDaiFeiSheet[0].F: 0
	       		, aZhaoDaiFeiSheet[0].H? aZhaoDaiFeiSheet[0].H: 0
	       		, aZhaoDaiFeiSheet[0].J? aZhaoDaiFeiSheet[0].J: 0
	       		, aZhaoDaiFeiSheet[0].L? aZhaoDaiFeiSheet[0].L: 0
	       		, aZhaoDaiFeiSheet[3].B? aZhaoDaiFeiSheet[3].B: 0
	       		, aZhaoDaiFeiSheet[3].D? aZhaoDaiFeiSheet[3].D: 0
	       		, aZhaoDaiFeiSheet[3].F? aZhaoDaiFeiSheet[3].F: 0
	       		, aZhaoDaiFeiSheet[3].H? aZhaoDaiFeiSheet[3].H: 0
	       		, aZhaoDaiFeiSheet[3].J? aZhaoDaiFeiSheet[3].J: 0
	       		, aZhaoDaiFeiSheet[3].L? aZhaoDaiFeiSheet[3].L: 0
		]);
		line1.Set('chart.ymax', 1000);
		line1.Set('chart.hmargin', 5);
		line1.Set('chart.gutter.right', gutterRight);
		line1.Set('chart.gutter.left', gutterLeft);
		line1.Set('chart.labels', ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月']);
		line1.Set('chart.colors', ['e52944', 'b4ca11']);
		line1.Set('chart.key', ['收入', '支出']);
		line1.Set('chart.key.position', 'gutter');
		line1.Set('chart.key.position.gutter.boxed', false);
		line1.Set('chart.key.position.x', 280);
		line1.Set('chart.linewidth', 2);
		line1.Set('chart.noaxes', true);
		line1.Set('chart.ylabels', false);
		
		var line2 = new RGraph.Line('cvs', [
	    		aZhaoDaiFeiSheet[1].B? aZhaoDaiFeiSheet[1].B: 0? aZhaoDaiFeiSheet[1].B? aZhaoDaiFeiSheet[1].B: 0: 0
	    		, aZhaoDaiFeiSheet[1].D? aZhaoDaiFeiSheet[1].D: 0
	    		, aZhaoDaiFeiSheet[1].F? aZhaoDaiFeiSheet[1].F: 0
	    		, aZhaoDaiFeiSheet[1].H? aZhaoDaiFeiSheet[1].H: 0
	    		, aZhaoDaiFeiSheet[1].J? aZhaoDaiFeiSheet[1].J: 0
	    		, aZhaoDaiFeiSheet[1].L? aZhaoDaiFeiSheet[1].L: 0
	    		, aZhaoDaiFeiSheet[4].B? aZhaoDaiFeiSheet[4].B: 0
	    		, aZhaoDaiFeiSheet[4].D? aZhaoDaiFeiSheet[4].D: 0
	    		, aZhaoDaiFeiSheet[4].F? aZhaoDaiFeiSheet[4].F: 0
	    		, aZhaoDaiFeiSheet[4].H? aZhaoDaiFeiSheet[4].H: 0
	    		, aZhaoDaiFeiSheet[4].J? aZhaoDaiFeiSheet[4].J: 0
	    		, aZhaoDaiFeiSheet[4].L? aZhaoDaiFeiSheet[4].L: 0
	    ]);
		line2.Set('chart.ymax', 1000);
		line2.Set('chart.background.grid', false);
		line2.Set('chart.colors', ['b4ca11']);
		line2.Set('chart.hmargin', 5);
		line2.Set('chart.linewidth', 2);
		line2.Set('chart.noaxes', true);
		line2.Set('chart.gutter.right', gutterRight);
		line2.Set('chart.gutter.left', gutterLeft);
		line2.Set('chart.tooltips', ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月']);
		line2.Set('chart.ylabels', false);
		
		/**
		* This draws the extra axes. It's run whenever the line3 object is drawn
		*/
		myFunc = function ()
		{
		    RGraph.DrawAxes(line1, {
		                            'axis.x': 150,
		                            'axis.y': 25,
		                            'axis.color': 'red',
		                            'axis.text.color': 'red',
		                            'axis.max': 1000,
		                            'axis.min': 0
		                           });
		    RGraph.DrawAxes(line2, {
		                            'axis.x': 100,
		                            'axis.y': 25,
		                            'axis.color': 'green',
		                            'axis.text.color': 'green',
		                            'axis.max': 1000
		                           });
		};
		RGraph.AddCustomEventListener(line2, 'ondraw', myFunc);
		
		//动画绘制
		$(line1.canvas).data('line',line1);
		$(line1.canvas).on('HuiZhi',function(){
			RGraph.Effects.Line.Unfold($(this).data('line'));
		});
		
		//动画绘制
		$(line2.canvas).data('line',line2);
		$(line2.canvas).on('HuiZhi',function(){
			RGraph.Effects.Line.Unfold($(this).data('line'));
			//RGraph.Effects.Line.UnfoldFromCenterTrace($(this).data('line'));
			//RGraph.Effects.Line.FoldToCenter($(this).data('line'), {'duration': 1500});
			//RGraph.Effects.Line.Unfold($(this).data('line'));
		});
	}
});