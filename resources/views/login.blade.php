<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!--<link rel="shortcut icon" href="../images/favicon.png" type="image/png">-->

        <title>SmartApp</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="{{asset('public/css/quirk.css')}}">

        <script src="{{asset('public/lib/modernizr/modernizr.js')}}"></script>
            <script type="text/javascript">
            var base_url = '<?php echo URL::to('/'); ?>';
        </script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="../lib/html5shiv/html5shiv.js"></script>
        <script src="../lib/respond/respond.src.js"></script>
        <![endif]-->
    </head>

    <body class="signwrapper">

        <div class="sign-overlay"></div>
        <div class="signpanel"></div>

        <div class="panel signin">
            <div class="panel-heading">
                <h1>SmartApp</h1>
                <h4 class="panel-title">Welcome! Please signin.</h4>
            </div>
            <div class="panel-body">
                <form id="formInput" action="{{URL::to('login/login')}}">
                    <div class="form-group mb10">
                        <div class="input-group col-md-12 col-xs-12 col-sm-12">
              <!--              <span class="input-group-addon">&nbsp;</span>-->
                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Username" required>
                        </div>
                    </div>
                    <div class="form-group nomargin">
                        <div class="input-group col-md-12 col-xs-12 col-sm-12">
              <!--              <span class="input-group-addon">&nbsp;</span>-->
                            <input type="password" name="password" id="password"class="form-control" placeholder="Enter Password" required>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <button type="submit"  onclick="login()" class="btn btn-success btn-quirk btn-block">Sign In</button>
                    </div>
                </form>

            </div>
        </div><!-- panel -->

    </body>
    <script type="text/javascript" src="{{asset('public/lib/jquery/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/lib/jquery-ui/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/lib/jquery-validate/jquery.validate.js')}}"></script>
    <script>
    $('#formInput').validate({
        rules: {
            password: {
                required: true,
                remote: {
                    url: base_url+"/login/user_validation",
                    type: "get",
                    data: {
                        user_name: function () {
                            return $("#user_name").val();
                        }
                    }
                }
            },
            user_name: {
                required: true,
                remote: {
                    url: base_url+"/login/check_username",
                    type: "get",
   
                }
            }
        },
    messages: {
        password: {
            remote: "Incorrect Password"
        },
       user_name: {
            remote: "Invalid username"
        }
    },
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    function login() {
        if ($("#formInput").valid()) {

        }

    }
    </script>   

</html>
