jquery(function($){
	setTimeout(onLoad , 2100);
	
	function onLoad(){
		var $ = jquery;
		$('#ChengBenDuiBi_table')
		// 初始化 表格插件
		.datagrid({
			data: aChengBenDuiBiSheet
			, table: {
					editable: false
					, style :  "text-align:center"
			}
			, cols : {
				A : {
					formater: function(value) {return value ; }
					, transfer: function(value) {return value ; }
				}
			}
		});
		
		// -------------------------------
		// 2012/2011 各项成本的饼形图
		var mapPies = {
			2012: {
				col: 'B'
				, canvas: 'pie-2012'
				, data: []
			} ,
			2011: {
				col: 'D'
				, canvas: 'pie-2011'
				, data: []
			} ,
		} ;
		
		for(var year in mapPies)
		{
			var aInfo = mapPies[year] ;
		
			for(var row=0;row<16;row++)
			{
				var v = parseFloat(aChengBenDuiBiSheet[row][aInfo.col]) ;
				aInfo.data.push(isNaN(v)?0:v) ;
			}
			
			var pie = new RGraph.Pie(aInfo.canvas, aInfo.data);
			pie.Set('chart.labels.sticks', true);
			pie.Set('chart.labels.sticks.length', 35);
			pie.Set('chart.colors', [
										 RGraph.RadialGradient(pie, 150,150,150,150,150,0, '97e4ff', '38bef3'),
	                                     RGraph.RadialGradient(pie, 150,150,150,150,150,0, 'dcf400', 'bfd614'),
	                                     RGraph.RadialGradient(pie, 150,150,150,150,150,0, 'f5ff4f', 'f9bf13'),
										 RGraph.RadialGradient(pie, 150,150,150,150,150,0, 'ff85ef', 'e5298a'),
										 RGraph.RadialGradient(pie, 150,150,150,150,150,0, '8bffe5', '29e5bb'),
										 RGraph.RadialGradient(pie, 150,150,150,150,150,0, 'ffc53b', 'f96f13'),
	                                     RGraph.RadialGradient(pie, 150,150,150,150,150,0, '26ffc9', '14d6a6'),
	                                     RGraph.RadialGradient(pie, 150,150,150,150,150,0, 'c76dcd', 'a63aad'),
										 RGraph.RadialGradient(pie, 150,150,150,150,150,0, 'ff5384', 'e22157'),
										 RGraph.RadialGradient(pie, 150,150,150,150,150,0, 'a94dff', '8421e0'),
	                                     RGraph.RadialGradient(pie, 150,150,150,150,150,0, '72ff6b', '32e129'),
	                                     RGraph.RadialGradient(pie, 150,150,150,150,150,0, '77fffa', '29e0da'),
										 RGraph.RadialGradient(pie, 150,150,150,150,150,0, '86b6ff', '3577da'),
										 RGraph.RadialGradient(pie, 150,150,150,150,150,0, 'd074ff', '9d2dd7'),
	                                     RGraph.RadialGradient(pie, 150,150,150,150,150,0, '9297ff', '3038db'),
	                                     RGraph.RadialGradient(pie, 150,150,150,150,150,0, '79ffc8', '2adc93')                                     
				]);
			pie.Set('chart.labels', [
						'原水费'
						, '电费'
						, '材料费'
						, '工资'
						, '工资附加'
						, '大修费'
						, '折旧'
						, '保险费'
						, '各种税金'
						, '车辆费'
						, '取暖费'
						, '绿化费'
						, '防暑降温费'
						, '其他费用'
						, '财务费用'
						, '营业外支出'
			]);
			pie.Set('chart.radius', 150);
			pie.Set('chart.strokestyle', 'transparent');
			pie.Set('chart.exploded', [20]);
			
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
		}
	}
});

