var debug = false;
var TYPES = {
    'undefined'        : 'undefined',
    'number'           : 'number',
    'boolean'          : 'boolean',
    'string'           : 'string',
    '[object Function]': 'function',
    '[object RegExp]'  : 'regexp',
    '[object Array]'   : 'array',
    '[object Date]'    : 'date',
    '[object Error]'   : 'error'
},
TOSTRING = Object.prototype.toString;
function type(o) {
    return TYPES[typeof o] || TYPES[TOSTRING.call(o)] || (o ? 'object' : 'null');
};
function printObject(o) {
if (debug) alert("printObject");
  var out = '';
 // var i =0;
  for (var p in o) {
   // if (i > 80) {
		out += p + ': ' + o[p] + '\n';
	//}
	//i++;
  }
  console.log(out);
};
function setRelation(el,ela) {

if (debug) alert("setRelation");
// setRelation(this,'div_tags')
// Change event fired on SimpleTreeView.php's(Helper) dynamic HTML input element.
	if (typeof el === "string") {
		el = $("#" + el);
	};
	if (typeof ela === "string") {
		ela = $("#" + ela);
	};
	p = $(el).parent("label").parent("div").children("input[group='selectall']");
	f = $(ela).children("input");
	if ( p !== 'undefined') { //Leaf node
		s = el.id.split('_'); // checkbox_18_S002
	}
	s[0] = $('#'+f[0].id).val(); // such as exam_id'value
	for (var i in s) {
		s[i] = "'" + s[i].toString() + "'";
	}
	// ela is dv_tags grouping all of inputs in treeview structure
	//選取值目前的陣列結構 s[0]是主表pk, s[1]是treeview's last branch, s[2]是treeview's leaf
	//選取值的索引 '2,1,0,1,2' 切成陣列
	var p = $(ela).attr('padding').split(',');
	//template像是concat(concat(name,?),?),?,?,?,limittime,limittime
	//將?的位置填完選取值的索引所表示的值後，將結果設定回value屬性
	if ($("#"+el.id).prop('checked')) {
		var template = $(ela).attr('template');
		if (template.indexOf('?') > 0) {
			$(ela).attr('value',asignValue(template,p,s));
			$(ela).attr('pk',s[0]);
			$(ela).attr('sql','insert');
		}
	} else {
		$(ela).attr('sql','delete');
		$(ela).attr('pk',s.join(','));
	}
	//alert("new value="+$(ela).attr('value'));
	//alert("new pk="+$(ela).attr('pk'));
}

function asignValue(template,p,s) {
if (debug) alert("asignValue");

//name,exam_id,department_id,user_id,remainder,limittime
	var v = template.split('?'); 
	if (v.length-1 != p.length) {
		alert('treeview.js:template=指定模板的?參數數目與pk=選取值數目不符!');
		return;
	} else {
		template = v[0];
		for (var i=0; i< p.length;i++) {
			v[i] += s[p[i]];
		}
		return v.join('');
	}
}

function setFormula(el,formula) {
if (debug) alert("setFormula");

//var formula = '*60';
	if (typeof el === "string") {
		el = $("#" + el);
	};
	$(el).val(eval($(el).val() + formula));
}
function setSelectall(el) {
if (debug) alert("setSelectall");
//setTreeview('div_tags','progress'); //define the progress's css in site.css
	if (typeof el === "string") {
		el = $("#" + el);
	};
	g = $(el).parent("div").children("input");
	c = $(el).parent("div").children("label").children("input");
	cnt = 0;
	for (var i=0;i<c.length;i++) {
		$("#"+c[i].id).draggable();
		if ($("#"+g[0].id).prop('checked')) {
			if (!$("#"+c[i].id).prop('checked')) {
				$("#"+c[i].id).prop('checked', true).trigger("change");
				cnt++
			}
		} else {
			if ($("#"+c[i].id).prop('checked')) {
				$("#"+c[i].id).prop('checked', false).trigger("change");
				cnt++
			}	
		}
	};
	myalert('總共變更' + cnt + '筆設定!');
}

function setPdf(el,category) {
if (debug) alert("setPdf");
//setTreeview('div_tags','progress'); //define the progress's css in site.css
	if (typeof el === "string") {
		el = $("#" + el);
	};
	var container = 
		'<object id="pdfView" name="pdfPlayer" ' +
		'width="800px" height="300px" type="application/pdf" data="'+
		baseURL + '/index/sql?'+
		'_event=print'+
		'&_sql='+ 'print'+
		'&_db='+ $(el).attr('db')+
		'&_table='+ $(el).attr('table') +
		'&_field='+ $(el).attr('field') +
		'&_title='+ $(el).attr('title') +
		'&_key='+ $(el).attr('key') +
		'&_pk='+ category +
		'&_where='+ $(el).attr('where') +
		'">'+'</object></div>';
	$(el).append($(container));
	/*
	$('#pdfView').click(function () {
		$(this).fadeOut();
	});
	*/
}

function setTreeview(el,id,title,options) {
if (debug) alert("setTreeview");

//setTreeview('div_tags','progress'); //define the progress's css in site.css
	if (typeof el === "string") {
		el = $("#" + el);
	};
	id="JQTreeview";
	//var default = {width:"200px",height:"200px"}
	//such as options's input: {height:"250px"}
	//var options = $.extend(defaults, options); 
	//var filter = "user.user_id=" + "";
	options.db = '';
	//此處應指定setsjqt專用Ajax，不可再用class='database',整個treeview會trigger通用myAjax
	//treeview內個別元素應該要針對個別元素使用class='database'
	var container = '<div id="'+id+'" style="overflow-y: auto;overflow-x: hidden;height:200px;width:100%" type="checkbox" sql="select" db="toyota" table="department,user" field="name,addexampaper,name,addexampaper" key="department_id" '+
					'onclick="setsjqt(\'' + options.db +'\');">'+title+
					'</div>';
	$(el).append($(container));
	$('#'+id).click(function () {
		document.getElementById(id).onclick = null;
		$("#"+id).unbind('click');
	});
	//$("#"+id).hide();
	
}

function setDatetimePicker (el,myValue) {
if (debug) alert("setDatetimePicker");

	if (type(el) === "string") {
		el = $("#" + el);
	};
	$(el).datetimepicker({ changeMonth: true, 
		changeYear: true, showSecond:true, 
		dateFormat:'yy-mm-dd', timeFormat:'HH:mm:ss', 
		stepHour: 1, stepMinute: 10, stepSecond: 10,
		defaultValue:myValue});		
};

function setDialog (el, value) {
if (debug) alert("setDialog");

	if (type(el) === "string") {
		el = $("#" + el);
	};
    $(el).dialog({
      modal: true,
	  title: $(el).attr("title"),
	  width:'auto',
	  /*
		beforeShowForm: function(form){
			// generate some html mapping the input element names to colModel names
			var html = '<div id="custom_form_content"><input type="radio">a custom form layout</input><input id="radio">a custom form layout</input></div>';
			
			// use jQuery replaceWith to remove existing form and add custom form
			form.replaceWith(html);
		},
	*/		
      buttons: {	  
		'確定': function(){
		  $.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			data: 
			$(this).find('form').serialize(),
			beforeSend:function(xhr, s) {
			  //alert(s.data);
			},
		error: 	function(jqXHR, exception) {
            if (jqXHR.status === 0) {
                alert('Script.js:Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Script.js:Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                alert('Script.js:Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                alert('Script.js:Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Script.js:Time out error.');
            } else if (exception === 'abort') {
                alert('Script.js:Ajax request aborted.');
            } else {
                alert(jqXHR.status +'Script.js:Uncaught Error.\n' + jqXHR.responseText);
            }
        },
		success: function(msg){
			try {
				var data = JSON.parse(msg);
			} catch (e) {
				alert(msg);
			}
			if (data.code != "1") {
			  } else {
				if ($('#popup').attr('goto')!== undefined) {
				 window.location = baseURL + "/" + $('#popup').attr('goto');
				} else {
				 alert("script.js內，回目標網頁找不到，請於div id=popup中指定goto='目標網頁'");
				 window.location = baseURL;
				}
			  }
			  $(this).dialog('close');
			}
		  });
		},
        '取消': function() {
          $( this ).dialog( "close" );
        }
      }
    });
	myinput = $(el).children('input'); 
	$("#"+myinput[0].id).val(value);
};

function loadItems(el,myValue){
if (debug) alert("loadItems");

	if (type(el) === "string") {
		el = $("#" + el);
	};
     var itemSelected= $(el).val();
     var keyValueList = [];
	 var dataSource = (type(myValue) === "undefined")?{ 			
			_event:"autocomplete:loadItems(1)", //單一參數，使用View送來的參數當ajax參數
			_type:$(el).attr("type"),
			_sql:$(el).attr("sql"),
			_db:$(el).attr("db"),
			_table:$(el).attr("table"),
			_name:$(el).attr("name"),		
			_field:$(el).attr("field"),
			_value:$(el).val(),
			_id:$(el).attr("id"),
			_key:$(el).attr("key"),
			_pk:itemSelected
			}:{	//兩個參數，使用第二個參數當ajax參數此處尚未完成，
			//因jqGrid的單筆FORM表單，無法使用autocomplete
			_event:"autocomplete:loadItems(2)",
			_type:"autocomplete",
			_sql:"select",
			_db:"toyota",
			_table:"exam",
			_name:"name",		
			_field:"name,exam_id",
			_value:"",
			_id:"exam_id",
			_key:"name",
			_pk:itemSelected
			}; 
     $.ajax({
		url: baseURL + "/index/sql", 		
//		url: "http://www.localhost.com/cc/test.php", 
		beforeSend:function(xhr, s) {
		//alert('Treeview.js(loadItems):'+s.data);
		},	   		
		type: "POST",
		async: false,
		error: 	function(jqXHR, exception) {
			if (jqXHR.status === 0) {
				alert('Treeview.js(loadItems):Not connect.\n Verify Network.');
			} else if (jqXHR.status == 404) {
				alert('Treeview.js(loadItems):Requested page not found. [404]');
			} else if (jqXHR.status == 500) {
				alert('Treeview.js(loadItems):/index/simpletreeview Internal Server Error [500].(The SQL may be error!) The baseURL=' + baseURL);
			} else if (exception === 'parsererror') {
				alert('Treeview.js(loadItems):Requested JSON parse failed.');
			} else if (exception === 'timeout') {
				alert('Treeview.js(loadItems):Time out error.');
			} else if (exception === 'abort') {
				alert('Treeview.js(loadItems):Ajax request aborted.');
			} else {
				alert(jqXHR.status +'Treeview(loadItems).js:Uncaught Error.\n' + jqXHR.responseText);
			}
		},		
		data: dataSource
      }).done(function(msg){
	  	try {
		   data = JSON.parse(msg);
		} catch(e) {
			alert(msg);
		}
		if (data.code == "5") {
			for(var i in data.text) {
				keyValueList.push(data.text[i]+ " " + i);
			}	
		}
      });
	 //alert(keyValueList);  //alert會影響Autocomplete的顯示。
     return keyValueList;  //不可在事件函數中使用return，使得函數註冊不完整，所以return要拿到外面
}

function setAutocomplete(el,myValue){
if (debug) alert("setAutocomplete");

if (type(el) === "string") {
	el = $("#" + el);
};
var limitedPattern = ""; // "^" must be a leading pattern
$(el).autocomplete({
	source: function( request, response ) {
        var matcher = new RegExp( limitedPattern + $.ui.autocomplete.escapeRegex( request.term ), "i" );
        response( $.grep( loadItems(el,myValue), function( item ){
            return matcher.test( item );
        }) );
      }
	},{ 
      change: function(event, ui) {
		myalert('選單下載中，請稍後!');
      },
		delay:  400,
		multiple: true,
		select: function(event, ui) {
			var slectedItem = ui.item.value.split(' ');
			ui.item.label = slectedItem[0];
			ui.item.value = slectedItem[1];
			//printObject(ui.item);
		}
   });
};
 
function setjqt(filter) {
if (debug) alert("setjqt");

/*
if ( exampaperid == 1) {
	return;
}
*/
//if ($('#exampaper_id').val().length > 0) {
		//var filter = "questions.exampaper_id=" + exampaperid;
		if($('#JQTreeview').length > 0 ){
		$.ajax({
		  //一定要在PHP宣告且指定正確的baseURL		
		  url: baseURL + "/index/treeview", 
		  cache: false,         
		  dataType: 'text', // '原來為json->改成html,由本函數success:自行檢查'            
		  type:'POST',
		  data: {
			_event:"document:ready",		
			_type:$('#JQTreeview').attr("type"),
			_sql:$('#JQTreeview').attr("sql"),
			_db:$('#JQTreeview').attr("db"),
			_table:$('#JQTreeview').attr("table"),
			_name:$('#JQTreeview').attr("name"),		
			_field:$('#JQTreeview').attr("field"),
			_key:$('#JQTreeview').attr("key"),
			_value:$('#JQTreeview').val(),
			_id:$('#JQTreeview').attr("id"),
			_where:filter
			},
		  error: 	function(jqXHR, exception) {
				if (jqXHR.status === 0) {
					alert('Treeview.js:Not connect.\n Verify Network.');
				} else if (jqXHR.status == 404) {
					alert('Treeview.js:Requested page not found. [404]');
				} else if (jqXHR.status == 500) {
					alert('Treeview.js:/index/treeview Internal Server Error [500].(The SQL may be error!) The baseURL=' + baseURL);
				} else if (exception === 'parsererror') {
					alert('Treeview.js:Requested JSON parse failed.');
				} else if (exception === 'timeout') {
					alert('Treeview.js:Time out error.');
				} else if (exception === 'abort') {
					alert('Treeview.js:Ajax request aborted.');
				} else {
					alert(jqXHR.status +'Treeview.js:Uncaught Error.\n' + jqXHR.responseText);
				}
			},
			beforeSend:function(xhr, s) {
			//alert('Treeview.js:'+s.data);
			},	   
		  success: 
			function(data) {
				try {
					var data = JSON.parse(data);
				} catch(e) {
					alert("Data:"+e+data);
				}
				tView = effect(new treeview(data, $('#JQTreeview')));
			}
			
		  });
		  
		$('#JQTreeview').hide();
		};
	//};
}

function setsjqt(filter) {
if (debug) alert("setsjqt");

/*
if ( exampaperid == 1) {
	return;
}
*/
//if ($('#exampaper_id').val().length > 0) {
		//var filter = "questions.exampaper_id=" + exampaperid;
		if($('#JQTreeview').length > 0 ){
		$.ajax({
		  //一定要在PHP宣告且指定正確的baseURL		
		  url: baseURL + "/index/simpletreeview", 
		  cache: false,         
		  dataType: 'text', // '原來為json->改成html,由本函數success:自行檢查'            
		  type:'POST',
		  data: {
			_event:"document:ready",		
			_type:$('#JQTreeview').attr("type"),
			_sql:$('#JQTreeview').attr("sql"),
			_db:$('#JQTreeview').attr("db"),
			_table:$('#JQTreeview').attr("table"),
			_name:$('#JQTreeview').attr("name"),		
			_field:$('#JQTreeview').attr("field"),
			_key:$('#JQTreeview').attr("key"),
			_value:$('#JQTreeview').val(),
			_id:$('#JQTreeview').attr("id"),
			_where:filter
			},
		  error: 	function(jqXHR, exception) {
				if (jqXHR.status === 0) {
					alert('SimpleTreeview.js:Not connect.\n Verify Network.');
				} else if (jqXHR.status == 404) {
					alert('SimpleTreeview.js:Requested page not found. [404]');
				} else if (jqXHR.status == 500) {
					alert('SimpleTreeview.js:/index/simpletreeview Internal Server Error [500].(The SQL may be error!) The baseURL=' + baseURL);
				} else if (exception === 'parsererror') {
					alert('SimpleTreeview.js:Requested JSON parse failed.');
				} else if (exception === 'timeout') {
					alert('SimpleTreeview.js:Time out error.');
				} else if (exception === 'abort') {
					alert('SimpleTreeview.js:Ajax request aborted.');
				} else {
					alert(jqXHR.status +'Treeview.js:Uncaught Error.\n' + jqXHR.responseText);
				}
			},
			beforeSend:function(xhr, s) {
			//alert('Treeview.js:'+s.data);
			},	   
		  success: 
			function(data) {
				try {
				   var data = JSON.parse(data);
				} catch(e) {
					alert("Data:"+e+data);
				}
				tView = effect(new treeview(data, $('#JQTreeview')));
				//id='selectall的checkbox會抓下面同一個<div>內的所有checkbox來進行同步變更	
				//$("input[group='selectall']").click(function (e) {
				
			}
			
		  });
		  
		//$('#JQTreeview').hide();
		};
	//};
}

treeview = function(tData, container) {
  this.build = function(nodeInfo) {
    var nodeID = nodeInfo['title'].replace(/\s/g, "_");
    var node = $('<div id="'+nodeID+'-Node">'+nodeInfo['title']+'</div>')
      .css({'margin-top': 5});
    
    $('<div class="expandNode expand"></div>')
      .prependTo(node);
        
    var contents = $('<div class="NodeContents"></div>');
    
    for(var item in nodeInfo['items'])
    {
      if(typeof nodeInfo['items'][item] == 'string' ||
         typeof nodeInfo['items'][item] == 'number')
      {
        $('<div class="NodeItem"></div>')
          .html('<span class="ItemTitle">'+item+'</span><div class="ItemTxt">'+nodeInfo['items'][item]+'</div>')
          .appendTo(contents);
      }
      if(typeof nodeInfo['items'][item] == 'object')
      {
        sNode = this.build(nodeInfo['items'][item]);
        contents.append(sNode);
      }
    }
    
    node.append(contents);
    
    node.children('.expandNode').click(function() {
      var contents = $(this).parent().children(".NodeContents");
      contents.toggle();
      if(contents.css('display') != "none")
      {
        $(this).attr("class", "expandNode collapse");
      }
      else
      {
        $(this).attr("class", "expandNode expand");
      }
      
    });
    
    return node;
  }
  
  this.tree = this.build(tData);
  var treeCon = container;
  
  treeCon.append(this.tree);
}

var myAjax = function(event) {
if (debug) alert("myAjax");
event.isPropagationStopped();
  $.ajax({
	type: "POST",
	//一定要在PHP宣告且指定正確的baseURL		
	url: baseURL + "/index/sql", 		
	data: {
		_event:'datbase:change',
		_type:$(this).attr("type"),
		_sql:$(this).attr("sql"),
		_db:$(this).attr("db"),
		_table:$(this).attr("table"),
		_name:$(this).attr("name"),
		_field:$(this).attr("field"),
		_key:$(this).attr("key"),
		_value:$(this).val(),
		_myvalue:$(this).attr("value"),
		_pk:$(this).attr("pk"),
		_id:$(this).attr("id"),
		_where:$(this).attr("where"),
		_modifier:$(this).attr("modifier")
	},
	beforeSend:function(xhr, s) {
	//alert("treeview.js database changed"+s.data);
	  var id = "#"+s.data.replace(/.*\&_id=(\w)\&{0,1}/,"$1");
//	  alert(s.data);
//	  alert("id:"+id); //存取無效的問題幾乎都是此處未抓到正確id
	  if (s.data.match(/\&_type=checkbox/)!==null) {
		  if ($(id).attr('checked') == 'checked') {
			s.data = s.data.replace(/\&_value=1/,"&_value=0");
		  } else {
			s.data = s.data.replace(/\&_value=0/,"&_value=1");
		  }
	  };
//	  alert(s.data);
	},	   	
   complete: function(){
	//alert("after");
   },
	error: 	function(jqXHR, exception) {
		if (jqXHR.status === 0) {
			alert('SimpleTreeview.js:Not connect.\n Verify Network.');
		} else if (jqXHR.status == 404) {
			alert('SimpleTreeview.js:Requested page not found. [404]');
		} else if (jqXHR.status == 500) {
			alert('SimpleTreeview.js:/index/simpletreeview Internal Server Error [500].(The SQL may be error!) The baseURL=' + baseURL);
		} else if (exception === 'parsererror') {
			alert('SimpleTreeview.js:Requested JSON parse failed.');
		} else if (exception === 'timeout') {
			alert('SimpleTreeview.js:Time out error.');
		} else if (exception === 'abort') {
			alert('SimpleTreeview.js:Ajax request aborted.');
		} else {
			alert(jqXHR.status +'Treeview.js:Uncaught Error.\n' + jqXHR.responseText);
		}
	},
	success: function(msg){
		try {
			var data = JSON.parse(msg);
		} catch(e) {
			alert(msg);
		}
		//alert(data.text);
		if (data.code !="1") {
			if (data.code =="2") {
				var div_id = $('#'+data.id).closest("div").attr("id");
				$('#'+div_id).html(data.text); //要從上一層的DIV取得ID，去取代HTML碼
			} 
		} // if 1		
	} // success
	});	//ajax
}


function enableDatabase() {
if (debug) alert("enableDatabase");

	$(".idatabase").focus(myAjax);
	if($(this).attr("id") !== 'JQTreeview'){
		$(".database").change(function (event ) {
		//myAjax();
		if (debug) alert("myAjax");
		//insert與delete被規劃放在DIV標籤最外層，
		//被規劃放在DIV標籤內層，因此當內部checkbox的
		//onclick事件觸發setRelation執行相同資料，外層會有
		//event bubling 重複觸發問題，故令其中止傳播相同事件
		//而內層不可被中止傳播，以免無法執行外層事件
		if ($(this).attr('sql') == 'insert' | 
			$(this).attr('sql') == 'delete') {
			event.stopImmediatePropagation();
		}		
		$.ajax({
			type: "POST",
			//一定要在PHP宣告且指定正確的baseURL		
			url: baseURL + "/index/sql", 		
			data: {
				_event:'datbase:change',
				_type:$(this).attr("type"),
				_sql:$(this).attr("sql"),
				_db:$(this).attr("db"),
				_table:$(this).attr("table"),
				_name:$(this).attr("name"),
				_field:$(this).attr("field"),
				_key:$(this).attr("key"),
				_value:$(this).val(),
				_myvalue:$(this).attr("value"),
				_pk:$(this).attr("pk"),
				_id:$(this).attr("id"),
				_where:$(this).attr("where"),
				_modifier:$(this).attr("modifier")
			},
			beforeSend:function(xhr, s) {
			//alert("treeview.js database changed"+s.data);
			  var id = "#"+s.data.replace(/.*\&_id=(\w)\&{0,1}/,"$1");
		//	  alert(s.data);
		//	  alert("id:"+id); //存取無效的問題幾乎都是此處未抓到正確id
			  if (s.data.match(/\&_type=checkbox/)!==null) {
				  if ($(id).attr('checked') == 'checked') {
					s.data = s.data.replace(/\&_value=1/,"&_value=0");
				  } else {
					s.data = s.data.replace(/\&_value=0/,"&_value=1");
				  }
			  };
		//	  alert(s.data);
			},	   	
		   complete: function(){
			//alert("after");
		   },
			error: 	function(jqXHR, exception) {
				if (jqXHR.status === 0) {
					alert('SimpleTreeview.js:Not connect.\n Verify Network.');
				} else if (jqXHR.status == 404) {
					alert('SimpleTreeview.js:Requested page not found. [404]');
				} else if (jqXHR.status == 500) {
					alert('SimpleTreeview.js:/index/simpletreeview Internal Server Error [500].(The SQL may be error!) The baseURL=' + baseURL);
				} else if (exception === 'parsererror') {
					alert('SimpleTreeview.js:Requested JSON parse failed.');
				} else if (exception === 'timeout') {
					alert('SimpleTreeview.js:Time out error.');
				} else if (exception === 'abort') {
					alert('SimpleTreeview.js:Ajax request aborted.');
				} else {
					alert(jqXHR.status +'Treeview.js:Uncaught Error.\n' + jqXHR.responseText);
				}
			},
			success: function(msg){
				try {
					var data = JSON.parse(msg);
				} catch(e) {
					alert(msg);
				}
				//alert(data.text);
				if (data.code !="1") {
					if (data.code =="2") {
						var div_id = $('#'+data.id).closest("div").attr("id");
						$('#'+div_id).html(data.text); //要從上一層的DIV取得ID，去取代HTML碼
					} 
				} // if 1		
			} // success
			});	//ajax
		
		
		});
	};
}


function update(mydb,mytable,myfield,myvalue,mykey,mypk){
if (debug) alert("update");

//update('toyota','exampaper','mark','1','exampaper_id','2');
	  $.ajax({
		type: "POST",
		//一定要在PHP宣告且指定正確的baseURL		
		url: baseURL + "/index/sql", 		
		data: {
			_event:'function:update',
			_sql:'update',
			_db:mydb,
			_table:mytable,
			_field:myfield,
			_key:mykey,
			_value:myvalue,
			_pk:mypk
		},
        beforeSend:function(xhr, s) {
		//alert("treeview.js database changed"+s.data);
        },	   
	   complete: function(){
		//alert("after");
	   },
		success: function(msg){
			try {
				var data = JSON.parse(msg);
			} catch(e) {
				alert(msg);
			}
			//alert(data.text);
			if (data.code !="1") {
				if (data.code =="2") {
					var div_id = $('#'+data.id).closest("div").attr("id");
					$('#'+div_id).html(data.text); //要從上一層的DIV取得ID，去取代HTML碼
				} 
			} // if 1		
		} // success
		});	//ajax
}
function effect(container) {
if (debug) alert("effect");
enableDatabase();
//1.節點格式
//"節點A": {'title': "節點標題",'items': {"節點說明": "節點內容"}}
//2. 同層節點插在同層'items': {之後,下層節點插在下層'items': {之後,
//3. 記得需要時要在子節點A前加逗號!
//同層第一個節點不要加逗點
/*
		$data = '
		{"title" : "Fruit","items" : {
			"Apple節點":{"title" : "Apple","items" : {
				"Red Apple節點":{"title" : "Red Apple","items" : {
				"Red Apple說明":"Red Apple內容"}}
				}},
			"Banana節點":{"title" : "Banana","items" : {
				"Long Banan節點":{"title" : "Long Banan","items" : {
				"Long Banan說明":"Long Banan內容"}}
				}}
		}}'
		;

*/
/*
		  var data = {
		  "title": "<input type='text' value='根節點標題'>",
		  "items": {
			
			"無內容之節點": {
			  "title": "子節點A",
			  "items": {
						"子節點B": {
						  "title": "子節點B標題",
						  "items": {
							"子節點B說明": "子節點內容"
							}
						}				
				}
			},
			
			"兄弟節點a加於同層後(記得需要時要在子節點A前加逗號)": {
			  "title": "兄弟節點a標題",
			  "items": {
				"兄弟節點說明": "兄弟節點內容,可再包子節點"
			  }
			},
			
			"兄弟節點b加於同層後(記得需要時要在子節點b前加逗號)": {
			  "title": "兄弟節點b標題",
			  "items": {
				"兄弟節點b說明": "兄弟節點內容,可再包子節點"
			  }
			}
		
		  }
		  };
		*/

		//alert(JSON.stringify(data));
/*
	$("#fruitVariety").bind("ajaxSend", function(){
	  $(this).show();
	}).bind("ajaxComplete", function(){
	  $(this).hide();
	});		

$(".limit").attr({ 
  db: "toyota",
  table: "exam",
  field: "title",
  pk: 1
});
*/

/*
	$('#zend_add').live('click',function (event) {
	  $.ajax({
		type: "POST",
		//一定要在PHP宣告且指定正確的baseURL		
		url: baseURL + "/index/zend", 
		data: {
			event:'zend_add:click',
			type:$(this).attr("type"),
			sql:$(this).attr("sql"),
			db:$(this).attr("db"),
			table:$(this).attr("table"),
			name:$(this).attr("name"),
			field:$(this).attr("field"),
			key:$(this).attr("key"),
			value:$(this).val(),
			pk:$(this).attr("pk"),
			id:$(this).attr("id")
		},
        beforeSend:function(xhr, s) {
		  var id = "#"+s.data.replace(/.*\&_id=(\w)\&{0,1}/,"$1");
		  if (s.data.match(/\&_type=checkbox/)!=null) {
			  if ($(id).attr('checked') == 'checked') {
				s.data = s.data.replace(/\&_value=0/,"&_value=1");
			  } else {
				s.data = s.data.replace(/\&_value=1/,"&_value=0");
			  }
		  };
	    },	   
	   complete: function(){
		//alert("after");
	   },
		success: function(msg){
		alert(msg);
		var data = JSON.parse(msg);
		//alert(data.text);
		  if (data.code !="1") {
			if (data.code =="2") {
				var div_id = $('#'+data.id).closest("div").attr("id");
				$('#'+div_id).html(data.text); //要從上一層的DIV取得ID，去取代HTML碼
			} else { 
				alert( "Data saved error: " + data.text );
			}
		  }
		}
		});	
	});
*/	
	
	$('div#title_1').load(function () {
		$.ajax({
		  type: "POST",
		  //一定要在PHP宣告且指定正確的baseURL		
		  url: baseURL + "/index/sql", 
		  dataType: "html",
		  data:
			{
			_event:'div#title_1:load',
			_type:$(this).attr("type"),
			_sql:$(this).attr("sql"),
			_db:$(this).attr("db"),
		    _table:$(this).attr("table"),
			_name:$(this).attr("name"),			
			_field:$(this).attr("field"),
			_key:$(this).attr("key"),
			_value:$(this).val(),
			_pk:$(this).attr("pk"),
			_id:$(this).attr("id")
			},
		  error: function(msg){
			alert("An error occurs during data reading: " + msg);
		  },
		  success: function(data){
			alert(data);
			$("div#title_1").fadeOut();
			$("div#title_1").html(data); //Only once
			$("div#title_1").fadeIn(100);
		  }
		});	
	});

	
	
	/*
	$('.select_item').mouseout(function () {
		$(this).css("background-color","red");
	});
	*/		
	
}


function myalert(msg) {
if (debug) alert("myalert");
	$("#spaMsg").text(msg);
}

function disable_resize() {
if (debug) alert("disable_resize");	
	document.onmousewheel = function(){ stopWheel(); } /* IE7, IE8 */
	if(document.addEventListener){ /* Chrome, Safari, Firefox */
		document.addEventListener('DOMMouseScroll', stopWheel, false);
	}
	 
	function stopWheel(e){
		if(!e){ e = window.event; } /* IE7, IE8, Chrome, Safari */
		if(e.preventDefault) { e.preventDefault(); } /* Chrome, Safari, Firefox */
		e.returnValue = false; /* IE7, IE8 */
	}
}

function enable_resize() {
if (debug) alert("enable_resize");
	document.onmousewheel = null;  /* IE7, IE8 */
	if(document.addEventListener){ /* Chrome, Safari, Firefox */
		document.removeEventListener('DOMMouseScroll', stopWheel, false);
	}
}

function openwin() { 
if (debug) alert("openwin");
　　window.open ("", "_self", "height='480px', width='860px',toolbar=no,menubar=no, scrollbars=no, resizable=no, location=no, status=no");
} 

$(document).ready(function() {
if (debug) alert("ready");
	//一定要在放在此位置，才能抓到database動態變更後的屬性
	//$(".database").live('change',function (event) {
	//$(".database").unbind('change');
	//$("#begindate").datepicker({dateFormat:"yyyy-mm-dd"}).click();
	$("#div_tags").hide();
  	var options = {"db":"toyota","table":"user"};
	setTreeview('div_tags','progress','按我展開組織圖',options);

	$( document ).ajaxStart(function() {
	  myalert('正在存取資料庫...');
	});

	$( document ).ajaxStop(function() {
	  myalert('存取成功!');
	});

//	$(window).click(function () {$('#progress').show();}); //$('#div_tags').show();
	
	$('#password').change(function () {
		$('#password').val($.sha1($(this).val()));

	});
	$('#new_password').change(function () {
		$('#new_password').val($.sha1($(this).val()));
	});
	
	enableDatabase();
	//$('#qrCode').gchart($.gchart.qrCode( 
		//'http://www.localhost.com/toyota/public/exam/score/radarchart', 'ISO-8859-1', 'high', 2));
	//$(document).bind("contextmenu",function(e){
	//	  return false;
	//});
	var ctrlDown = false;
	var ctrlKey = 17, vKey = 86, cKey = 67, aKey = 65;

	$(document).keydown(function(e) {
		if (e.keyCode == ctrlKey) ctrlDown = true;
	}).keyup(function(e) {
		if (e.keyCode == ctrlKey) ctrlDown = false;
	});

    $('.no-copy-paste').bind('mousewheel', function(e){
		if (ctrlDown) {
			if(e.originalEvent.wheelDelta /120 > 0) {
				disable_resize();
				myalert('禁止放大!',1);
			}
			else{
				disable_resize();
				myalert('禁止縮小!',1);
			}
		}
    });

	$(".no-copy-paste").keydown(function(e) {
		if (ctrlDown && (e.keyCode == vKey 
						|| e.keyCode == cKey 
						|| e.keyCode == aKey)) {
			alert('不可拷貝喲~');
			ctrlDown = false;
			return false;
		};
	});

	$('#step').mousedown(function (e){
		$('#step').css("z-index",99999);
		$('#step').css("position","absolute");
		$('#step').css("left",Math.floor((Math.random()*300)+1)+"px");
		$('#step').css("top",Math.floor((Math.random()*300)+1)+"px");
		//alert($('#step').css("left"));
	});
	$('#movable_footer').draggable();
	$('#movable_footer').dblclick(function(){
		$('#movable_footer').fadeOut(1000);
	});
if (debug) alert("ready OK");
	
});