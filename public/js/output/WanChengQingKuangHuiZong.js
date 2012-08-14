jquery(function($){
	setTimeout(onLoad , 1000);
	
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
		
		$('#WanChengQingKuangHuiZong_table')
		// 初始化 表格插件
		.datagrid({
			data: aWanChengQingKuangHuiZongSheet
			, table: {
					editable: false
					, style :  "text-align:center"
			}
			, cols: {
				AA:{
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
					, style :  "text-align:center"
				}
				, AB : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
					, style :  "text-align:center"
				}
				, A : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
					, style :  "text-align:center"
				}
				, itemkey: {
					style:"display:none"
				}
				, F:{
					formater: formater
				}
				, G:{
					formater: formater
				}
			}
			, cells: {
				0: {
					AA: {
						attrs: {
							rowspan: 3
						}
					},
					AB: {
						attrs: {
							colspan: 2
						}
					},
					A: {
						ignore: true
					}
				},
				1: {
					AA: {
						ignore: true
					},
					AB: {
						attrs: {
							colspan: 2
						}
					},
					A: {
						ignore: true
					}
					
					},
				2: {
					AA: {
						ignore: true
					},
					AB: {
						attrs: {
							colspan: 2
						}
					},
					A: {
						ignore: true
					}
				},
					3: {
						AA: {
							attrs: {
								rowspan: 3
							}
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					},
					4: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
						
						},
					5: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					},
					3: {
						AA: {
							attrs: {
								rowspan: 3
							}
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					},
					4: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
						
						},
					5: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					},
					6: {
						AA: {
							attrs: {
								rowspan: 3
							}
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					},
					7: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
						
						},
					8: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					},
					9: {
						AA: {
							attrs: {
								rowspan: 3
							}
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					},
					10: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
						
					},
					11: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					},
					12: {
						AA: {
							attrs: {
								rowspan: 6
							}
						},
						AB:	 {
							attrs: {
								rowspan: 2
							}
						},
						
					},
					13: {
						AA: {
							ignore: true
						},
						AB: {
							ignore: true
						},

					},
					14: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								rowspan: 2
							}
						},

					},
					15: {
						AA: {
							ignore: true
						},
						AB: {
							ignore: true
						},

					},
					16: {
						AA: {
							ignore: true
						},
						AB:	 {
							attrs: {
								rowspan: 2
							}
						},

					},
					17: {
						AA: {
							ignore: true
						},
						AB: {
							ignore: true
						},
					},
					18: {
						AA: {
							attrs: {
								rowspan: 3
							}
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}

					},
					19: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					},
					20: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					},
					21: {
						AA: {
							attrs: {
								rowspan: 3
							}
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					},
					22: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
						
					},
					23: {
						AA: {
							ignore: true
						},
						AB: {
							attrs: {
								colspan: 2
							}
						},
						A: {
							ignore: true
						}
					}
			}
		});
		
		var getData = function(row,column){
			var value = aWanChengQingKuangHuiZongSheet[row][column];
			value = parseFloat(value) ;
			
			if( value === null || isNaN(value)){
				value = 0;
			}
			return value;
	    };
	    
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

		
		// 原水量
		var data = [
			[getData(0,'B'),getData(0,'D')]
			, [getData(1,'B'),getData(1,'D')]
			, [getData(2,'B'),getData(2,'D')]
			
			
			// 公司、子公司、合计 日均销售水量
//			, [0,0], [0,0]
//			, [getData(3,'B'),getData(3,'D')]
//			, [getData(4,'B'),getData(4,'D')]
//			, [getData(5,'B'),getData(5,'D')]
		] ;
		
		var bar = new RGraph.Bar('WanChengQingKuangHuiZong_bar1', data);
		buildGraph(bar);
		bar.Set('chart.colors',['#34beef','#e5298a']);
		bar.Set('chart.labels', ['公司', '子公司', '合计']);
		bar.Set('chart.tooltips', toTips(data,' 立方'));
		//bar.Set('chart.variant', '3d');
		bar.Set('chart.key', ['今年','去年']);
		bar.Set('chart.strokestyle', 'transparent');
		bar.Set('chart.ymax', 1000);
		bar.ondraw = function (obj)
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
		$(bar.canvas).data('bar',bar);
		$(bar.canvas).on('HuiZhi',function(){
			RGraph.Effects.Bar.Wave($(this).data('bar'));
		});
		
		
		//销售水量
		
		var data = [
			[getData(3,'B'),getData(3,'D')]
			, [getData(4,'B'),getData(4,'D')]
			, [getData(5,'B'),getData(5,'D')] 
		]
		
		bar = new RGraph.Bar('WanChengQingKuangHuiZong_bar6', data);
		buildGraph(bar);
		bar.Set('chart.colors',['#34beef','#e5298a']); 
		bar.Set('chart.labels', ['公司', '子公司', '合计']);
		bar.Set('chart.tooltips', toTips(data,' 立方'));
		//bar.Set('chart.variant', '3d');
		bar.Set('chart.key', ['今年','去年']);
		bar.Set('chart.strokestyle', 'transparent');
		bar.Set('chart.ymax', 1000);
		bar.ondraw = function (obj)
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
		$(bar.canvas).data('bar',bar);
		$(bar.canvas).on('HuiZhi',function(){
			RGraph.Effects.Bar.Wave($(this).data('bar'));
		});
		
		
		// 管网漏损率 
		var data = [
			[getData(6,'B'),getData(6,'D')]
			, [getData(7,'B'),getData(7,'D')]
			, [getData(8,'B'),getData(8,'D')]
		] ;
		
		var bar = new RGraph.Bar('WanChengQingKuangHuiZong_bar2', data);
		buildGraph(bar);
		bar.Set('chart.colors',['#34beef','#e5298a']); 
		bar.Set('chart.labels', ['公司', '子公司', '合计']);
		bar.Set('chart.tooltips', toTips(data,'%'));
		//bar.Set('chart.variant', '3d');
		bar.Set('chart.key', ['今年','去年']);
		bar.Set('chart.strokestyle', 'transparent');
		bar.Set('chart.ymax', 100);
		bar.ondraw = function (obj)
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
		$(bar.canvas).data('bar',bar);
		$(bar.canvas).on('HuiZhi',function(){
			RGraph.Effects.Bar.Wave($(this).data('bar'));
		});

		//购销差率
		var data = [		
		    		[getData(9,'B'),getData(9,'D')]
		    		, [getData(10,'B'),getData(10,'D')]
		    		, [getData(11,'B'),getData(11,'D')]
		    	] ;
		    	
		var bar = new RGraph.Bar('WanChengQingKuangHuiZong_bar7', data);
		buildGraph(bar);
		bar.Set('chart.colors',['#34beef','#e5298a']); 
		bar.Set('chart.labels', ['公司', '子公司', '合计']);
		bar.Set('chart.tooltips', toTips(data,'%'));
		//bar.Set('chart.variant', '3d');
		bar.Set('chart.key', ['今年','去年']);
		bar.Set('chart.strokestyle', 'transparent');
		bar.Set('chart.ymax', 100);
		bar.ondraw = function (obj)
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
		$(bar.canvas).data('bar',bar);
		$(bar.canvas).on('HuiZhi',function(){
			RGraph.Effects.Bar.Wave($(this).data('bar'));
		});
		
		
		// 销售收入、预计补贴、收入总额、成本总额、盈亏情况
		var mapGraph = [
			{
				title: '公司'
				, canvas: 'WanChengQingKuangHuiZong_bar3'
			}
			, {
				title: '子公司'
				, canvas: 'WanChengQingKuangHuiZong_bar4'
			}
			, {
				title: '合计'
				, canvas: 'WanChengQingKuangHuiZong_bar5'
			}
		] ;
		for(var gidx=0;gidx<mapGraph.length;gidx++)
		{
			var aInfo = mapGraph[gidx] ;
			
			var data = [
			    // 销售收入
				[ getData(12+gidx*2,'B'), getData(12+gidx*2,'D') ]
				// 预计补贴
				, [ getData(13+gidx*2,'B'), getData(13+gidx*2,'D') ]
				// 收入总额 (=销售收入+预计补贴)
				, [ getData(12+gidx*2,'B')+getData(13+gidx*2,'B'), getData(12+gidx*2,'D')+getData(13+gidx*2,'D') ]

			    // 成本总额
				, [ getData(18+gidx,'B'), getData(18+gidx,'D') ]
				// 盈亏情况
				, [ getData(21+gidx,'B'), getData(21+gidx,'D') ]
			]

			var bar = new RGraph.Bar(aInfo.canvas, data);
			buildGraph(bar);
			bar.Set('chart.colors',['#34beef','#e5298a']); 
			bar.Set('chart.labels', ['销售收入', '补贴', '收入总额', '成本', '盈亏']);
//			bar.Set('chart.labels', [aInfo.title+'销售收入', aInfo.title+'预计补贴', aInfo.title+'收入总额', aInfo.title+'成本总额', aInfo.title+'盈亏情况']);
			bar.Set('chart.tooltips', toTips(data,' 万元'));
			//bar.Set('chart.variant', '3d');
			bar.Set('chart.key', ['今年','去年']);
			bar.Set('chart.strokestyle', 'transparent');
			bar.Set('chart.ymax', 1300000);
			bar.ondraw = function (obj)
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
			$(bar.canvas).data('bar',bar);
			$(bar.canvas).on('HuiZhi',function(){
				RGraph.Effects.Bar.Wave($(this).data('bar'));
			});
		}
	}
});

