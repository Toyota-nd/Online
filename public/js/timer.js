/*
	$('#timer').click(function (){
		timer(8);
		$(this).unbind('click');
	});
*/
$("#exitexam").click(function(){
	if($('#JQTreeview').length > 0 ){
		var exampaper_id = $('#exampaper_id').val();
		$('#exitexam').fadeOut(100);
		$('#JQTreeview').fadeOut(500);
		$('#exampaper_id').fadeOut(1000);
		$('#exitexam').unbind('click');
		$('#JQTreeview').unbind('click');
		$('#timer').unbind('click');
		closemark = 1;
		if ( $(this).attr('test') == "true") {
			update('toyota','exampaper','mark','4',exampaper_id);
			$('#timer').val("考試時間結束!");
			$('#timer').css("background-color","red");
		} else {
			update('toyota','exampaper','mark','9',exampaper_id);
			$('#timer').val("模擬考結束!");
			$('#timer').css("background-color","green");
		}
		$('#timer').css("color","white");
		$('#timer').css("opacity","1");
		$('#JQTreeview').fadeOut(3000);
	
	}
})

var closemark = 0;
$("#timer").click(function(){
	$("#timer").animate({ 
	width: "75%",
	opacity: 0.6,
	marginLeft: "0.6in",
	fontSize: "2em", 
	borderWidth: "10px"
	}, 1000 );
	var exampaper_id = $('#exampaper_id').val();
	//$('#exampaper_id option[value='+exampaper_id+']').attr('selected','selected');
	
	$.ajax({
	  type: "POST",
	  //一定要在PHP宣告且指定正確的baseURL
	  url: baseURL + "/index/sql", 
	  data:
		{
		_event:'#timer:click',
		_type:"button",
		_sql:"select",
		_db:"toyota",
		_table:"exampaper",
		_name:"",					
		_field:"limittime,remainder,mark",
		_key:"exampaper_id",
		_value:"0",
		_pk:exampaper_id,
		_id:"timer"
		},
		error: 	function(jqXHR, exception) {
            if (jqXHR.status === 0) {
                alert('Timer.js:Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Timer.js:Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                alert('Timer.js:Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                alert('Timer.js:Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Timer.js:Time out error.');
            } else if (exception === 'abort') {
                alert('Timer.js:Ajax request aborted.');
            } else {
                alert(jqXHR.status +'Timer.js:Uncaught Error.\n' + jqXHR.responseText);
            }
        },
		beforeSend:function(xhr, s) {
		  //alert(s.data);
		},	   		
	  success: function(msg){
		try {
			var data = JSON.parse(msg);
		} catch(e) {
			alert(data.text);
		}
		//alert("狀態為"+data.text.mark);
		if (data.text.mark <= 3) {
		/*
		exam.mark 0:尚在抽題中
		exam.mark 1:製卷中
		exampaper.mark 2:已發卷
		exampaper.mark 3:正在填寫考卷
		exampaper.mark 4:已交卷
		exampaper.mark 5:評分中
		exampaper.mark 6:複查中
		exam.mark 9:評分結案
		*/
			if (data.text.remainder==0) {
				timer(exampaper_id,data.text.limittime,data.text.mark);
			} else {
				timer(exampaper_id,data.text.remainder,data.text.mark);
			};
			var filter = "questions.exampaper_id=" + exampaper_id;
			setjqt(filter);
			$('#JQTreeview').fadeIn(500);
			$('#exitexam').fadeIn(500);
			$('#exampaper_id').fadeOut(1000);
			$('#timer').unbind('click');
			$('#JQTreeview').unbind('click');

			$(document).delegate('.myimage_class', 'click', function (e) {
			   if (this == e.target) {
				  $("#"+ this.id).animate({ 
					width: "350%",
					height: "350%",
				  }, 100 );			   }
			});
			$(document).delegate('.myimage_class', 'dblclick', function (e) {
			   if (this == e.target) {
				  $("#"+ this.id).animate({ 
					width: "100%",
					height: "100%",
				  }, 100 );
			   }
			});			
			
			
		} else {
			$('#timer').val("本次考試已結束!").css("background-color","red");
		} // if mark		
		} //function
		});			
	});	
	
function timer(exampaper_id,sec,mark) {
	var note = $('#note'),
	ts = new Date(2013, 0, 1),
	newYear = true;
	if (mark <= 2) {
		update('toyota','exampaper','mark','3','exampaper_id',exampaper_id);
	}	

	if((new Date()) > ts){
		// The new year is here! Count towards something else.
		// Notice the *1000 at the end - time must be in milliseconds
		ts = (new Date()).getTime() + sec*1000;//10*24*60*60*1000;
		newYear = false;
	}
	$('#countdown').countdown({
		timestamp	: ts,
		callback	: function(days, hours, minutes, seconds){
			if (closemark == 1) {
				setInterval(0);
				window.location.href = baseURL + "/exam/index/home"; 
				alert("考試已結束!");
				return;
			}

			var message = "";
			
			days!=0?message += days + " 天":"" ;
			hours!=0?message += hours + "小時":"" ;
			minutes!=0?message += minutes + " 分":"";
			seconds!=0?message += seconds + " 秒":"";
			
			$('#timer').val("考試剩餘時間:"+message);
			var remainder = days*24*60*60 + hours*60*60 + minutes*60 + seconds;
			//5秒存取資料庫一次
			seconds%5!=0?null:$.ajax({
			  type: "POST",
			  //一定要在PHP宣告且指定正確的baseURL
			  url: baseURL + "/index/sql",
			  dataType:"html",
			  data:
				{
				_event:'#timer:click',
				_type:"button",
				_sql:"update",
				_db:"toyota",
				_table:"exampaper",
				_name:"",					
				_field:"remainder",
				_key:"exampaper_id",
				_value:remainder,
				_pk:exampaper_id,
				_id:"timer"
				},
			  success: function(msg){
				try {
				   var data = JSON.parse(msg);
				} catch(e) {
					alert(msg);
				}
				  if (data.code !="1") {
					if (data.code =="2") {
						var div_id = $('#'+data.id).closest("div").attr("id");
						$('#'+div_id).html(data.text); //要從上一層的DIV取得ID，去取代HTML碼
					}
				  }
			  }
			});	
			if (days==0 & hours==0 & minutes ==5 & seconds==0) {
				alert("考試時間剩最後"+minutes+"分鐘!");
			}; 
			if (days==0 & hours==0 & minutes ==0 & seconds==0) {
			
				$('#timer').css("color","white");
				$('#timer').css("opacity","1");
   			    $('#JQTreeview').fadeOut(3000);
   			    $('#exitexam').fadeOut(500);
				setInterval(0);
				//$('#countdown').countdown('destroy');
				if (mark <= 3) {
					if ( $('#exitexam').attr('test') == "true") {
						update('toyota','exampaper','mark','4','exampaper_id',exampaper_id);
						$('#timer').val("考試時間結束!");
						$('#timer').css("background-color","red");
					} else {
						update('toyota','exampaper','mark','3','exampaper_id',exampaper_id);
						$('#timer').val("本次模擬考時間到!");
						$('#timer').css("background-color","green");
					}
				}
			};
		}
	});
};
