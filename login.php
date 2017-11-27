<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
include_once 'checkuser/check_user.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="">
    <title>Login to admin panel</title>
    <link href="styles/app.css" rel="stylesheet">
    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php if (login_check($mysqli) == true) : ?>
                        <li class="dropdown">
                            <a href="#">
                                 <?php echo $_SESSION['username']; ?>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="includes/logout.php">
                                Logout
                            </a>
                        </li>
                    <?php else : ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login
                        <?php
                        if (isset($_GET['error'])) {
                            echo '<p class="error">Error Logging In!</p>';
                        }
                        ?></div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="includes/process_login.php" name="login_form">

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <input type="button"
                                           value="Login"
                                           onclick="formhash(this.form, this.form.password);" class="btn btn-primary" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
