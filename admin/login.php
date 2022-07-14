<?php
session_start();
	
if(isset($_SESSION['user_id'])){
  if (trim($_SESSION['user_id']) != ''){
    header("location: index.php");
    exit();
  }
}

if(isset($_POST)){
  unset($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CLHear TApp | Log in</title>

    <!-- Facebook meta tags -->
  <meta property="og:title" content="CLHear TApp | Login" />
    <meta property="og:url" content="https://kierasis.me/tanauan/admin/login.php" />
    <meta property="og:image" content="https://kierasis.me/tanauan/image/og_fb.png" />
    <meta property="og:description" content="Welcome to Cultural Heritage Mapping and Tourism App Website." />

    <!-- Twitter meta tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="CLHear TApp | Login" />
    <meta name="twitter:description" content="Welcome to Cultural Heritage Mapping and Tourism App Website." />
    <meta name="twitter:image" content="https://kierasis.me/tanauan/image/og_fb.png" />


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>CLHear </b>TApp</a>
            </div>
            <div class="card-body">
                <p id="head_desc" class="login-box-msg">Sign in to start your session</p>

                <form id="loginForm" name="form1" method="post">

                    <div class="form-group">
                        <div class="input-group">
                            <input id="username" name="username" type="text" class="form-control"
                                placeholder="Username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger"><small id="username-error" style="display: none;">Please enter a email
                                address</small></span>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input id="password" name="password" type="password" class="form-control"
                                placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger"><small id="password-error" style="display: none;">Please enter a
                                password</small></span>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button id="butsave" type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.min.js"></script>

    <script>
    $(document).ready(function() {

        $("#username").keydown(function() {
            $("#username").removeClass("is-invalid");
            $("#butsave").removeAttr("disabled");
            $('#username-error').hide();
            $('#username-error').html("");

            $('#head_desc').html("Sign in to start your session");
            $("#head_desc").removeClass("text-danger");
        });
        $("#password").keydown(function() {
            $("#password").removeClass("is-invalid");
            $("#butsave").removeAttr("disabled");
            $('#password-error').hide();
            $('#password-error').html("");

            $('#head_desc').html("Sign in to start your session");
            $("#head_desc").removeClass("text-danger");
        });

        $('#butsave').on('click', function() {
            $("#username").removeClass("is-invalid");
            $("#password").removeClass("is-invalid");
            $("#butsave").attr("disabled", "disabled");
            var username = $('#username').val();
            var password = $('#password').val();
            var remember = $('#remember')[0].checked;

            if (username != "" && password != "") {
                $.ajax({
                    url: "scripts/login.php",
                    type: "POST",
                    data: {
                        'action': 'login',
                        'username': username,
                        'password': password,
                        'remember': remember
                    },
                    cache: false,
                    success: function(dataResult) {
                        var dataResult = JSON.parse(dataResult);
                        if (dataResult.statusCode == 200) {
                            $("#butsave").removeAttr("disabled");
                            const urlParams = new URLSearchParams(window.location.search);
                            const redirect = urlParams.get('redirect');

                            if (!isEmptyOrSpaces(redirect)) {
                                $.ajax({
                                    url: redirect, //or your url
                                    success: function(data) {
                                      location.href = redirect;
                                    },
                                    error: function(data) {
                                      location.href = "index.php";
                                    },
                                })
                            } else {
                                location.href = "index.php";
                            }
                        } else if (dataResult.error == "incorrect") {
                            $("#butsave").removeAttr("disabled");
                            $("#username").addClass("is-invalid");
                            $("#password").addClass("is-invalid");

                            $('#head_desc').html("Incorrect Credentials");
                            $("#head_desc").addClass("text-danger");
                            $('#loginForm').find('input:password').val('');
                        } else if (dataResult.error == "invalid") {
                            var code = dataResult.statusCode;
                            $("#butsave").removeAttr("disabled");
                            if (dataResult.error_username !== undefined) {
                                $("#username").addClass("is-invalid");
                                $('#username-error').show();
                                $('#username-error').html("Contain/s invalid Character");
                            }
                            if (dataResult.error_password !== undefined) {
                                $('#password-error').show();
                                $('#password-error').html("Contain/s invalid Character");
                                $("#password").addClass("is-invalid");
                            }
                            $('#loginForm').find('input:password').val('');

                        } else if (dataResult.error == "other") {
                            var code = dataResult.statusCode;
                            $("#butsave").removeAttr("disabled");
                            $('#loginForm').find('input:text').val('');
                            $('#loginForm').find('input:password').val('');
                        }

                    }
                });
            } else {

                if (username == "") {
                    $('#username-error').show();
                    $("#username").addClass("is-invalid");
                    $('#username-error').html("Enter Username");
                }
                if (password == "") {
                    $('#password-error').show();
                    $("#password").addClass("is-invalid");
                    $('#password-error').html("Enter Password");
                }

            }
        });
    });

    function isEmptyOrSpaces(str) {
        return str === null || str.match(/^ *$/) !== null;
    }
    </script>
</body>

</html>