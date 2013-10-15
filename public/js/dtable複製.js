$(document).ready(function() {
	var listTable_id = "#listTable";
	var categoriesStr = ":全部;助理教授:助理教授;室長:室長";
	
	//myTypes
	var myTypeArray = $(listTable_id).attr("type").split(",");
	var myTypes = ["view","edit","add","del","search","refresh","copy","compare"];
	for (i in myTypes) {
		eval("var " + myTypes[i]+ " = false;");
		for (j in  myTypeArray) {
			if ( myTypeArray[j] == myTypes[i] ) {
				eval("var " + myTypeArray[j]+ " = true;");
			};
		}
	}
	//mycolNames
	var myName = $(listTable_id).attr("name").split(",");
	mycolName = [];
	for (i in myName) {
		mycolName[i] = "'" + myName[i] + "'";
	}
	mycolNames = eval("[" + mycolName.join(",") + "]");
	//mycolModels 
	var myField = $(listTable_id).attr("field").split(",");
	mycolModel = [];
	for (i in myField) {
		var editable = myField[i].match(/^[A-Z]/)?"false":"true";
		mycolModel[i] = "{name:'" + myField[i] + 
		"',index:'" + myField[i] + "',sortable: true," +
		"editable:"+ editable + 
		",width: 120" + ",align:'left'" +"}";
	} 
	mycolModels = eval("[" + mycolModel.join(",") + "]");

	$(listTable_id).jqGrid({	 
		url: baseURL + 	"/index/listsql" + "?" +
			+ "_event='listTable:jqGrid'"             + "&" + 
			"_type="  + $(listTable_id).attr("type")  + "&" +
			"_sql="   + $(listTable_id).attr("sql")   + "&" +	
			"_db="    + $(listTable_id).attr("db")    + "&" +
			"_table=" + $(listTable_id).attr("table") + "&" +
			"_name="  + $(listTable_id).attr("name")  + "&" +			
			"_field=" + $(listTable_id).attr("field") + "&" +
			"_key="   + $(listTable_id).attr("key")   + "&" +
			"_value=" + $(listTable_id).attr("value") + "&" +
			"_pk="    + $(listTable_id).attr("pk")    + "&" +
			"_where=" + $(listTable_id).attr("where") + "&" +
			"_id="    + $(listTable_id).attr("id")
			,
		editurl: baseURL + 	"/index/sql" + "?" +
			+ "_event='listTable:jqGrid_edit"        + "'&" + 
			"_type="  + $(listTable_id).attr("type")  + "&" +
			"_sql="   + $(listTable_id).attr("sql")   + "&" +	
			"_db="    + $(listTable_id).attr("db")    + "&" +
			"_table=" + $(listTable_id).attr("table") + "&" +
			"_name="  + $(listTable_id).attr("name")  + "&" +			
			"_field=" + $(listTable_id).attr("field") + "&" +
			"_key="   + $(listTable_id).attr("key")   + "&" +
			"_value=" + $(listTable_id).attr("value") + "&" +
			"_where=" + $(listTable_id).attr("where") + "&" +
			"_pk="    + $(listTable_id).attr("pk")   + "&" +
			"_id="    + $(listTable_id).attr("id") 
		,
		loadBeforeSend: function(jqXHR) {
			//alert(jqXHR.responseText);
		},	
		
		/*
		loadComplete: function (ids) {
			if ($("#listTable").jqGrid('getGridParam', 'records') > 10 ) {
				$("#add_listTable").addClass('ui-state-disabled');
			} else {
				$("#add_listTable").removeClass('ui-state-disabled');
			}
		},
		*/
		datatype: 'json', 
		mtype: 'GET', 
		colNames: mycolNames, 
		colModel :mycolModels,
		cmTemplate: {//formatter:'select', 
					//stype: 'select', 
					//searchoptions:{ sopt:['eq'], 
					//	value: categoriesStr 
				//formatter:'select',
                //edittype:'select',
				//editoptions:{value:'FE:FedEx;TN:TNT;IN:Intim',
//defaultValue:'Intime'},
                stype:'select', 
				searchoptions:{value:':全部;助理教授:助理教授;室長:室長'}
		},
		pager: '#pager', 
		rowNum: 5,  
		rowList:[5,10,20], // 每頁顯示筆數
		sortname: $(listTable_id).attr("key"), 
		sortorder: 'asc', 
		caption: $(listTable_id).attr("value"), 
		height: 'auto',  // Grid高度

		autowidth: true, // 自動欄寬
		viewrecords: true,
		altRows: true,
		//footerrow: true,
		gridview: true,  // 設定成true以快速大量資料集之載入
		//loadonce: true,  // 只由Server讀一次資料
		rownumbers: true,
		multiselect: true,  // 顯示勾選框
		loadComplete: function(data) {
		//alert(JSON.stringify(data), null, 4);
        //setSearchSelect($(this), 'name', data, 0);
		},
		onSelectRow: function(id){ 
		/*
		   if(id && id!==lastsel){ 
				jQuery('#list').jqGrid('restoreRow',lastsel);
				jQuery('#list').jqGrid('saveRow',id);
				jQuery('#list').jqGrid('editRow',id,true); 
				lastsel=id; 
			} 
		*/
		},	
		jsonReader : { 
						root: "rows", 
						page: "page", 
						total: "total", 
						cell: "cell", 
					}
	}).navGrid('#pager',{
	
		cloneToTop: true, edit:edit, add:add, del:false, refresh:refresh, view:view, search: search,
			edittext: "修改", edittitle: "修改",
			addtext: "新增", addtitle: "新增",
			deltext: "刪除", deltitle: "刪除",
			searchtext: "搜尋", searchtitle: "搜尋", 
			refreshtext: "刷新", refreshtitle: "更新",
			alertcap: "警示", alerttext: "請先選取一列資料列",
			viewtext: "檢視", viewtitle: "檢視"	},

	{
	}, // edit options
	{
	}, // add options
	{
	}, // del options
	{
		multipleSearch:true,
		showQuery:true,
		searchOperators : true,
		searchOnEnter: true
	}, // search options,
	{
	overlay:false,
	closeOnEscape:true
	}, // view options,
	{
	} // refresh options	
	);
		
	$(listTable_id).jqGrid('filterToolbar', 
			{autosearch: true, 
			searchOnEnter: false, 
			enableClear: true,
			defaultSearch : "cn",
			stringResult: true }
			);
	$(listTable_id).setGridParam({datatype: 'json', 
				url: baseURL+'/index/sql',
				 search:true
			});
			
	$(listTable_id)[0].triggerToolbar();
	
	!compare?'':$(listTable_id).jqGrid('navButtonAdd','#pager',{
		caption:"比較", 
		buttonicon:"ui-icon-gear", 
		onClickButton: function(){ 	
			var _aIDs = $("#listTable").jqGrid('getGridParam','selarrrow');
			var myrows = [];
			if (_aIDs.length > 0) {
				for (var i=0; i < _aIDs.length; i++) {
				  var row = $("#listTable").jqGrid('getRowData', _aIDs[i]);
				  myrows[i] = row;
				  //alert("勾選[" + (i+1) + "]=" + row.user_id + "," + row.name + "," + row.cname + "," + row.role);
				}
			} else {
				$("#spaMsg").text("請先勾選資料列。");
			}
			alert("第一筆差異:"+JSON.stringify(getDifferences(myrows[1],myrows[0]), null, 4));
			alert("第二筆差異:"+JSON.stringify(getDifferences(myrows[0],myrows[1]), null, 4));
		}, 
	   position:"last"
	});
	!copy?'':$(listTable_id).jqGrid('navButtonAdd','#pager',{
	   caption:"複製", 
	   buttonicon:"ui-icon-copy", 
	   onClickButton: function(){ 
		  var id = $(listTable_id).jqGrid('getGridParam','selrow');
		  if (id) {
			var _iCount = $("#listTable").jqGrid('getGridParam', 'records');
			var row = $("#listTable").jqGrid('getRowData', id);
			$(listTable_id).jqGrid('addRowData', _iCount+1, row);
			$(listTable_id).jqGrid('saveRow',id);
			$("#spaMsg").html("複製被選取列的資料");
		  } else {
			$("#spaMsg").text("請先選取一列資料列。");
		  }
	  }, 
	   position:"last"
	});
	!del?'':$(listTable_id).jqGrid('navButtonAdd','#pager',{
	   caption:"刪除", 
	   buttonicon:"ui-icon-trash", 
	   onClickButton: function(){ 
		var gr = $(listTable_id).jqGrid('getGridParam','selarrrow');
		var _sid = [];
		if (gr.length > 0) {
			for (var i=0; i < gr.length; i++) {
				var id = gr[i];
				var row = $("#listTable").jqGrid('getRowData', id);
				_sid[i] = eval("row."+$("#listTable").attr("key"));
			}
		} else {
			$("#spaMsg").text("請先勾選資料列");
		}
		if( gr != null ) {
			$("#listTable").jqGrid('delGridRow',_sid.join(","),{height:280,reloadAfterSubmit:true});
		} else {
			alert("請先選取一列資料列。");
		}
	   }, 
	   position:"last"
	});
	//$("#pager").jqGrid('inlineNav',"#pager");
	

function getDifferences(oldObj, newObj) {
   var diff = {};

   for (var k in oldObj) {
      if (!(k in newObj))
         diff[k] = undefined;  // property gone so explicitly set it undefined
      else if (oldObj[k] !== newObj[k])
         diff[k] = newObj[k];  // property in both but has changed
   }

   for (k in newObj) {
      if (!(k in oldObj))
         diff[k] = newObj[k]; // property is new
   }

   return diff;
}
/* icon positioning 
.ui-icon-blank { background-position: 16px 16px; }
.ui-icon-carat-1-n { background-position: 0 0; }
.ui-icon-carat-1-ne { background-position: -16px 0; }
.ui-icon-carat-1-e { background-position: -32px 0; }
.ui-icon-carat-1-se { background-position: -48px 0; }
.ui-icon-carat-1-s { background-position: -64px 0; }
.ui-icon-carat-1-sw { background-position: -80px 0; }
.ui-icon-carat-1-w { background-position: -96px 0; }
.ui-icon-carat-1-nw { background-position: -112px 0; }
.ui-icon-carat-2-n-s { background-position: -128px 0; }
.ui-icon-carat-2-e-w { background-position: -144px 0; }
.ui-icon-triangle-1-n { background-position: 0 -16px; }
.ui-icon-triangle-1-ne { background-position: -16px -16px; }
.ui-icon-triangle-1-e { background-position: -32px -16px; }
.ui-icon-triangle-1-se { background-position: -48px -16px; }
.ui-icon-triangle-1-s { background-position: -64px -16px; }
.ui-icon-triangle-1-sw { background-position: -80px -16px; }
.ui-icon-triangle-1-w { background-position: -96px -16px; }
.ui-icon-triangle-1-nw { background-position: -112px -16px; }
.ui-icon-triangle-2-n-s { background-position: -128px -16px; }
.ui-icon-triangle-2-e-w { background-position: -144px -16px; }
.ui-icon-arrow-1-n { background-position: 0 -32px; }
.ui-icon-arrow-1-ne { background-position: -16px -32px; }
.ui-icon-arrow-1-e { background-position: -32px -32px; }
.ui-icon-arrow-1-se { background-position: -48px -32px; }
.ui-icon-arrow-1-s { background-position: -64px -32px; }
.ui-icon-arrow-1-sw { background-position: -80px -32px; }
.ui-icon-arrow-1-w { background-position: -96px -32px; }
.ui-icon-arrow-1-nw { background-position: -112px -32px; }
.ui-icon-arrow-2-n-s { background-position: -128px -32px; }
.ui-icon-arrow-2-ne-sw { background-position: -144px -32px; }
.ui-icon-arrow-2-e-w { background-position: -160px -32px; }
.ui-icon-arrow-2-se-nw { background-position: -176px -32px; }
.ui-icon-arrowstop-1-n { background-position: -192px -32px; }
.ui-icon-arrowstop-1-e { background-position: -208px -32px; }
.ui-icon-arrowstop-1-s { background-position: -224px -32px; }
.ui-icon-arrowstop-1-w { background-position: -240px -32px; }
.ui-icon-arrowthick-1-n { background-position: 0 -48px; }
.ui-icon-arrowthick-1-ne { background-position: -16px -48px; }
.ui-icon-arrowthick-1-e { background-position: -32px -48px; }
.ui-icon-arrowthick-1-se { background-position: -48px -48px; }
.ui-icon-arrowthick-1-s { background-position: -64px -48px; }
.ui-icon-arrowthick-1-sw { background-position: -80px -48px; }
.ui-icon-arrowthick-1-w { background-position: -96px -48px; }
.ui-icon-arrowthick-1-nw { background-position: -112px -48px; }
.ui-icon-arrowthick-2-n-s { background-position: -128px -48px; }
.ui-icon-arrowthick-2-ne-sw { background-position: -144px -48px; }
.ui-icon-arrowthick-2-e-w { background-position: -160px -48px; }
.ui-icon-arrowthick-2-se-nw { background-position: -176px -48px; }
.ui-icon-arrowthickstop-1-n { background-position: -192px -48px; }
.ui-icon-arrowthickstop-1-e { background-position: -208px -48px; }
.ui-icon-arrowthickstop-1-s { background-position: -224px -48px; }
.ui-icon-arrowthickstop-1-w { background-position: -240px -48px; }
.ui-icon-arrowreturnthick-1-w { background-position: 0 -64px; }
.ui-icon-arrowreturnthick-1-n { background-position: -16px -64px; }
.ui-icon-arrowreturnthick-1-e { background-position: -32px -64px; }
.ui-icon-arrowreturnthick-1-s { background-position: -48px -64px; }
.ui-icon-arrowreturn-1-w { background-position: -64px -64px; }
.ui-icon-arrowreturn-1-n { background-position: -80px -64px; }
.ui-icon-arrowreturn-1-e { background-position: -96px -64px; }
.ui-icon-arrowreturn-1-s { background-position: -112px -64px; }
.ui-icon-arrowrefresh-1-w { background-position: -128px -64px; }
.ui-icon-arrowrefresh-1-n { background-position: -144px -64px; }
.ui-icon-arrowrefresh-1-e { background-position: -160px -64px; }
.ui-icon-arrowrefresh-1-s { background-position: -176px -64px; }
.ui-icon-arrow-4 { background-position: 0 -80px; }
.ui-icon-arrow-4-diag { background-position: -16px -80px; }
.ui-icon-extlink { background-position: -32px -80px; }
.ui-icon-newwin { background-position: -48px -80px; }
.ui-icon-refresh { background-position: -64px -80px; }
.ui-icon-shuffle { background-position: -80px -80px; }
.ui-icon-transfer-e-w { background-position: -96px -80px; }
.ui-icon-transferthick-e-w { background-position: -112px -80px; }
.ui-icon-folder-collapsed { background-position: 0 -96px; }
.ui-icon-folder-open { background-position: -16px -96px; }
.ui-icon-document { background-position: -32px -96px; }
.ui-icon-document-b { background-position: -48px -96px; }
.ui-icon-note { background-position: -64px -96px; }
.ui-icon-mail-closed { background-position: -80px -96px; }
.ui-icon-mail-open { background-position: -96px -96px; }
.ui-icon-suitcase { background-position: -112px -96px; }
.ui-icon-comment { background-position: -128px -96px; }
.ui-icon-person { background-position: -144px -96px; }
.ui-icon-print { background-position: -160px -96px; }
.ui-icon-trash { background-position: -176px -96px; }
.ui-icon-locked { background-position: -192px -96px; }
.ui-icon-unlocked { background-position: -208px -96px; }
.ui-icon-bookmark { background-position: -224px -96px; }
.ui-icon-tag { background-position: -240px -96px; }
.ui-icon-home { background-position: 0 -112px; }
.ui-icon-flag { background-position: -16px -112px; }
.ui-icon-calendar { background-position: -32px -112px; }
.ui-icon-cart { background-position: -48px -112px; }
.ui-icon-pencil { background-position: -64px -112px; }
.ui-icon-clock { background-position: -80px -112px; }
.ui-icon-disk { background-position: -96px -112px; }
.ui-icon-calculator { background-position: -112px -112px; }
.ui-icon-zoomin { background-position: -128px -112px; }
.ui-icon-zoomout { background-position: -144px -112px; }
.ui-icon-search { background-position: -160px -112px; }
.ui-icon-wrench { background-position: -176px -112px; }
.ui-icon-gear { background-position: -192px -112px; }
.ui-icon-heart { background-position: -208px -112px; }
.ui-icon-star { background-position: -224px -112px; }
.ui-icon-link { background-position: -240px -112px; }
.ui-icon-cancel { background-position: 0 -128px; }
.ui-icon-plus { background-position: -16px -128px; }
.ui-icon-plusthick { background-position: -32px -128px; }
.ui-icon-minus { background-position: -48px -128px; }
.ui-icon-minusthick { background-position: -64px -128px; }
.ui-icon-close { background-position: -80px -128px; }
.ui-icon-closethick { background-position: -96px -128px; }
.ui-icon-key { background-position: -112px -128px; }
.ui-icon-lightbulb { background-position: -128px -128px; }
.ui-icon-scissors { background-position: -144px -128px; }
.ui-icon-clipboard { background-position: -160px -128px; }
.ui-icon-copy { background-position: -176px -128px; }
.ui-icon-contact { background-position: -192px -128px; }
.ui-icon-image { background-position: -208px -128px; }
.ui-icon-video { background-position: -224px -128px; }
.ui-icon-script { background-position: -240px -128px; }
.ui-icon-alert { background-position: 0 -144px; }
.ui-icon-info { background-position: -16px -144px; }
.ui-icon-notice { background-position: -32px -144px; }
.ui-icon-help { background-position: -48px -144px; }
.ui-icon-check { background-position: -64px -144px; }
.ui-icon-bullet { background-position: -80px -144px; }
.ui-icon-radio-on { background-position: -96px -144px; }
.ui-icon-radio-off { background-position: -112px -144px; }
.ui-icon-pin-w { background-position: -128px -144px; }
.ui-icon-pin-s { background-position: -144px -144px; }
.ui-icon-play { background-position: 0 -160px; }
.ui-icon-pause { background-position: -16px -160px; }
.ui-icon-seek-next { background-position: -32px -160px; }
.ui-icon-seek-prev { background-position: -48px -160px; }
.ui-icon-seek-end { background-position: -64px -160px; }
.ui-icon-seek-start { background-position: -80px -160px; }
// ui-icon-seek-first is deprecated, use ui-icon-seek-start instead 
.ui-icon-seek-first { background-position: -80px -160px; }
.ui-icon-stop { background-position: -96px -160px; }
.ui-icon-eject { background-position: -112px -160px; }
.ui-icon-volume-off { background-position: -128px -160px; }
.ui-icon-volume-on { background-position: -144px -160px; }
.ui-icon-power { background-position: 0 -176px; }
.ui-icon-signal-diag { background-position: -16px -176px; }
.ui-icon-signal { background-position: -32px -176px; }
.ui-icon-battery-0 { background-position: -48px -176px; }
.ui-icon-battery-1 { background-position: -64px -176px; }
.ui-icon-battery-2 { background-position: -80px -176px; }
.ui-icon-battery-3 { background-position: -96px -176px; }
.ui-icon-circle-plus { background-position: 0 -192px; }
.ui-icon-circle-minus { background-position: -16px -192px; }
.ui-icon-circle-close { background-position: -32px -192px; }
.ui-icon-circle-triangle-e { background-position: -48px -192px; }
.ui-icon-circle-triangle-s { background-position: -64px -192px; }
.ui-icon-circle-triangle-w { background-position: -80px -192px; }
.ui-icon-circle-triangle-n { background-position: -96px -192px; }
.ui-icon-circle-arrow-e { background-position: -112px -192px; }
.ui-icon-circle-arrow-s { background-position: -128px -192px; }
.ui-icon-circle-arrow-w { background-position: -144px -192px; }
.ui-icon-circle-arrow-n { background-position: -160px -192px; }
.ui-icon-circle-zoomin { background-position: -176px -192px; }
.ui-icon-circle-zoomout { background-position: -192px -192px; }
.ui-icon-circle-check { background-position: -208px -192px; }
.ui-icon-circlesmall-plus { background-position: 0 -208px; }
.ui-icon-circlesmall-minus { background-position: -16px -208px; }
.ui-icon-circlesmall-close { background-position: -32px -208px; }
.ui-icon-squaresmall-plus { background-position: -48px -208px; }
.ui-icon-squaresmall-minus { background-position: -64px -208px; }
.ui-icon-squaresmall-close { background-position: -80px -208px; }
.ui-icon-grip-dotted-vertical { background-position: 0 -224px; }
.ui-icon-grip-dotted-horizontal { background-position: -16px -224px; }
.ui-icon-grip-solid-vertical { background-position: -32px -224px; }
.ui-icon-grip-solid-horizontal { background-position: -48px -224px; }
.ui-icon-gripsmall-diagonal-se { background-position: -64px -224px; }
.ui-icon-grip-diagonal-se { background-position: -80px -224px; }
*/
});

$('#btnRight').click(function() {
alert('test1');
 $('#ProductList option:selected').each(function() {
  $("#ChooseProduct").append("<option value='" + $(this).val() + "'>" + $(this).text() + "</option");
  $(this).remove();
 });
 SortOption("#ChooseProduct");
});

$('#btnLeft').click(function() {
alert('test2');
 $('#ChooseProduct option:selected').each(function() {
  $("#ProductList").append("<option value='" + $(this).val() + "'>" + $(this).text() + "</option");
  $(this).remove();
 });
 SortOption("#ProductList");
});

function SortOption(selectName) {
 //將所指定的 Select Collection 給 $dd
 var $dd = $(selectName);

 //將 Option 的 Text 與 Value 足筆塞到陣列中
 if ($dd.length > 0) {
  var selectedVal = $dd.val();
  var $options = $('option', $dd);
  var arrVals = [];
  $options.each(function() {
   arrVals.push({
    text: $(this).text(),
    val: $(this).val()
   });
  });

  //使用 Javascript Array 提供的 Sort 功能，進行 Text 的排序
  //此處排序方式是使用 ASC (遞增排序)
  arrVals.sort(function(a, b) {
   if (a.text > b.text) {
    return 1;
   }
   else if (a.text == b.text) {
    return 0;
   }
   else {
    return -1;
   }
  });

  //將排序後的結果，再塞回 $options 中
  for (var i = 0, l = arrVals.length; i < l; i++) {
   $($options[i]).val(arrVals[i].val).text(arrVals[i].text);
  }

  //指定被選取的選項
  //$dd.val(selectedVal);
 }
}
