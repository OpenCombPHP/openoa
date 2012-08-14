
(function($) {

	$.fn.formulas = function(options,args)
	{
		if(options)
		{
			var settings = {} ;
			settings = $.extend(true, settings, $.fn.formulas.defaults, options);

			datagrid = new $._formulas(this, settings);
			$(this).data('formulas',datagrid) ;
			
			return $(this) ;
		}
		else
		{
			return $(this).data('formulas') ;
		}
	};
	
	// default options
	$.fn.formulas.defaults = {
			onInit: function() {}
			, sheets: {} 
	};
	
	///////////////////////////////////////////////////

	$._formulas = function(e,settings)
	{
		this.e = e ;
		this.settings = settings ;
		
		var realThis = this ;

		$(this.e).bind('onAfterValueChange',function(event,row,col,value){
			realThis.onDataGridAfterEdit(row,col,value) ;
		});
		$(this.e).bind('onAfterLoadData',function(event){
			realThis.onDataGridAfterLoadData(event.target) ;
		});

		// 用于找到 公式中 变量的 regexp
		this.regFormulaAssignment = /(\$(([\w\d_\-]+):)?([A-Za-z]+)?(\d+)?)\s*=(.+)/ ;
		this.regFormulaCells = /\$(([\w\d_\-]+):)?([A-Za-z]+)?(\d+)?/g ;
		
		this.bOnlyNaN = false ;
		this.arrFormulas = [] ;
		this.mapFormulas = {} ;
		this.mapSheets = {} ;
		
		for(var tableName in this.settings.sheets)
		{
			this.addSheet(tableName,this.settings.sheets[tableName]) ;
		}
		
		this.onInit = settings.onInit ;
		this.onInit() ;
	}
	$._formulas.prototype.onDataGridAfterEdit = function(row,col,value)
	{
		var sKey = '*:'+col+':'+row ;
		if( typeof(this.mapFormulas[sKey])=='undefined' )
		{
			return ;
		}
		for(var i=0;i<this.mapFormulas[sKey].length;i++)
		{
			this.applyFormula(this.mapFormulas[sKey][i]) ;
		}
	}
	$._formulas.prototype.applyAllFormulas = function()
	{
		this.bOnlyNaN = true ;
		
		for(var i=0;i<this.arrFormulas.length;i++)
		{
			this.applyFormula(this.arrFormulas[i]) ;
		}

		this.bOnlyNaN = false ;
		
		// 
		this.onDataGridAfterLoadData(this.e) ;
	}
	$._formulas.prototype.applyFormula = function(aFormula)
	{
		var sExpression = aFormula.expression ;
		var aDataGrid = this.datagrid() ;
		
		// 只修改NaN的数据
		if( this.bOnlyNaN && !isNaN( aDataGrid.value(aFormula.leftVar.row,aFormula.leftVar.column) ) )
		{
			return ;
		}
		
		// 取值 并 套用到 公式表达式中
		for(var varIdx=0;varIdx<aFormula.rightVars.length;varIdx++)
		{
			var variable = aFormula.rightVars[varIdx] ;
			var value = this.fetchValue(variable.table,variable.row,variable.column) ;
			sExpression = sExpression.replace('${'+varIdx+'}',value) ;
		}
		
		// 计算公式
		console.log('应用公式：'+aFormula.formulaSource+'; 代入：' + sExpression) ;
		var value = eval(sExpression) ;
		
		//消灭NaN和Infinity
		if( !value || value===Infinity){
			value = 0;
		}
	
		aDataGrid.setValue(aFormula.leftVar.row,aFormula.leftVar.column,value) ;
	}

	$._formulas.prototype.addSheet = function(name,sheet)
	{
		this.mapSheets[name] = sheet ;
	}

	$._formulas.prototype.parseFormula = function(sFormula)
	{
		var res = this.regFormulaAssignment.exec(sFormula) ;
		if(!res)
		{
			return ;
		}
		var sExpression = res[6] ;
		
		// 找到左侧变量
		this.regFormulaCells.lastIndex=0 ;
		res = this.regFormulaCells.exec(res[1]) ;
		
		var aFormula = {
			leftVar: {
				column: res[3]
				, row: parseInt(res[4])-1
			}
			, rightVars: []
			, expression: sExpression
			, formulaSource: sFormula
		} ;
		
		// 找到右侧变量
		this.regFormulaCells.lastIndex=0 ;
		while(res=this.regFormulaCells.exec(aFormula.expression))
		{
			var mapVariable = {
					table: res[2]? res[2]: '*'
					, column: res[3]
					, row: parseInt(res[4])-1
					, len: res[0].length
					, pos: this.regFormulaCells.lastIndex - res[0].length
			}
			
			aFormula.rightVars.push(mapVariable) ;
			
			var key = mapVariable.table + ':' + mapVariable.column + ':' + mapVariable.row ;
			if(typeof(this.mapFormulas[key])=='undefined')
			{
				this.mapFormulas[key] = [] ;
			}
			this.mapFormulas[key].push(aFormula) ;
		}
		
		// 编译表达式
		for(var i=aFormula.rightVars.length-1;i>=0;i--)
		{
			var aVar = aFormula.rightVars[i] ;
			aFormula.expression = aFormula.expression.substr(0,aVar.pos) + '${' + i + '}' + aFormula.expression.substr(aVar.pos+aVar.len) ;
		}
		
		this.arrFormulas.push(aFormula) ;
	}


	$._formulas.prototype.fetchValue = function(sTable,nRow,sColumn)
	{
		if(sTable=='*')
		{
			return this.datagrid().value(nRow,sColumn);
		}
		else
		{
			return this.mapSheets[sTable][nRow][sColumn] ? parseFloat(this.mapSheets[sTable][nRow][sColumn]) : 0 ;
		}
	}

	$._formulas.prototype.datagrid = function()
	{
		return $(this.e).data('datagrid') ;
	}
	
	$._formulas.prototype.onDataGridAfterLoadData = function(target){

		var aDataGrid = $(target).datagrid() ;
		
		// input
		for(var i=0;i<this.arrFormulas.length;i++)
		{
			var aFormula = this.arrFormulas[i] ;
										
			for(var l=0;l<aFormula.rightVars.length;l++)
			{
				var variable = aFormula.rightVars[l] ;
				if(variable.table!='*')
				{
					continue ;
				}
				
				aDataGrid._cell(variable.row,variable.column)
						.addClass('input-cell')
						.attr('title',aFormula.formulaSource) ;
			}
		}

		// result
		for(var i=0;i<this.arrFormulas.length;i++)
		{
			var variable = this.arrFormulas[i].leftVar ;

			aDataGrid._cell(variable.row,variable.column)
						.removeClass('input-cell')
						.addClass('result-cell')
						.attr('title',this.arrFormulas[i].formulaSource) ;
		}
	}
	
})(jQuery);
