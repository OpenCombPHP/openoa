
(function($) {
	$.fn.datagrid = function(options,args)
	{
		if(this.length === 0){
			throw Error('没有找到表格');
		}
		if(options)
		{
			var settings = {} ;
			settings = $.extend(true, settings, $.fn.datagrid.defaults, options);

			datagrid = new $._datagrid(this, settings);
			
			return $(this) ;
		}
		else
		{
			return $(this).data('datagrid') ;
		}
	};
	
	// default options
	$.fn.datagrid.defaults = {
			url: null
			, table : {
				editable: true
				, attrs: {}
				, ignore: false			// 忽略这一格（用于 rowspan, colspan）
				, style: ''
				, class: ''
				
				// 显示数据时的处理函数
				, formater: function(value,row,col,cell){
					// NaN 显示为空
					if( isNaN(value) )
					{
						return '' ;
					}
					
					// 千位符
					value = $._datagrid.thousandsBreak(value) ;
					
					return value ;
				}
	
				// 数据的类型转换函数
				, transfer: function(value,row,col,cell){
					// 转换成 浮点型
					value = parseFloat(value) ;
					// 取小数点后两位
					return Math.round(value*100)/100 ;
				}
			}
			, rows: {}
			, cols: {}
			, cells: {}
	};
	
	///////////////////////////////////////////////////

	$._datagrid = function(e,settings)
	{
		var datagrid = this ;
		this.e = e ;
		this.settings = settings ;
		
		this.editingCell = null ;
		this.lastEditedCell = null ;
		this._mapTdBuffer = {} ;

		$(e).data('datagrid',this) ;
		
		// 创建 tab focus catcher
		this.tabCatcher = $(e).after('<input style="height:1px;width:1px;border-width:0px" />')
				.find('+input')
				.focus(function(){
					datagrid._nextEditer() ;
					return false ;
				}) ;
		
		if(this.settings.data)
		{
			this.loadData(this.settings.data) ;
		}
		else if(this.settings.url)
		{
			this.load() ;
		}
	}
	
	/**
	 * 从 url 加载数据
	 */
	$._datagrid.prototype.load = function(url,bAppend)
	{
		var realThis = this ;
		$.ajax({
			url : typeof(url)=='undefined'? this.settings.url: url
			, type: "POST"
			, dataType : 'json'
			, success : function(data) {
				realThis.loadData(data,typeof(bAppend)=='undefined'?false:bAppend) ;
			}
		});
		
		return this ;
	}
	
	/**
	 * 添加数据
	 */
	$._datagrid.prototype.loadData = function(data,bAppend)
	{
		this._log("loadData") ;
		this._log(data) ;
		var tbody = this._tbody() ;
		
		if( typeof(bAppend)=='undefined' || !bAppend )
		{
			tbody.remove('tr.datagrid-row') ;
			
			// 清除 td 缓存
			this._mapTdBuffer = {} ;
		}
		
		$(this.e).data('datagrid.loadedData',data) ;
		
		var datagrid = this ;
		
		// 遍历 行
		for(var row=0;row<data.length;row++)
		{
			var newRow = $('<tr class="datagrid-row" row="'+row+'"></tr>').appendTo(tbody);
			// 遍历 列
			for(var col in data[row])
			{
				// cell setting
				var cellSettings = {}
				$.extend(cellSettings, this.settings.table
							, typeof(this.settings.rows[row])=='undefined'?{}:this.settings.rows[row]
							, typeof(this.settings.cols[col])=='undefined'?{}:this.settings.cols[col]
							, (typeof(this.settings.cells[row])=='undefined' || typeof(this.settings.cells[row][col])=='undefined') ? {} : this.settings.cells[row][col]
				) ;
				
				if( typeof(cellSettings.ignore)!='undefined' && cellSettings.ignore )
				{
					continue ;
				}
				
				var sAttrs = " " ;
				for(var attrName in cellSettings.attrs)
				{
					sAttrs+= attrName + '="' + cellSettings.attrs[attrName] + '" ' ;
				}
				
				// 创建 cell -----------// 绑定 td 的事件
				var newCell = $('<td class="datagrid-cell '+cellSettings.class+'" style="'+cellSettings.style+'" row="'+row+'" col="'+col+'"'+sAttrs+'><div class="datagrid-value" row="'+row+'" col="'+col+'"></div></td>')
						.data('settings',cellSettings)
						.dblclick(function(){
							datagrid.startEdit( 
									parseInt($(this).parent().attr('row'))
									, $(this).attr('col')
							) ;
						}) ;
				newRow.append(newCell);
				//this.log(col+row+':') ;
				//this.log(cellSettings) ;
				
				// set value
				this._setValue(row,col,newCell,data[row][col]) ;
				// -----------
				
				// build td cache
				this._cellCache(row,col) ;
				this._mapTdBuffer[row][col] = newCell ;
			}
		}

		// 触发 loadData 事件
		$(this.e).trigger('onAfterLoadData');
		
		return this ;
	}

	$._datagrid.prototype.value = function(row,col)
	{
		return this._cell(row,col).data('datagrid.value') ;
	}
	$._datagrid.prototype.setValue = function(row,col,value)
	{
		var cell = this._cell(row,col) ;
		if(!cell)
		{
			return null ;
		}
		this._setValue(row,col,cell,value) ;

		return this ;
	}
	$._datagrid.prototype._setValue = function(row,col,cell,value)
	{
		var settings = cell.data('settings') ;
		if( settings && typeof settings.transfer == 'function' )
		{
			value = settings.transfer(value,row,col,cell) ;
		}
		
		cell.data('datagrid.value',value) ;

		this._divValue(row,col).html(
				(settings && typeof settings.formater == 'function')?
						settings.formater(value,row,col,cell): value
		) ;
		
		// 触发 change 事件
		$(this.e).trigger('onAfterValueChange',[row,col,value]);

		return this ;
	}
	$._datagrid.prototype.data = function()
	{
		var data = [] ;
		var datagrid = this ;

		$(this.e).find("tr.datagrid-row").each(function (){
			
			var row = parseInt($(this).attr('row')) ;
			data[row] = {} ;
			
			$(this).find("td.datagrid-cell").each(function(){

				var col = $(this).attr('col') ;
				
				data[row][col] = datagrid.value(row,col) ;
			})
			
		}) ;
		
		return data ;
	}

	/**
	 * 进入cell的编辑状态
	 */
	$._datagrid.prototype.startEdit = function(row,col)
	{
		var cell = this._cell(row,col) ;
		if( !cell.data('settings').editable )
		{
			return ;
		}
		
		this.editingCell = this._cell(row,col) ;
		
		var editer = this._editer(row,col) ;
		var divValue = this._divValue(row,col) ;
		
		var topCellOfColumn = this.e.find('td[row=0][col='+cell.attr('col')+']');
		
		var width = topCellOfColumn.data('width');
		if(!width){
			var width = cell.width() - 1;
			cell.width( width + 2 );
			topCellOfColumn.data('width',width);
		}
		
		var height = cell.height() - 7 ;
		
		divValue.hide() ;
		editer.width( width )
				.height( height )
				.val( this.value(row,col) )
				.show()
				[0].focus() ;
		
		return this ;
	}
	/**
	 * 结束cell的编辑状态
	 */
	$._datagrid.prototype.finishEdit = function(row,col)
	{
		if( !this._cell(row,col).data('settings').editable )
		{
			return ;
		}

		this.editingCell = null ;
		this.lastEditedCell = this._cell(row,col) ;
		
		var editer = this._editer(row,col) ;
		var divValue = this._divValue(row,col) ;

		editer.hide()[0].blur() ;
		divValue.show() ;
		
		this.setValue(row,col,editer.val())
		
		return this ;
	}
	
	
	// private --------------
	
	$._datagrid.prototype._log = $._datagrid.prototype.log = function(msg)
	{
		console.log(msg) ;
	}
	
	$._datagrid.prototype._tbody = function(tableName)
	{
		var tbody = $(this.e).find('>tbody') ;
		if(!tbody.size())
		{
			tbody = $(this.e).append("<tbody></tbody>").find('>tbody').last() ;
		}
		return tbody ;
	}
	$._datagrid.prototype._cellCache = function(row,col)
	{
		if(typeof(this._mapTdBuffer[row])=='undefined')
		{
			this._mapTdBuffer[row] = {}
		}
		if( typeof(this._mapTdBuffer[row][col])!='undefined' )
		{
			return this._mapTdBuffer[row][col] ;
		}
		else
		{
			return null ;
		}
	}
	$._datagrid.prototype._cell = function(row,col)
	{
		var cell = this._cellCache(row,col) ;
		if(cell)
		{
			return cell ;
		}
		else
		{
			return this._mapTdBuffer[row][col] = $(this.e).find("tr[row="+row+"]>td[col="+col+"]").first() ;
		}
	}
	$._datagrid.prototype._divValue = function(row,col)
	{
		return this._cell(row,col).find(">div.datagrid-value") ;
	}
	$._datagrid.prototype._editer = function(row,col)
	{
		var cell = this._cell(row,col) ;
		var editer = cell.find('>input.datagrid-editer').first() ;
		if( !editer.size() )
		{
			var datagrid = this ;
			
			// 创建 cell 的editer
			editer = cell.append('<input type="text" style="display:none" class="datagrid-editer" row="'+row+'" col="'+col+'" />')
				.find('>input.datagrid-editer')
				.blur(function(){
					datagrid.finishEdit( 
						parseInt($(this).attr('row'))
						, $(this).attr('col')
					) ;
				})
				.keypress(function(event){
					// enter键 下一行的同列
					if(event.charCode==13)
					{
						// 
						nextRowCell = datagrid.editingCell.parent('tr.datagrid-row')
									// 下一行 tr
									.find('+tr.datagrid-row')
									// 相同列
									.find(">td.datagrid-cell[col="+col+"]").first() ;

						datagrid.finishEdit(row, col) ;
						
						if(nextRowCell.size())
						{
							datagrid.startEdit(nextRowCell.attr('row'),nextRowCell.attr('col')) ;
						}
					}
				})
		}
		
		return editer ;
	}
	$._datagrid.prototype._nextEditer = function()
	{
		var cell = this.lastEditedCell ;
		
		do{
			// 同行内
			var nextCell = cell.find("+td.datagrid-cell").first() ;
			
			// 下一行
			if( !nextCell.size() )
			{
				nextCell = cell.parent('tr.datagrid-row')
							// 下一行 tr
							.find('+tr.datagrid-row')
							// 第一列
							.find(">td.datagrid-cell").first() ;
				
				console.log(nextCell) ;
			}
			
			// 到表尾
			if(!nextCell.size())
			{
				return ;
			}
			
			cell = nextCell ;
			
		// 检查 editable
		} while( !nextCell.data('settings').editable ) ;

		this.startEdit(nextCell.attr('row'),nextCell.attr('col')) ;
	}

	$._datagrid.thousandsBreak = function (s){
		s = s.toString() ;
		if(/[^0-9\.]/.test(s))
		{
			return s ;
		}
		s=s.replace(/^(\d*)$/,"$1.");
		s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");
		s=s.replace(".",",");
		var re=/(\d)(\d{3},)/;
		while(re.test(s))
		{
			s=s.replace(re,"$1,$2");
		}
		s=s.replace(/,(\d\d)$/,".$1");
		return s.replace(/^\./,"0.")
	}
	
})(jQuery);
