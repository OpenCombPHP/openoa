jquery(function($){
	setTimeout(onLoad , 1400);
	
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
		
		$('#WanChengQingKuangTongJi_table')
		// 初始化 表格插件
		.datagrid({
			data: aWanChengQingKuangTongJiSheet
			, table: {
					editable: false
					, style :  "text-align:center"
			}
		, cols: {
			0 :{
				formater: function(value) {return value ; }
				, transfer: function(value) {return value ; }
				, style :  "text-align:center"
			}
			, D : {
				formater : formater
			}
			, F: {
				formater: function(value) {return value ; }
				, transfer: function(value) {return value ; }
				, style :  "text-align:center"
			}
			, E: {
				style:"display:none"
			}
		}
		,cells: {
			0: {
				0: {
					attrs: {
						rowspan: 4
					}
				},
			},
			1: {
				0: {
					ignore: true
				},
			},
			2: {
				0: {
					ignore: true
				},
			},
			3: {
				0: {
					ignore: true
				},
			},
			4: {
				0: {
					attrs: {
						rowspan: 4
					}
				},
			},
			5: {
				0: {
					ignore: true
				},
			},
			6: {
				0: {
					ignore: true
				},
			},
			7: {
				0: {
					ignore: true
				},
			},
			8: {
				0: {
					attrs: {
						rowspan: 4
					}
				},
			},
			9: {
				0: {
					ignore: true
				},
			},
			10: {
				0: {
					ignore: true
				},
			},
			11: {
				0: {
					ignore: true
				},
			}
			}
		});
		
		var getGraphData = function( row,column){
			
			var value = aWanChengQingKuangTongJiSheet[row][column];
			
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
		
		for(var row=0;row<=8;row+=4)
		{
			data.push([getGraphData(row, 'A'),getGraphData(row, 'B')]) ;
		}
		
		var bar5 = new RGraph.Bar('WanChengQingKuangTongJi_bar1', data);
		
//		var bar5 = new RGraph.Bar('WanChengQingKuangTongJi_bar1', [
//	   			   [getGraphData(0, 'A'),getGraphData(0, 'B')]
//				   , [getGraphData(4, 'A'),getGraphData(4, 'B')]
//				   , [getGraphData(8, 'A'),getGraphData(5, 'B')]
//				   ]);
		buildGraph(bar5);
		
		bar5.Set('chart.colors',['#e52951','#f1bc17']);  
		bar5.Set('chart.labels', ['售水', '配水', '原水']);
		bar5.Set('chart.tooltips', toTips(data,' m³'));
		bar5.Set('chart.key', ['今年', '去年']);
		bar5.Set('chart.strokestyle', 'transparent');
		bar5.Set('chart.ymax', 400);
		//bar5.Set('chart.title', '本月');
		bar5.Set('chart.title.size', 2);
		bar5.Set('chart.title.font', 'Verdana');
		bar5.Set('chart.title.color', 'red');
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
		
		
		
		var data = [] ;
		var tips = [] ;
		for(var row=2;row<=10;row+=4)
		{
			data.push([getGraphData(row, 'A'),getGraphData(row, 'B')]) ;
		}
		
		var bar6 = new RGraph.Bar('WanChengQingKuangTongJi_bar2', data);
		
//		var bar6 = new RGraph.Bar('WanChengQingKuangTongJi_bar2', [
//				   [getGraphData(2, 'A'),getGraphData(2, 'B')]
//				   , [getGraphData(6, 'A'),getGraphData(7, 'B')]
//				   , [getGraphData(10, 'A'),getGraphData(10, 'B')]
//				   ]);
		buildGraph(bar6);
		bar6.Set('chart.colors',['#e52951','#f1bc17']);
		bar6.Set('chart.labels', ['售水', '配水', '原水']);
		bar6.Set('chart.tooltips', toTips(data,' m³'));
		bar6.Set('chart.key', ['今年','去年']);
		bar6.Set('chart.strokestyle', 'transparent');
		bar6.Set('chart.ymax', 3000);
		//bar6.Set('chart.title', '累计');
		bar6.Set('chart.title.size', 2);
		bar6.Set('chart.title.font', 'Verdana');
		bar6.Set('chart.title.color', 'red');
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
	}
	
});

