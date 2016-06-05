var ProfileValidation = function () {

	//错误显示设置
	var alert = function(msg){
		setting = {
			life : 2000,
		}
		$.notific8('zindex', 11500);
		$.notific8($.trim(msg), setting);
	}
    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_info');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    real_name: {
                        minlength: 2,
                        required: true
                    },
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success1.hide();
                    error1.show();
                    Metronic.scrollTo(error1, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {
					$("#btn_submit_info").attr("disabled", true); 
					$.ajax({
						type: "post",
						url: Think_ajax_handleInfo,
						dataType: 'JSON',
						data: form1.serializeArray(),
						success: function (data) {
							if (data.flag){
								alert("修改成功");
							}else{
								alert("请联系管理员");
							}
						},
						error: function(){
							alert("系统异常，请稍后");
						}
					});
					setTimeout(function(){$("#btn_submit_info").attr("disabled", false);}, 1000);
					 return;
                }
            });


    }

    // validation using icons
    var handleValidation2 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form2 = $('#form_password');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);
			jQuery.validator.addMethod("regexPassword", function(value, element) {       
					return this.optional(element) || /^[^\s]+$/.test(value);  
					}, "不能包含空格");   

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    password: {
                        minlength: 6,
                        required: true,
						/* remote: {
							type:"POST",
							url: Think_ajax_handleVerifyPassword,             //servlet
							data:{
								password:function(){return $("#password").val();}
							} 
						} */
                    },
                    new_password: {
                        minlength: 6,
						regexPassword: true,
                        required: true,
                    },
                    new_password_confirm: {
                        minlength: 6,
                        required: true,
						equalTo: "#new_password"
                    },
					
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success2.hide();
                    error2.show();
                    Metronic.scrollTo(error2, -200);
                },
				
                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    $("#btn_submit_password").attr("disabled", true); 
					$.ajax({
						type: "post",
						url: Think_ajax_handleChangePassword,
						dataType: 'JSON',
						data: form2.serializeArray(),
						success: function (data) {
							if (data.flag){
								form2[0].reset();
								alert("修改成功");
							}else{
								alert(data.msg);
							}
						},
						error: function(){
							alert("系统异常，请稍后");
						}
					});
					setTimeout(function(){$("#btn_submit_password").attr("disabled", false);}, 1000);
					return;
                }
            });


    }
    // validation using icons
    var handleValidation3 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form3 = $('#form_weike');
            var error2 = $('.alert-danger', form3);
            var success2 = $('.alert-success', form3);
			jQuery.validator.addMethod("regexPassword", function(value, element) {       
					return this.optional(element) || /^[^\s]+$/.test(value);  
					}, "不能包含空格");   

            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    username: {
                        minlength: 6,
                    },
					
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success2.hide();
                    error2.show();
                    Metronic.scrollTo(error2, -200);
                },
				
                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    $("#btn_submit_weike").attr("disabled", true); 
					$.ajax({
						type: "post",
						url: Think_ajax_handleWeike,
						dataType: 'JSON',
						data: form3.serializeArray(),
						success: function (data) {
							if (data.flag){
								alert("修改成功");
							}else{
								form3[0].reset();
								alert(data.msg);
							}
						},
						error: function(){
							form3[0].reset();
							alert("系统异常，请稍后");
						}
					});
					setTimeout(function(){$("#btn_submit_weike").attr("disabled", false);}, 1000);
					return;
                }
            });


    }


    return {
        //main function to initiate the module
        init: function () {

            handleValidation1();
            handleValidation2();
            handleValidation3();

        }

    };

}();