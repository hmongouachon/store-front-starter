jQuery( 'document' ).ready( function( $ ) {
	var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    var ananas_form = $('#ananas-form');
    var single = $('.single-product');
	if(ananas_form.length){
		ananas_form.on('click touch', 'input[type="submit"]', function(e) {
		    e.preventDefault();
			var ananas_like = ananas_form.find('input[name="ananas-like"]:checked').val();
			var content = ananas_form.find('textarea').val();
			var formData = {
		        'action':'user_extra_fields',
			    'ananas_like' : ananas_like,
			    'ananas_content' : content
			}
			$.ajax({
			    url: baseUrl+'/wp-admin/admin-ajax.php',
		        type: 'POST',
		        data: formData,
		        success:function(data) {
		            alert(data);
		            console.log("success!");
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		            console.log("fail");
		        }
			});
		});
	}
	if(single.length){
		single.on('click touch', '.call-ip', function(e) {
		    e.preventDefault();
		    var $this = $(this);
		    $.getJSON("https://api.ipify.org?format=jsonp&callback=?",
		      function(json) {
		      	$this.next().html('<p style="margin-top:5px">My public IP address is:<strong>'+ json.ip + '</strong></p>');
		      }
		    );
		});
	}
});