function get_data() {
    $.ajax({
        url: "http://zend/pavel/select.php", method: "GET", success: function (data) {
            $('#live_data').html(data);
        }
    });
}

function openEdit(id){
    var firstname = $("#firstname" + id).html();
    var lastname = $("#lastname" + id).html();
    var age = $("#age" + id).html();
    var email = $("#email" + id).html();
    var password = $("#password" + id).html();
    $("#id-edit").val(id);
    $("#firstname-edit").val(firstname);
    $("#lastname-edit").val(lastname);
    $("#age-edit").val(age);
    $("#email-edit").val(email);
    $("#password-edit").val(password);
    $("#live_data").fadeOut("fast", function(){
        $("#add_btn").hide();
        $("#close_edit_btn").show();
        $("#form-edit").fadeIn("fast");
    });

}

function deleteUser(id){
    $.ajax({
        url: "http://zend/pavel/delete.php",
        method: "POST",
        dataType: 'json',
        data: {id:id},
        success: function (data) {
            get_data();
        }
    });
}

var FormValidate = function () {

    return {
        init: function () {
            get_data();
            $("#add_btn").click(function (){
                $("#live_data").fadeOut("fast", function(){
                    $("#add_btn").hide();
                    $("#close_btn").show();
                    $("#form-add").fadeIn("fast");
                });
            });
            $("#close_btn").click(function (){
                $("#form-add").fadeOut("fast", function(){
                    $("#close_btn").hide();
                    $("#add_btn").show();
                    $("#live_data").fadeIn("fast");
                });
            });
            $("#close_edit_btn").click(function(){
                $("#form-edit").fadeOut("fast", function(){
                    $("#close_edit_btn").hide();
                    $("#add_btn").show();
                    $("#live_data").fadeIn("fast");
                });
            });


            $('#form-add').validate({
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
                    'firstname': {
                        required: true,
                    },
                    'lastname': {
                        required: true,
                    },
                    'age': {
                        required: true,
                    },
                    'email': {
                        required: true,
                        email:true
                    },
                    'password': {
                        required: true,
                    },
                },
                messages: {
                    'firstname': {
                        required: 'Please enter firstname',
                    },
                    'lastname': {
                        required: 'Please enter lastname',
                    },
                    'age': 'Please enter age',
                    'email': 'Please enter email',
                    'password': 'Please enter password'
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        dataType: 'json',
                        data: $(form).serialize(),
                        success: function (response) {
                            $("#form-add").trigger("reset");
                            $("#form-add").fadeOut("fast", function(){
                                $("#close_btn").hide();
                                $("#add_btn").show();
                                $("#live_data").fadeIn("fast");
                                get_data();
                            });
                        }
                    });
                }
            });
            $('#form-edit').validate({
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
                    'firstname': {
                        required: true,
                    },
                    'lastname': {
                        required: true,
                    },
                    'age': {
                        required: true,
                    },
                    'email': {
                        required: true,
                        email:true
                    },
                    'password': {
                        required: true,
                    },
                },
                messages: {
                    'firstname': {
                        required: 'Please enter firstname',
                    },
                    'lastname': {
                        required: 'Please enter lastname',
                    },
                    'age': 'Please enter age',
                    'email': 'Please enter email',
                    'password': 'Please enter password'
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        dataType: 'json',
                        data: $(form).serialize(),
                        success: function (response) {
                            $("#form-edit").trigger("reset");
                            $("#form-edit").fadeOut("fast", function(){
                                $("#close_edit_btn").hide();
                                $("#add_btn").show();
                                $("#live_data").fadeIn("fast");
                                get_data();
                            });
                        }
                    });
                }
            });
        }
    };
}();
/**
 * Created by Pavlik on 2016-04-22.
 */
