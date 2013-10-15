$(document).ready(function() {
	
var myMaster = function(num) {

	//myMaster(0);
	//myMaster(1); ...
	var listTable_id = "#listTable" + num;
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
		mycolModel[i] = "{name:'" + myField[i] + 
		"',index:'" + myField[i] + "',sortable: true" 
		+ ",width: 120" + ",align:'left'" +"}";
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
			if ($(listTable_id).jqGrid('getGridParam', 'records') > 10 ) {
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
		cmTemplate: {editable:true},
		pager: '#mpager'+num, 
		rowNum: 5,  
		rowList:[5,10,20], // 每頁顯示筆數
		sortname: $(listTable_id).attr("key"), 
		sortorder: 'asc', 
		caption: $(listTable_id).attr("value"), 
		height: 'auto',  // Grid高度
		width: 'auto', 
		autowidth: true,// 自動欄寬
		viewrecords: true,
		altRows: true,
		//footerrow: true,
		gridview: true,  // 設定成true以快速大量資料集之載入
		//loadonce: true,  // 只由Server讀一次資料
		rownumbers: true,
		multiselect: true,  // 顯示勾選框
		/*
		onSelectRow: function(id){ 
		
		   if(id && id!==lastsel){ 
				jQuery('#list').jqGrid('restoreRow',lastsel);
				jQuery('#list').jqGrid('saveRow',id);
				jQuery('#list').jqGrid('editRow',id,true); 
				lastsel=id; 
			} 
		},	
		*/
		jsonReader : { 
						root: "rows", 
						page: "page", 
						total: "total", 
						cell: "cell", 
					},
		onSelectRow: function(rowid) {
			if ($("#DetailGrid0").length > 0) {
				var category = $(listTable_id).getCell(rowid,2);
				$("#DetailGrid0").jqGrid('setGridParam', { url:baseURL +'/index/testsql?MASTERtype=DETAIL&Category=' + category+str}).trigger("reloadGrid");
			};
			if ($("#DetailGrid1").length > 0) {
				var category = $(listTable_id).getCell(rowid,2);
				$("#DetailGrid1").jqGrid('setGridParam', { url:baseURL +'/index/testsql?MASTERtype=DETAIL&Category=' + category+str1}).trigger("reloadGrid");
			};	
			if ($("#DetailGrid2").length > 0) {
				var category = $(listTable_id).getCell(rowid,2);
				$("#DetailGrid2").jqGrid('setGridParam', { url:baseURL +'/index/testsql?MASTERtype=DETAIL&Category=' + category+str2}).trigger("reloadGrid");
			};	
			if ($("#DetailGrid3").length > 0) {
				var category = $(listTable_id).getCell(rowid,2);
				$("#DetailGrid3").jqGrid('setGridParam', { url:baseURL +'/index/testsql?MASTERtype=DETAIL&Category=' + category+str3}).trigger("reloadGrid");
			};
			//alert(category);
        }

	}).navGrid('#mpager'+num,{
	    
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
	}, // search options,
	{
	}, // view options,
	{
	} // refresh options
	);
!compare?'':$(listTable_id).jqGrid('navButtonAdd','#mpager'+num,{
		caption:"比較", 
		buttonicon:"ui-icon-gear", 
		onClickButton: function(){ 	
			var _aIDs = $(listTable_id).jqGrid('getGridParam','selarrrow');
			var myrows = [];
			if (_aIDs.length > 0) {
				for (var i=0; i < _aIDs.length; i++) {
				  var row = $(listTable_id).jqGrid('getRowData', _aIDs[i]);
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
!copy?'':$(listTable_id).jqGrid('navButtonAdd','#mpager'+num,{
	   caption:"複製", 
	   buttonicon:"ui-icon-copy", 
	   onClickButton: function(){ 
		  var id = $(listTable_id).jqGrid('getGridParam','selrow');
		  if (id) {
			var _iCount = $(listTable_id).jqGrid('getGridParam', 'records');
			var row = $(listTable_id).jqGrid('getRowData', id);
			$(listTable_id).jqGrid('addRowData', _iCount+1, row);
			$(listTable_id).jqGrid('saveRow',id);
			$("#spaMsg").html("複製被選取列的資料");
		  } else {
			$("#spaMsg").text("請先選取一列資料列。");
		  }
	  }, 
	   position:"last"
	});
!del?'':$(listTable_id).jqGrid('navButtonAdd','#mpager'+num,{
	   caption:"刪除", 
	   buttonicon:"ui-icon-trash", 
	   onClickButton: function(){ 
		var gr = $(listTable_id).jqGrid('getGridParam','selarrrow');
		var _sid = [];
		if (gr.length > 0) {
			for (var i=0; i < gr.length; i++) {
				var id = gr[i];
				var row = $(listTable_id).jqGrid('getRowData', id);
				_sid[i] = eval("row."+$(listTable_id).attr("key"));
			}
		} else {
			$("#spaMsg").text("請先勾選資料列");
		}
		if( gr != null ) {
			alert(_sid.join(","));
			$(listTable_id).jqGrid('delGridRow',_sid.join(","),{height:280,reloadAfterSubmit:true});
		} else {
			alert("請先選取一列資料列。");
		}
	   }, 
	   position:"last"
	});
	//$("#mpager"+num).jqGrid('inlineNav',"#mpager"+num);


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

var myDetail = function(num) {
if ($("#DetailGrid0").length > 0) {
	var DetailGrid_id = "#DetailGrid0";
	str= "&"+"_sql="   + $(DetailGrid_id).attr("sql")   + "&" +	
		"_db="    + $(DetailGrid_id).attr("db")    + "&" +
		"_table=" + $(DetailGrid_id).attr("table") + "&" +
		"_name="  + $(DetailGrid_id).attr("name")  + "&" +			
		"_field=" + $(DetailGrid_id).attr("field") + "&" +
		"_key="   + $(DetailGrid_id).attr("key")   + "&" +
		"_value=" + $(DetailGrid_id).attr("value") + "&" +
		"_pk="    + $(DetailGrid_id).attr("pk")    + "&" +
		"_where=" + $(DetailGrid_id).attr("where") + "&" +
		"_id="    + $(DetailGrid_id).attr("id");

	var myName = $(DetailGrid_id).attr("name").split(",");
	mycolName = [];
	for (i in myName) {
		mycolName[i] = "'" + myName[i] + "'";
	}
	mycolNames = eval("[" + mycolName.join(",") + "]");
	
	//mycolModels 
	var myField = $(DetailGrid_id).attr("field").split(",");
	mycolModel = [];
	for (i in myField) {
		mycolModel[i] = "{name:'" + myField[i] + 
		"',index:'" + myField[i] + "',sortable: true" 
		+ ",width: 120" + ",align:'left'" +"}";
	}
	mycolModels = eval("[" + mycolModel.join(",") + "]");

	$(DetailGrid_id).jqGrid({
        url: baseURL + "/index/testsql" + "?MASTERtype='DETAIL'&" + str,
		datatype: "json",
        colNames: mycolNames,  
        colModel: mycolModels,
		cmTemplate: {editable:true},
		pager: '#dpager0', 
		rowNum: 5,  
		rowList:[5,10,20], // 每頁顯示筆數
		sortname: $(DetailGrid_id).attr("key"), 
		sortorder: 'asc', 
		caption: $(DetailGrid_id).attr("value"), 
		height: 'auto',  // Grid高度
		width: 'auto', 
		autowidth: true,// 自動欄寬
		multiselect: true,  // 顯示勾選框
		gridview: true
    }).navGrid('#dpager0',{
	    
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
	}, // search options,
	{
	}, // view options,
	{
	} // refresh options
	);
}	
if ($("#DetailGrid1").length > 0) {
	var DetailGrid1_id = "#DetailGrid1";
	str1= "&"+"_sql="   + $(DetailGrid1_id).attr("sql")   + "&" +	
		"_db="    + $(DetailGrid1_id).attr("db")    + "&" +
		"_table=" + $(DetailGrid1_id).attr("table") + "&" +
		"_name="  + $(DetailGrid1_id).attr("name")  + "&" +			
		"_field=" + $(DetailGrid1_id).attr("field") + "&" +
		"_key="   + $(DetailGrid1_id).attr("key")   + "&" +
		"_value=" + $(DetailGrid1_id).attr("value") + "&" +
		"_pk="    + $(DetailGrid1_id).attr("pk")    + "&" +
		"_where=" + $(DetailGrid1_id).attr("where") + "&" +
		"_id="    + $(DetailGrid1_id).attr("id");
	var myName = $(DetailGrid1_id).attr("name").split(",");
	//alert(DetailGrid1_id);
	mycolName = [];
	for (i in myName) {
		mycolName[i] = "'" + myName[i] + "'";
	}
	mycolNames = eval("[" + mycolName.join(",") + "]");
	
	//mycolModels 
	var myField = $(DetailGrid1_id).attr("field").split(",");
	mycolModel = [];
	for (i in myField) {
		mycolModel[i] = "{name:'" + myField[i] + 
		"',index:'" + myField[i] + "',sortable: true" 
		+ ",width: 120" + ",align:'left'" +"}";
	}
	mycolModels = eval("[" + mycolModel.join(",") + "]");

	$(DetailGrid1_id).jqGrid({
        url: baseURL + "/index/testsql" + "?MASTERtype='DETAIL'&" + str1,
		datatype: "json",
        colNames: mycolNames,  
        colModel: mycolModels,
		cmTemplate: {editable:true},
		pager: '#dpager1', 
		rowNum: 5,  
		rowList:[5,10,20], // 每頁顯示筆數
		sortname: $(DetailGrid1_id).attr("key"), 
		sortorder: 'asc', 
		caption: $(DetailGrid1_id).attr("value"), 
		height: 'auto',  // Grid高度
		width: 'auto', 
		autowidth: true,// 自動欄寬
		gridview: true
    }).navGrid('#dpager1',{
	    
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
	}, // search options,
	{
	}, // view options,
	{
	} // refresh options
	);
};
if ($("#DetailGrid2").length > 0) {	
	var DetailGrid2_id = "#DetailGrid2";
	str2= "&"+"_sql="   + $(DetailGrid2_id).attr("sql")   + "&" +	
		"_db="    + $(DetailGrid2_id).attr("db")    + "&" +
		"_table=" + $(DetailGrid2_id).attr("table") + "&" +
		"_name="  + $(DetailGrid2_id).attr("name")  + "&" +			
		"_field=" + $(DetailGrid2_id).attr("field") + "&" +
		"_key="   + $(DetailGrid2_id).attr("key")   + "&" +
		"_value=" + $(DetailGrid2_id).attr("value") + "&" +
		"_pk="    + $(DetailGrid2_id).attr("pk")    + "&" +
		"_where=" + $(DetailGrid2_id).attr("where") + "&" +
		"_id="    + $(DetailGrid2_id).attr("id");
	var myName = $(DetailGrid2_id).attr("name").split(",");
	mycolName = [];
	for (i in myName) {
		mycolName[i] = "'" + myName[i] + "'";
	}
	mycolNames = eval("[" + mycolName.join(",") + "]");
	
	//mycolModels 
	var myField = $(DetailGrid2_id).attr("field").split(",");
	mycolModel = [];
	for (i in myField) {
		mycolModel[i] = "{name:'" + myField[i] + 
		"',index:'" + myField[i] + "',sortable: true" 
		+ ",width: 120" + ",align:'left'" +"}";
	}
	mycolModels = eval("[" + mycolModel.join(",") + "]");

	$(DetailGrid2_id).jqGrid({
        url: baseURL + "/index/testsql" + "?MASTERtype='DETAIL'&" + str2,
		datatype: "json",
        colNames: mycolNames,  
        colModel: mycolModels,
		cmTemplate: {editable:true},
		pager: '#dpager2', 
		rowNum: 5,  
		rowList:[5,10,20], // 每頁顯示筆數
		sortname: $(DetailGrid2_id).attr("key"), 
		sortorder: 'asc', 
		caption: $(DetailGrid2_id).attr("value"), 
		height: 'auto',  // Grid高度
		width: 'auto', 
		autowidth: true,// 自動欄寬
		gridview: true
        
		
    }).navGrid('#dpager2',{
	    
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
	}, // search options,
	{
	}, // view options,
	{
	} // refresh options
	);
}	
if ($("#DetailGrid3").length > 0) {
	var DetailGrid3_id = "#DetailGrid3";
	str3= "&"+"_sql="   + $(DetailGrid3_id).attr("sql")   + "&" +	
		"_db="    + $(DetailGrid3_id).attr("db")    + "&" +
		"_table=" + $(DetailGrid3_id).attr("table") + "&" +
		"_name="  + $(DetailGrid3_id).attr("name")  + "&" +			
		"_field=" + $(DetailGrid3_id).attr("field") + "&" +
		"_key="   + $(DetailGrid3_id).attr("key")   + "&" +
		"_value=" + $(DetailGrid3_id).attr("value") + "&" +
		"_pk="    + $(DetailGrid3_id).attr("pk")    + "&" +
		"_where=" + $(DetailGrid3_id).attr("where") + "&" +
		"_id="    + $(DetailGrid3_id).attr("id");
	var myName = $(DetailGrid3_id).attr("name").split(",");
	mycolName = [];
	for (i in myName) {
		mycolName[i] = "'" + myName[i] + "'";
	}
	mycolNames = eval("[" + mycolName.join(",") + "]");
	
	//mycolModels 
	var myField = $(DetailGrid3_id).attr("field").split(",");
	mycolModel = [];
	for (i in myField) {
		mycolModel[i] = "{name:'" + myField[i] + 
		"',index:'" + myField[i] + "',sortable: true" 
		+ ",width: 120" + ",align:'left'" +"}";
	}
	mycolModels = eval("[" + mycolModel.join(",") + "]");

	$(DetailGrid3_id).jqGrid({
        url: baseURL + "/index/testsql" + "?MASTERtype='DETAIL'&" + str3,
		datatype: "json",
        colNames: mycolNames,  
        colModel: mycolModels,
		cmTemplate: {editable:true},
		pager: '#dpager3', 
		rowNum: 5,  
		rowList:[5,10,20], // 每頁顯示筆數
		sortname: $(DetailGrid3_id).attr("key"), 
		sortorder: 'asc', 
		caption: $(DetailGrid3_id).attr("value"), 
		height: 'auto',  // Grid高度
		width: 'auto', 
		autowidth: true,// 自動欄寬
		gridview: true
        
		
    }).navGrid('#dpager3',{
	    
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
	}, // search options,
	{
	}, // view options,
	{
	} // refresh options
	);
};	// If
}; //myDetail Function

myDetail(0);
/*
jj = 0 ;
while (jj < 20) {
	if ($("#DetailGrid"+jj).length == 0 ) {
		break;
	} else {
	myDetail(jj);
	}
	jj++;
}
*/
}; //myMaster Function

ii = 0 ;
while (ii < 20) {
	if ($("#listTable"+ii).length == 0 ) {
		break;
	} else {
	myMaster(ii);
	}
	ii++;
}
}); //Doc ready
