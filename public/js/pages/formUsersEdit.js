var FormUsersEdit = function () {

    return {
        init: function () {


            if($("#category_id").val() == 3){
                $("#student_form_div_id").show();
            }else if($("#category_id").val() == 2){
                $("#professor_form_div_id").show();
            }

            $("#category_id").change(function (){
                if($(this).val()  == 3){
                    $("#student_form_div_id").show();
                    $("#professor_form_div_id").hide();
                }else if($(this).val() == 2){
                    $("#student_form_div_id").hide();
                    $("#professor_form_div_id").show();
                }else{
                    $("#student_form_div_id").hide();
                    $("#professor_form_div_id").hide();
                }

            });

            $(document).ready(function () {
                $('#edit_user_form_id').validate({
                    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                    errorElement: 'div',
                    errorPlacement: function (error, e) {
                        e.parents('.form-group > div').append(error);
                    },
                    highlight: function (e) {
                        $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.help-block').remove();
                    },
                    success: function (e) {
                        if (e.closest('.form-group').find('.help-block').length === 2) {
                            e.closest('.help-block').remove();
                        } else {
                            e.closest('.form-group').removeClass('has-success has-error');
                            e.closest('.help-block').remove();
                        }
                    },
                    rules: {
                        'username': {
                            required: true,
                            minlength: 2
                        },
                        'display_name': {
                            required: true,
                            minlength: 2
                        },
                        'email': {
                            required: true,
                            email: true
                        },
                    },
                    messages: {
                        'username': {
                            required: 'Please enter your username',
                            minlength: 'Please enter your username'
                        },
                        'display_name': {
                            required: 'Please enter your display name',
                            minlength: 'Please enter your display name'
                        },
                        'email': 'Please enter a valid email address'
                    },
                    submitHandler: function (form) {
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            dataType: 'json',
                            data: $(form).serialize(),
                            success: function (response) {
                                if(response.success){
                                    window.location = "/users";
                                }else{
                                    alert('erroare');
                                }
                            }
                        });
                    }
                });
            });
        }
    };
}();/**
 * Created by Pavlik on 2016-04-22.
 */
