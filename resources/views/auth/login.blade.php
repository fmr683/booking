<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DATA BANQUET HALL</title>
        
        <!-- Vendor CSS -->
        <link href="vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
            
        <!-- CSS -->
        <link href="css/app.min.1.css" rel="stylesheet">
        <link href="css/app.min.2.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/custom-style.css">
    </head>
    
    <body class="login-content">

   

        <!-- Login -->
        <div class="lc-block toggled" id="l-login">
            
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                 {{ csrf_field() }}


                    <div align="center" class="login-company-logo">
                        <img class="pickme-logo"  src="/img/logo.jpg">
                    </div>

                    <div class="input-group m-b-20">
                        <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                        <div class="fg-line">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                        </div>
                         @if ($errors->has('email'))
                         <span class="has-error"><small class="help-block">{{ $errors->first('email') }}</small></span>
                        @endif
                    </div>
                    
                    <div class="input-group m-b-20">
                        <span class="input-group-addon"><i class="zmdi zmdi-male"></i></span>
                        <div class="fg-line">
                            <input id="password" type="password" class="form-control" name="password"  placeholder="Password" required>
                        </div>

                        @if ($errors->has('password'))
                            <span class="has-error"> <small class="help-block">{{ $errors->first('password') }}</small></span>
                        @endif
                    </div>
                    
                    <div class="clearfix"></div>
                    
                   <!-- <div class="checkbox">
                        <label>
                            <input type="checkbox" value="">
                            <i class="input-helper"></i>
                            Keep me signed in
                        </label>
                    </div>

                     <a class="btn btn-link" href="{{ route('password.request') }}">
                        Forgot Your Password?
                     </a>     -->
                     
                   <button type="submit" class="btn btn-login btn-danger btn-float login-button waves-effect waves-circle waves-float"><i class="zmdi zmdi-arrow-forward"></i></button>
            </form>
        </div>
        
      
        <!-- Javascript Libraries -->
        <script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        
        <script src="vendors/bower_components/Waves/dist/waves.min.js"></script>
        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
        
        <script src="js/functions.js"></script>
        
    </body>
</html>