$(document).ready(function(){
  $(function () {
    $( "#popup" ).dialog({
      modal: true,
	  width:'auto',
      buttons: {	  
		'½T©w': function(){
		  $.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			data: 
			$(this).find('form').serialize(),
			beforeSend:function(xhr, s) {
			  //alert(s.data);
			},
			success: function(data){
			//alert(data);
			//var data = JSON.parse(data);
			  if (data != 1) {
				$('#message').text(data);
			  } else {
				 window.location = baseURL + "/exam/index/home";
			  }
			  $(this).dialog('close');
			}
		  });
		},
        '¨ú®ø': function() {
          $( this ).dialog( "close" );
        }
      }
    });
  });
};  