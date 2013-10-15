treeview = function(tData, container)
{
  this.build = function(nodeInfo)
  {
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
function effect(container) {
//1.節點格式
//"節點A": {'title': "節點標題",'items': {"節點說明": "節點內容"}}
//2. 同層節點插在同層'items': {之後,下層節點插在下層'items': {之後,
//3. 記得需要時要在子節點A前加逗號!
//同層第一個節點不要加逗點
/*
data = 
{'title' : 'Fruit','items' : {
	'Apple節點':{'title' : 'Apple','items' : {
		'Red Apple節點':{'title' : 'Red Apple','items' : {
		'Red Apple說明':'Red Apple內容'}}
		}},
	'Banana節點':{'title' : 'Banana','items' : {
		'Long Banan節點':{'title' : 'Long Banan','items' : {
		'Long Banan說明':'Long Banan內容'}}
		}}
}}
;
*/
/*
		  var data = {
		  'title': "根節點標題",
		  'items': {
			
			"無內容之節點": {
			  'title': "子節點A",
			  'items': {
						"子節點B": {
						  'title': "子節點B標題",
						  'items': {
							"子節點B說明": "子節點內容"
							}
						}				
				}
			},
			
			"兄弟節點a加於同層後(記得需要時要在子節點A前加逗號)": {
			  'title': "兄弟節點a標題",
			  'items': {
				"兄弟節點說明": "兄弟節點內容,可再包子節點"
			  }
			},
			
			"兄弟節點b加於同層後(記得需要時要在子節點b前加逗號)": {
			  'title': "兄弟節點b標題",
			  'items': {
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
	$('div#title_1').load(function () {
		$.ajax({
		  type: "POST",
		  url: "sql.php",
		  dataType: "html",
		  data:
			{
			event:'div#title_1:load',
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

	
	$('.image_class').toggle(
	function () {
	  $(this).animate({ 
		width: "100%",
		opacity: 1,
		//marginLeft: "0.6in",
		fontSize: "3em", 
		borderWidth: "10px"
	  }, 1000 );
	},
	function () {
	  $(this).animate({ 
		width: "50%",
		opacity: 1,
		//marginLeft: "0.6in",
		fontSize: "3em", 
		borderWidth: "10px"
	  }, 200 );	
	});
	
	/*
	$('.select_item').mouseout(function () {
		$(this).css("background-color","red");
	});
	*/		
	
}
$(document).ready(function() {
/*
	$.ajax({
	  url: 'ui.php',         
	  cache: false,         
	  dataType: 'json',             
	  type:'POST',
	  data:
		{
		event:'document:ready',		
		type:$('#JQTreeview').attr("type"),
		sql:$('#JQTreeview').attr("sql"),
		db:$('#JQTreeview').attr("db"),
		table:$('#JQTreeview').attr("table"),
		name:$('#JQTreeview').attr("name"),		
		field:$('#JQTreeview').attr("field"),
		key:$('#JQTreeview').attr("key"),
		value:$('#JQTreeview').val(),
		id:$('#JQTreeview').attr("id")},
	  error: function(xhr) {
		alert('資料表supervisor欄位設定從屬關係時發生錯誤'+xhr.responseText);
	  },
	  success:
		function(data) {
			tView = effect(new treeview(data, $('#JQTreeview')));
		}
		
	  });
	  */

    $('#JQTreeview').fadeIn(3000);
	timer('行動APP',131*24*60*60-3666);
	timer('雲端軟體',46*24*60*60-66);
	timer('音樂創作',86*24*60*60-1999);
	timer('第一階段旅遊報導',38*24*60*60-1440);
	timer('第二階段旅遊報導',79*24*60*60-1440);
	timer('第三階段旅遊報導',120*24*60*60-1440);
	timer('第四階段旅遊報導',161*24*60*60-1440);
	timer('MOD互動微電影',80*24*60*60-599);
	$('.database').click(function () {
	$.ajax({
	  type: "POST",
	  url: "http://www.localhost.com/cc/sql.php",
	  dataType: "html",
	  data:
		{
		event:'datbase:click',
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
	  error: function(msg){
		alert("Error"+JSON.stringify(msg));
	  },
	  success: function(result){
		var return1 = result.return1;
		var return2 = result.return2;
		alert(JSON.stringify(result));
		// return1 and return2 is value from php file.
		// fill out DOM element or do the windows.location()
	  
		//  if (msg !="1") {
		//	alert( "Error for Data Saved: " + msg );
		//  }
	  }
	});
	});
	
  
});
function timer(id,sec) {
	var note = $('#note'),
	ts = new Date(2013, 0, 1),
	newYear = true;
	
	if((new Date()) > ts){
		// The new year is here! Count towards something else.
		// Notice the *1000 at the end - time must be in milliseconds
		ts = (new Date()).getTime() + sec*1000;//10*24*60*60*1000;
		newYear = false;
	}
		
	$('#countdown').countdown({
		timestamp	: ts,
		callback	: function(days, hours, minutes, seconds){
			
			var message = "";
			
			days!=0?message += days + " 天":"" ;
			hours!=0?message += hours + "小時":"" ;
			minutes!=0?message += minutes + " 分":"";
			seconds!=0?message += seconds + " 秒":"";
			
			$('#'+id).val(message);
			var remainder = days*24*60*60 + hours*60*60 + minutes*60 + seconds;

			if (days==0 & hours==0 & minutes ==0 & seconds==0) {
				$('#timer').val("報名時間結束!");
				$('#timer').css("background-color","red");
				$('#timer').css("color","white");
				$('#timer').css("opacity","1");
   			    $('#JQTreeview').fadeOut(3000);
				setInterval(0);
			};
		}
	});
};
