<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
    <head>
        <title>Kritish | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Kritish Admin Panel"/>
        <meta name="author" content="Prateek Mathapati"/>  
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- Bootstrap Core CSS -->
        <link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <!-- Custom CSS -->
        <link href="../css/style.css" rel='stylesheet' type='text/css' />
        <link href="../css/font-awesome.css" rel="stylesheet"> 
        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>
        <!----webfonts--->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
        <!---//webfonts--->  
        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>
    </head>
    <body id="login">
        <div class="login-logo">
            <a href="index.html"><img src="../images/logos/kritish-logo.png" width="100" alt=""/></a>
        </div>
        <h2 class="form-heading">kritish admin panel</h2>
        <div class="app-cam">
            <form role="form" method="POST" action="{{ url('/admin/login') }}">
                {!! csrf_field() !!}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input name="email" type="text" class="text" placeholder="E-mail Address" value="{{ old('email') }}" onblur="if (this.value == '') {
                            this.value = 'E-mail address';
                        }">
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input name="password" type="password" placeholder="Password" value="Password" onblur="if (this.value == '') {
                            this.value = 'Password';
                        }">       
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif  
                </div>
                <div class="submit"><input type="submit" onclick="myFunction()" value="Login"></div>
                <!-- <div class="login-social-link">
          <a href="index.html" class="facebook">
              Facebook
          </a>
          <a href="index.html" class="twitter">
              Twitter
          </a>
        </div>
                <ul class="new">
                        <li class="new_left"><p><a href="#">Forgot Password ?</a></p></li>
                        <li class="new_right"><p class="sign">New here ?<a href="register.html"> Sign Up</a></p></li>
                        <div class="clearfix"></div>
                </ul> -->
            </form>
        </div>
        <div class="copy_layout login">
            <p>Copyright &copy; 2016 Kritish. All Rights Reserved</p>
        </div>
    </body>
</html>
