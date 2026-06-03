	<!-- Footer -->
	<div class="footer text-muted">
	    &copy; <?php echo date('Y'); ?>. All Rights Reserved - <b>EchoGram </b> <br />
	
	</div>

	<!-- /footer -->

	<script>
	
		var current_url = "<?php $uri = service('uri');
	    echo $uri->getSegment(2); ?>";
		
		if((localStorage.getItem('cat_id') != "") && (current_url == 'manage_menu')){
			$(".product_category").addClass('active');
		}else{
			localStorage.setItem('cat_id',"");
			$("."+current_url).addClass('active');
		}
		
		function accept_decimal(evt)
		{
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode != 46 && charCode > 31 
			&& (charCode < 48 || charCode > 57))
				return false;

			return true;
		}

		function accept_number(evt)
		{
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode < 48 || charCode > 57)
				return false;

			return true;
		}

		function accept_alphanumeric(evt){
			var k;
			document.all ? k=evt.keycode : k=evt.which;
			return((k>47 && k<58)||(k>64 && k<91)||(k>96 && k<123)|| k == 32 ||k==0);
		}

		function accept_alphanumeric1(evt) 
		{
		    var k;
		    document.all ? k = evt.keyCode : k = evt.which;
		    
		    // Allow digits (0-9), uppercase letters (A-Z), lowercase letters (a-z), space (32), underscore (_), and backspace (0)
		    return ( (k > 47 && k < 58) || (k > 64 && k < 91) || (k > 96 && k < 123) || k === 32 || k === 95 || k === 0 );
		}


		function accept_onlyalpha(evt){
			var k;
			document.all ? k=evt.keycode : k=evt.which;
			return((k>64 && k<91)||(k>96 && k<123)|| k == 32);
		}

		<?php if (session()->get('user_role') == 1) { ?>
        	getNotification();
			setInterval(function () {
				getNotification();
				get_new_order();
			}, 10000);

			var timeout;
			document.onmousemove = function(){
				clearTimeout(timeout);
				timeout = setTimeout(function(){ $("#mouse_move_flag").val(""); }, 5000);
			}
	
			$("body").mouseenter(function () {
				$("#mouse_move_flag").val("11");
				var myVideo = document.getElementById('MyAudio2');
				myVideo.pause();
			});

			$("body").mouseleave(function () {
				$("#mouse_move_flag").val("");
			});

			$("body").mousemove(function () {
				$("#mouse_move_flag").val("11");
				var myVideo = document.getElementById('MyAudio2');
				myVideo.pause();
			});

			$("body").keypress(function () {
				$("#mouse_move_flag").val("11");
				var myVideo = document.getElementById('MyAudio2');
				myVideo.pause();
			});
			
			jQuery(document).on('click','#play_btn',function(f){
				var myVideo = document.getElementById('MyAudio');
				myVideo.play();
			});

			jQuery(document).on('click','#play_btn1',function(f){
				var myVideo = document.getElementById('MyAudio2');
				myVideo.play();
			});
			
		<?php } ?>
		function get_new_order() 
		{
			$.ajax({
	            url: "<?php echo base_url(route_to('get_new_order')); ?>",
	            type: "POST",
	            dataType: "json",
	            success: function(resp) {
					if(resp != ""){
						var last_id=$('#last_id').val();
						var content = '';
						var id = resp.response.id;
						
						if (last_id!=id) 
						{
							$("#last_id").val(id);
							if (last_id!=0) 
							{
								$.jGrowl({
									header: "New Order Received OrderID #"+id,
									theme: 'bg-success'
								});	

								var mouse_move_flag = $("#mouse_move_flag").val();

								if(mouse_move_flag == "")
									$('#play_btn1').trigger('click');
								else
									$('#play_btn').trigger('click');
							}
						}
                    }
				}
	        });
		}

	   

	    function getNotification() {
	        $.ajax({
	            url: "<?php echo base_url(route_to('getNewNotification')); ?>",
	            type: "POST",
	            dataType: "json",
	            success: function(resp) {

                    var content = '';
                    $("#show_new_notification").html("");
	                if (resp.total_notification != 0) {
	                	
                        $("#total_new_notification").html(resp.total_notification);
                        var notification = resp.response;
                        //  console.log(notification);
                        content += '<ul class="media-list dropdown-content-body">';
                        for(var i=0;i<notification.length;i++)
                        {
							if(notification[i]['status'] == 0)
							{
								var noti_msg = "New order arrived  #"+notification[i]['id'];
							    //alert(noti_msg);
							}
							else if(notification[i]['status'] == 6)
							{
								var noti_msg = "Order cancelled by customer #"+notification[i]['id'];
								// alert(noti_msg);
							}
							
                            content += '<li class="media"><div class="media-left"><i class="icon-cart2 img-circle img-sm pt-10" style="background-color:#d2d1d1"></i></div><div class="media-body"><a href="<?php echo base_url('restaurant/order_info'); ?>/'+notification[i]['id']+'" class="media-heading"><span class="text-semibold">#Order Id '+notification[i]['id']+'</span><span class="media-annotation pull-right">'+notification[i]['modified_date']+'</span> </a><span class="text-muted">'+noti_msg+'</span></div></li>';   
                        }
                        content += '</ul>';
	                } else {
                        $("#total_new_notification").html("0");
	                    content = '<div class="dropdown-content-heading">No new messages available</div>';
	                }

					//$("#my_audio")[0].play();
                    $("#show_new_notification").append(content);

	            }
	        });
	    }
		
		/* var flag_main = false;
		window.addEventListener("mousemove",function(){	
			if(flag_main == false){
				setTimeout(function(){
					console.log("call");
					$("#play-btn").trigger('click');
					flag_main = true;
				},20000);
			}				
		}); */

        $('#mark_as_read').on('click',function(){
            $.ajax({
	            url: "<?php echo base_url(route_to('mark_as_read')); ?>",
	            type: "POST",
	            dataType: "json",
	            success: function(resp) {
	                if (resp == <?php echo SUCCESS_CODE; ?>) {
                        getNotification();
	                } else {
	                    
	                }
	            }
	        });
        });

	</script>

	<?php echo $this->renderSection('content'); ?>
