$(document).ready(function(){
	/* This code is executed after the DOM has been completely loaded */

	/* Changing thedefault easing effect - will affect the slideUp/slideDown methods: */
	$.easing.def = "easeOutBounce";

	/* Binding a click event handler to the links: */
	$('li.button a').click(function(e){
	
		/* Finding the drop down list that corresponds to the current section: */
		var dropDown = $(this).parent().next();
		
		/* Closing all other drop down sections, except the current one */
		$('.dropdown').not(dropDown).slideUp('slow');
		dropDown.slideToggle('slow');
		
		/* Preventing the default event (which would be to navigate the browser to the link's address) */
		e.preventDefault();
	});

$(function () {
    $( "#popup" ).dialog({
      modal: true,
	  width:'auto',
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
				$('#message').text(data.text);
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
  });



  
});