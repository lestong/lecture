var Login = function() {
	//错误显示设置
	var alert = function(msg){
		setting = {
			life : 2000,
		}
		$.notific8('zindex', 11500);
		$.notific8($.trim(msg), setting);
	}
    var handleLogin = function() {

        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                username: {
                    required: "Username is required."
                },
                password: {
                    required: "Password is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
				$('.alert-danger', $('.login-form')).hide();
				$.ajax({
					type: "post",
					url: Think_ajax_handleLoginN,
					dataType: 'JSON',
					data: $('.login-form').serializeArray(),
					success: function (data) {
						if (data.flag){
							location.href = "/index.php";
						}else{
							if(data.errorCode+'' === '999'){
								// $(".login_error").text("系统异常，请重试").hide().fadeIn();
								window.location.reload();
							} else if(data.errorCode+'' === '111') {
								alert("验证码错误，请重新填写");
							} else if(data.errorCode+'' === '-3') {
								alert("该用户被禁用");
							} else if(data.errorCode+'' === '-2') {
								alert("用户名不存在");
							} else if(data.errorCode+'' === '-4') {
								alert("密码错误");
							} else if(data.errorCode+'' === '-5') {
								alert("班级被禁用");
							} else {
								alert("用户名或密码错误");
							}
						}
					},
					error: function(){
						$(".login_error").text("系统异常，请稍后").hide().fadeIn();
					}
				});
                //form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }
	
	

    var handleForgetPassword = function() {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                email: {
                    required: "Email is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        $('.forget-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        jQuery('#forget-password').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

    }

    var handleRegister = function() {

        function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }

        if (jQuery().select2) {
	        $("#select2_sample4").select2({
	            placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
	            allowClear: true,
	            formatResult: format,
	            formatSelection: format,
	            escapeMarkup: function(m) {
	                return m;
	            }
	        });


	        $('#select2_sample4').change(function() {
	            $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
	        });
    	}

        $('.register-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                loginname: {
                    required: true,
					remote: {
						type:"POST",
						url: Think_ajax_handleVerifyUsernameOnRegister,             //servlet
						data:{
							loginname:function(){return $("#register_loginname").val();}
						} 
					}
                },
                password: {
                    required: true,
					rangelength:[6,16] 
                },
                rpassword: {
                    required: true,
                    equalTo: "#register_password",
					rangelength:[6,16],
                },
                real_name: {
                    required: true,
                },
                classid: {
                    required: true
                },
            },

            messages: { // custom messages for radio buttons and checkboxes
				loginname: {
					remote : '该用户名已被注册'
				}
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
                    error.insertAfter($('#register_tnc_error'));
                } else if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {
				$.ajax({
					type: "post",
					url: Think_ajax_handleRegister,
					mode:"abort",
					dataType: 'JSON',
					data: $('.register-form').serializeArray(),
					error: function () {
						return false;
					},
					beforeSend: function(data) {
						// $(".login_btn").html("注&nbsp;&nbsp;册&nbsp;&nbsp;中").removeClass('submit');
					},
					success: function (data) {
						if(data){
							if (data.flag){
								alert("注册成功,等待管理员激活账号");
								setTimeout(function(){
									location.href = "/index.php";
								}, 2000);
								
							}else{
								if (data.errorCode == 111) {
									$(".register_error").text("验证码错误，请重新填写").css("display","block");
								}
								behaviorWarpper(1,register_authCodeGen);
							}

						} else {
							alert("服务器繁忙，请重试");
						}

					}
				});
                //form.submit();
            }
        });

        $('.register-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.register-form').validate().form()) {
                    //$('.register-form').submit();
                }
                return false;
            }
        });

        jQuery('#register-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.register-form').show();
        });

        jQuery('#register-back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.register-form').hide();
        });
    }

    return {
        //main function to initiate the module
        init: function() {

            handleLogin();
            handleForgetPassword();
            handleRegister();

        }

    };

}();