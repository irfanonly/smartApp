           $(document).ready(function () {
                $('#pre-loader').hide();
                $('#formInput').validate({
                    rules: {
                        email: {
                            email: true
                        },
                        contact_no: {
                            phonenumber: true
                        }
                    },
                    highlight: function (element) {
                        $(element).closest('.field').removeClass('has-success').addClass('has-error');
                    },
                    success: function (element) {
                        $(element).closest('.field').removeClass('has-error');
                    }
                });
                $.validator.addMethod('phonenumber', function (value) {
                    if (value) {
                        return value.match(/([0-9]{9})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})/);
                    }
                    else {
                        return true;
                    }
                }, "Please enter a valid contact number.");

            });
            function request() {
                if ($("#formInput").valid()) {
                    $('#request-btn').prop('disabled', true);
                    $('#li-btn').show();
                    $.ajax({
                        type: 'post',
                        url: base_url + '/request_service',
                        cache: false,
                        data: {id: $('#id').val(),
                            full_name: $('#full_name').val(),
                            email: $('#email').val(),
                            contact_no: $('#contact_no').val(),
                            address: $('#address').val(),
                            description: $('#description').val(),
                            latitude: $('#latitude').val(),
                            longitude: $('#longitude').val(),
                            _token: $('#_token').val()},
                        success: function (json) {
                            var result = jQuery.parseJSON(json);

                            if (result.response) {
                                swal("Your request has been received!", "We will contact you as soon as possible !", "success");
                                $('#formInput').trigger("reset");
                                $('#formInput .form-group').removeClass('has-error');
                                $('#formInput .error').remove();
                                $('#request-btn').prop('disabled', false);
                                $('#li-btn').hide();
                            }
                        }
                    });
                }
            }