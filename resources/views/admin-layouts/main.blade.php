<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="{{asset('public/favicon.ico')}}">
        @yield('headers')
        <script type="text/javascript">
            var base_url = '<?php echo URL::to('/'); ?>';
        </script>
    </head>
    <body>
        @include('admin-layouts.header')
        <section>
            @include('admin-layouts.sidebar')
            <div class="mainpanel">
                @yield('content')
            </div><!-- mainpanel -->
        </section>
    </body>
    <script>
        $(document).ready(function () {
            $.validator.addMethod('phonenumber', function (value) {
                if(value){
                return value.match(/([0-9]{9})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})/);
            }
            else{
                return true;
            }
            }, "Please enter a valid contact number.");
        });
        $('#OpenImgUpload').click(function () {
            $('#imgupload').trigger('click');
        });
        $("#imgupload").change(function () {
            readURL(this);
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#OpenImgUpload').attr('src', e.target.result);
                    $('#coverImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('#userFormInput').validate({
            rules: {
                user_email: {
                    email: true
                },
                user_contact_no: {
                    phonenumber: true
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });
        function getUserProfileData(id) {
            $.ajax({
                type: 'get',
                url: base_url + '/admin/user/' + id + '/edit',
                cache: false,
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    if (result.response) {
                        $('#user_id').val(result.data.id);
                        $('#user_first_name').val(result.data.first_name);
                        $('#user_last_name').val(result.data.last_name);
                        $('#user_email').val(result.data.email);
                        $('#user_contact_no').val(result.data.contact_no);
                        $('#OpenImgUpload').attr("src", base_url + "/public/images/users/" + result.data.user_image);
                        $('#coverImage').attr("src", base_url + "/public/images/users/" + result.data.user_image);
                        $('#user_image_name').val(result.data.user_image);
                    }
                }
            });
        }
        function userProfileUpdate() {
            if ($("#userFormInput").valid()) {
                var inputFile = $('input[name=imgupload]');
                var fd = new FormData();
                var file_data = inputFile[0].files[0];
                fd.append('image', file_data);
                fd.append('user_id', $('#user_id').val());
                fd.append('first_name', $('#user_first_name').val());
                fd.append('last_name', $('#user_last_name').val());
                fd.append('email', $('#user_email').val());
                fd.append('contact_no', $('#user_contact_no').val());
                fd.append('image_name', $('#user_image_name').val());


                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('._token').val()
                    },
                    type: 'post',
                    url: base_url + '/admin/user/profile_update',
                    cache: false,
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (json) {
                        var result = jQuery.parseJSON(json);
                        if (result.response) {
                            $('#userModal').modal('hide');
                            $('#sidebar_user_image').attr("src", base_url + "/public/images/users/" + result.data.user_image);
                            $('#sidebar_name').text(result.data.first_name+" "+result.data.last_name);
                            $('#header_user_image').attr("src", base_url + "/public/images/users/" + result.data.user_image);
                            $('#header_name').text(result.data.first_name+" "+result.data.last_name);
                            $('#sidebar_email').text(result.data.email);
                            $('#sidebar_contact_no').text(result.data.contact_no);
                            $.gritter.add({
                                title: 'Success',
                                text: 'User Updated Successfully.',
                                class_name: 'with-icon check-circle success'
                            });
                        }
                    }
                });
            }
        }
        $('#userFormPasswordChange').validate({
            rules: {
                old_password: {
                    required: true,
                    remote: {
                        url: base_url + "/admin/user/password_check",
                        type: "get",
                     
                        data: {
                            user_id: function () {
                                return $("#user_id").val();
                            }
                        }

                    }
                },
                confim_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#new_password"
                },
                new_password: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                old_password: {
                    remote: "Password is wrong"
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });
        function passwordChange() {
            if ($('#userFormPasswordChange').valid()) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('._token').val()
                    },
                    type: 'post',
                    url: base_url + '/admin/user/password_change',
                    cache: false,
                    data: {user_id:$('#user_id').val(),
                        old_password:$('#old_password').val(),
                        new_password:$('#new_password').val()
                    },
                    success: function (json) {
                        var result = jQuery.parseJSON(json);
                        if (result.response) {
                            $('#userModal').modal('hide');
                            $.gritter.add({
                                title: 'Success',
                                text: 'Password changed Successfully.',
                                class_name: 'with-icon check-circle success'
                            });
                        }
                        else{
                            $.gritter.add({
                                title: 'This is a error notice',
                                text: 'Please check old password.',
                                class_name: 'with-icon check-circle danger'
                            });
                            
                        }
                    }
                });

            }
        }
    </script>
</html>
