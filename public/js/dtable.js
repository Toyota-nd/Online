var b64ch = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
function base64Decode(b64)
{
   var i, j, k;
   var c = [0,0,0,0];
   var uba = []; // unicode byte array
   var ucs = ""; // unicode string
   var ch; // single character
   for (j=k=0; ; ) {
     for (i=0; i<4 && k<b64.length; k++) {
     ch = b64.charAt(k);
     switch (ch) {
      case '=' : c[i] = 0; break;
      case '\r':
      case '\n': continue;
     default:
     c[i++] = b64ch.indexOf(ch);
     }
     }
     uba.length += 3;
     if (i>0) uba[j++] = (c[0] << 2 | c[1] >>> 4) & 0xff;
     if (i>1) uba[j++] = (c[1] << 4 | c[2] >>> 2) & 0xff;
     if (i>2) uba[j++] = (c[2] << 6 | c[3]) & 0xff;
     if (i<4) break;
   }
   if (uba.length % 2 != 0) uba.length--;
   for (j=0; j<uba.length; j+=2) {
     ch = (uba[j] | uba[j+1] << 8).toString(16);
     ch = "0000".substring(ch.length) + ch;
     ucs += unescape("%u"+ch);
   }
   return ucs;
}
function base64Encode(str, flag)
{
   var i, j, k;
   var b = [0,0,0];
   var uba = []; // unicode byte array
   var b64 = ""; // the base64 string
   var len; // length of base64 string
   var ch; // single character
   for (j=0,k=0; j<str.length; j++) {
     ch = str.charCodeAt(j);
     uba.length += 2;
     uba[k++] = ch & 0xff;
     uba[k++] = ch >>> 8;
   }
   for (j=k=len=0; ; ) {
     b[0] = b[1] = b[2] = 0;
     for (i=0; i<3 && j<uba.length; i++,j++)
     b[i] = uba[j];
     if (i==0) break;
     b64 += b64ch.charAt([b[0] >>> 2]);
     b64 += b64ch.charAt((b[0] & 0x03) << 4 | b[1] >>> 4);
     b64 += i>1 ? b64ch.charAt((b[1] & 0x0f) << 2 | b[2] >>> 6) : "=";
     b64 += i>2 ? b64ch.charAt(b[2] & 0x3f) : "=";
     len += 4;
     if (flag && len%76==0) b64 += "\r\n";
   }
   return b64;
}

function isEmpty(str) {
    return (!str || 0 === str.length);
}

function isBlank(str) {
    return (!str || /^\s*$/.test(str));
}

$(document).ready(function() {
	
var mstr = []; // For master
var dstr = []; // For Detail 
var mdstr = []; // For master-deltail printing purpose with dynamic PK
var maxGridNum = 20;

var myMaster = function(num) {

	//myMaster(0);
	//myMaster(1); ...
	var MasterGrid_id = "#MasterGrid" + num;
	//myJoins,只有Master才有
	var myJoins  = []; //宣告第一維陣列
    myJoins[num] = []; //宣告第二維陣列
	 //判斷字串使用isEmpty
	 //判斷陣列使用isBlank
	if (typeof($(MasterGrid_id).attr("join")) != "undefined") {
		myJoins[num] = $(MasterGrid_id).attr("join").split(",");
		//alert("#MasterGrid" + num+ ":" + myJoins[num] + ":" + type(myJoins[num])+":"+myJoins[num].length);
	}
	
	//myTypes
	var myTypeArray = $(MasterGrid_id).attr("type").split(",");
	var myTypes = ["view","edit","add","del","search",
					"refresh","copy","compare","print"];
	for (i in myTypes) {
		eval("var " + myTypes[i]+ " = false;");
		for (j in  myTypeArray) {
			if ( myTypeArray[j] == myTypes[i] ) {
				eval("var " + myTypeArray[j]+ " = true;");
			};
		}
	}
	
	var mydataType = [];
	if (typeof($(MasterGrid_id).attr("datatype")) != "undefined") {
		mydataType = $(MasterGrid_id).attr("datatype").split(",");
	}	
	
	//mycolNames
	var myName = $(MasterGrid_id).attr("title").split(",");
	mycolName = [];
	for (i in myName) {
		mycolName[i] = "'" + myName[i] + "'";
	}
	mycolNames = eval("[" + mycolName.join(",") + "]");
	
	//mycolModels 
	function myUI(el,mytype,idx) {
		switch(mytype) {
			case 'datetime':
				setDatetimePicker(el,'09:10:00');
			break;
			case 'string':
				setAutocomplete(el,mstr[idx]); //, mstr[idx]
			break;
				default:
		}
	}
	
 	var myField = $(MasterGrid_id).attr("field").split(",");
	mycolModel = [];
	datetimeType1 = "editoptions: {" +
		"dataInit: function(el) {" +
		"setTimeout(function() {" +
		"myUI(el,";
	datetimeType2 = ");" +
		"}, 200);" +
		"}}";
		
	for (i in myField) {
		mycolModel[i] = "{name:'" + myField[i] + 
		"',index:'" + myField[i] + "',sortable: true" 
		+ ",width: 120" + ",align:'left'";
		mycolModel[i] += "," + datetimeType1 + "'" + 
				mydataType[i] + "'" + "," + i + datetimeType2 ;
		mycolModel[i] +=  "}\n";
	};
	
	mycolModels = eval("[" + mycolModel.join(",") + "]");
	mstr[num] = "&" + 
			"_type="  + $(MasterGrid_id).attr("type")  + "&" +
			"_sql="   + $(MasterGrid_id).attr("sql")   + "&" +	
			"_db="    + $(MasterGrid_id).attr("db")    + "&" +
			"_table=" + $(MasterGrid_id).attr("table") + "&" +
			"_name="  + $(MasterGrid_id).attr("name")  + "&" +			
			"_field=" + $(MasterGrid_id).attr("field") + "&" +
			"_key="   + $(MasterGrid_id).attr("key")   + "&" +
			"_value=" + $(MasterGrid_id).val() + "&" +
			"_myvalue=" + $(MasterGrid_id).attr("value") + "&" +
			"_pk="    + $(MasterGrid_id).attr("pk")    + "&" +
			"_where=" + $(MasterGrid_id).attr("where") + "&" +
			"_id="    + $(MasterGrid_id).attr("id");
	mdstr[num] = "&" + 
			"_type="  + $(MasterGrid_id).attr("type")  + "&" +
			"_sql="   + $(MasterGrid_id).attr("sql")   + "&" +	
			"_db="    + $(MasterGrid_id).attr("db")    + "&" +
			"_table=" + $(MasterGrid_id).attr("table") + "&" +
			"_name="  + $(MasterGrid_id).attr("name")  + "&" +			
			"_field=" + $(MasterGrid_id).attr("field") + "&" +
			"_key="   + $(MasterGrid_id).attr("key")   + "&" +
			"_value=" + $(MasterGrid_id).val() + "&" +
			"_myvalue=" + $(MasterGrid_id).attr("value") + "&" +
		//	"_pk="    + $(MasterGrid_id).attr("pk")    + "&" +
			"_where=" + $(MasterGrid_id).attr("where") + "&" +
			"_id="    + $(MasterGrid_id).attr("id");
	$(MasterGrid_id).jqGrid({	 
		url: baseURL + 	"/index/listsql" + "?" +
			+ "_event='MasterGrid:jqGrid'" + mstr[num]
			,
		editurl: baseURL + 	"/index/sql" + "?" +
			+ "_event='MasterGrid:jqGrid_edit"+ mstr[num]
		,
		loadBeforeSend: function(jqXHR) {
			//alert(jqXHR.responseText);
		},	
		
		/*
		loadComplete: function (ids) {
			if ($(MasterGrid_id).jqGrid('getGridParam', 'records') > 10 ) {
				$("#add_MasterGrid").addClass('ui-state-disabled');
			} else {
				$("#add_MasterGrid").removeClass('ui-state-disabled');
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
		rowList:[5,10,20,50,100,200,500,1000,5000], // 每頁顯示筆數
		sortname: $(MasterGrid_id).attr("key"), 
		sortorder: 'asc', 
		caption: $(MasterGrid_id).attr("value"), 
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
		/*
		onCellSelect: function (rowid, iCol, cellcontent) {
		//	alert(rowid + "," + iCol + ":" + cellcontent);
		},
		*/
		ondblClickRow: function (rowId, iRow, iCol, e) {
		//new modal based on above
			setDialog('div_tags', e.target.title);
			//setDatetimePicker(e,'09:10:00');
			//alert(rowId + "," + iRow + "," + iCol);
		},		
		jsonReader : { 
						root: "rows", 
						page: "page", 
						total: "total", 
						cell: "cell", 
					},
		onSelectRow: function(rowid) {
		$(MasterGrid_id).attr("key")
			for (i in myJoins[num]) {
				if ($("#DetailGrid"+i).length > 0  && !isEmpty(myJoins[num][i])) {
					var category = $(MasterGrid_id).getCell(rowid,myJoins[num][i]);
					$("#DetailGrid"+i).jqGrid('setGridParam', { 
						url:baseURL +'/index/testsql?MASTERtype=DETAIL&_pk=' +
						category+dstr[i]}).trigger("reloadGrid");
				};
			};
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
		multipleSearch:true,
		showQuery:true,
		searchOperators : true,
		searchOnEnter: true		
	}, // search options,
	{
	}, // view options,
	{
	} // refresh options
	);
!compare?'':$(MasterGrid_id).jqGrid('navButtonAdd','#mpager'+num,{
		caption:"比較", 
		buttonicon:"ui-icon-gear", 
		onClickButton: function(){ 	
			var _aIDs = $(MasterGrid_id).jqGrid('getGridParam','selarrrow');
			var myrows = [];
			if (_aIDs.length > 0) {
				for (var i=0; i < _aIDs.length; i++) {
				  var row = $(MasterGrid_id).jqGrid('getRowData', _aIDs[i]);
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
!copy?'':$(MasterGrid_id).jqGrid('navButtonAdd','#mpager'+num,{
	   caption:"複製", 
	   buttonicon:"ui-icon-copy", 
	   onClickButton: function(){ 
		  var id = $(MasterGrid_id).jqGrid('getGridParam','selrow');
		  if (id) {
			var _iCount = $(MasterGrid_id).jqGrid('getGridParam', 'records');
			var row = $(MasterGrid_id).jqGrid('getRowData', id);
			$(MasterGrid_id).jqGrid('addRowData', _iCount+1, row);
			$(MasterGrid_id).jqGrid('saveRow',id);
			$("#spaMsg").html("複製被選取列的資料");
		  } else {
			$("#spaMsg").html("請先選取一列資料列。");
		  }
	  }, 
	   position:"last"
	});
!del?'':$(MasterGrid_id).jqGrid('navButtonAdd','#mpager'+num,{
	   caption:"刪除", 
	   buttonicon:"ui-icon-trash", 
	   onClickButton: function(){ 
		var gr = $(MasterGrid_id).jqGrid('getGridParam','selarrrow');
		var _sid = [];
		if (gr.length > 0) {
			for (var i=0; i < gr.length; i++) {
				var id = gr[i];
				var row = $(MasterGrid_id).jqGrid('getRowData', id);
				_sid[i] = eval("row."+$(MasterGrid_id).attr("key"));
			}
		} else {
			myalert("請先勾選資料列");
		}
		if( gr != null ) {
			alert(_sid.join(","));
			$(MasterGrid_id).jqGrid('delGridRow',_sid.join(","),{height:280,reloadAfterSubmit:true});
		} else {
			myalert("請先選取一列資料列。");
		}
	   }, 
	   rowNum: 5,
	   position:"last"
	});
	//$("#mpager"+num).jqGrid('inlineNav',"#mpager"+num);
	

!print?'':$(MasterGrid_id).jqGrid('navButtonAdd','#mpager'+num,{
	caption:"列印", 
	buttonicon:"ui-icon-print", 
	onClickButton: function(){ 
		var gr = $(MasterGrid_id).jqGrid('getGridParam','selarrrow');
		var _sid = [];
		if (gr.length > 0) {
			for (var i=0; i < gr.length; i++) {
				var id = gr[i];
				var row = $(MasterGrid_id).jqGrid('getRowData', id);
				_sid[i] = eval("row."+$(MasterGrid_id).attr("key"));
			}
		} else {
			myalert("請先勾選資料列");
		}
		if( gr != null ) {
			//alert(_sid.join(","));
			var category = _sid.join(",");
			var sidx = $(MasterGrid_id).jqGrid('getGridParam','sortname'); // 排序的欄名 
			var sord = $(MasterGrid_id).jqGrid('getGridParam','sortorder'); // 排序是升冪或降冪 
			var page = $(MasterGrid_id).jqGrid('getGridParam','page'); //取得目前頁碼 
			var rows = 999999;//$(MasterGrid_id).jqGrid('getGridParam','rowNum'); //要求的列數 
			/*
			var senddata = "_event=print" + mdstr[num] + //dynamic PK			
					"&sidx="+ sidx +
					"&sord="+ sord +
					"&page="+ page +
					"&rows="+ rows +
					"&_pk=" + category; //dynamic PK with category
			*/	
			if (!isBlank(myJoins[num])) {
				for (i in myJoins[num]) {
					if ($("#DetailGrid"+i).length > 0  && !isEmpty(myJoins[num][i])) {
						setPdf($(MasterGrid_id),$("#DetailGrid"+i),category);
					};
				};
			} else {
				setPdf($(MasterGrid_id),null,category);
			}
		} else {
			myalert("請先選取一列資料列。");
		}
	}, 
	loadError : function(xhr,st,err) { 
		$("#spaMsg").text("Type: "+st+"; Response: "+ xhr.status + " "+xhr.statusText);
	},	
	position:"last"
	});

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
var DetailGrid_id = "#DetailGrid"+num;
if ($(DetailGrid_id).length > 0) {
	dstr[num]= "&"+"_sql="   + $(DetailGrid_id).attr("sql")   + "&" +	
		"_db="    + $(DetailGrid_id).attr("db")    + "&" +
		"_table=" + $(DetailGrid_id).attr("table") + "&" +
		"_name="  + $(DetailGrid_id).attr("name")  + "&" +			
		"_field=" + $(DetailGrid_id).attr("field") + "&" +
		"_key="   + $(DetailGrid_id).attr("key")   + "&" +
		"_value=" + $(DetailGrid_id).attr("value") + "&" +
	//同名不能送	"_pk="    + $(DetailGrid_id).attr("pk")    + "&" +
		"_where=" + $(DetailGrid_id).attr("where") + "&" +
		"_id="    + $(DetailGrid_id).attr("id");

	var myName = $(DetailGrid_id).attr("title").split(",");
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
        url: baseURL + "/index/testsql" + "?MASTERtype='DETAIL'&" + dstr[num],
		editurl: baseURL + 	"/index/sql" + "?" +
			+ "_event='DetailGrid:jqGrid_edit"        + "'&" + 
			"_type="  + $(DetailGrid_id).attr("type")  + "&" +
			"_sql="   + $(DetailGrid_id).attr("sql")   + "&" +	
			"_db="    + $(DetailGrid_id).attr("db")    + "&" +
			"_table=" + $(DetailGrid_id).attr("table") + "&" +
			"_name="  + $(DetailGrid_id).attr("name")  + "&" +			
			"_field=" + $(DetailGrid_id).attr("field") + "&" +
			"_key="   + $(DetailGrid_id).attr("key")   + "&" +
			"_value=" + $(DetailGrid_id).attr("value") + "&" +
			"_where=" + $(DetailGrid_id).attr("where") + "&" +
			"_pk="    + $(DetailGrid_id).attr("pk")   + "&" +
			"_id="    + $(DetailGrid_id).attr("id") 
		,	
		datatype: "json",
        colNames: mycolNames,  
        colModel: mycolModels,
		cmTemplate: {editable:true},
		pager: '#dpager'+num, 
		rowNum: 5,  
		rowList:[5,10,20,50,100,200,500,1000,5000], // 每頁顯示筆數
		sortname: $(DetailGrid_id).attr("key"), 
		sortorder: 'asc', 
		caption: $(DetailGrid_id).attr("value"), 
		height: 'auto',  // Grid高度
		width: 'auto', 
		
		autowidth: true,// 自動欄寬
		multiselect: true,  // 顯示勾選框
		viewrecords: true,
		rownumbers: true,		
		altRows: true,		
		enableClear:true,
		gridview: true
    }).navGrid('#dpager'+num,{
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
	}, // view options,
	{
	} // refresh options
	);
}	
}; //myDetail Function


var jj = 0 ;
while (jj < maxGridNum) {
	if ($("#DetailGrid"+jj).length == 0 ) {
		break;
	} else {
	myDetail(jj);
	}
	jj++;
}
}; //myMaster Function

var ii = 0 ;
while (ii < maxGridNum) {
	if ($("#MasterGrid"+ii).length == 0 ) {
		break;
	} else {
	myMaster(ii);
	}
	ii++;
}
}); //Doc ready
