<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
include_once 'checkuser/check_user.php';

if (login_check($mysqli) == true) {
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $deleting = $mysqli->prepare("DELETE FROM clients WHERE id=$id");
        $deleting->execute();
        $deleting->close();
    }
} else {
    $logged = 'out';
}
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
                            <a href="#" class="dropdown-toggle">
                                <?php echo $_SESSION['username']; ?>
                            </a>
                        </li>
                        <li>
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

    <?php if ( login_check($mysqli) == true ) : ?>
        <?php
        $result = $mysqli->prepare("Select * from clients  ORDER BY id DESC");
        $result->execute();
        $result = $result->get_result();
        ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">List</div>

                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Full name</th>
                                <th>Date</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?=$row['name']?> <?=$row['last_name']?> </td>
                                    <td><?=$row['date']?></td>
                                    <td>
                                        <a href="edit.php?id=<?=$row['id']?>" class="btn btn-info btn-sm" > Edit </a>
                                        <a href="protected_page.php?delete=<?=$row['id']?>" class="btn btn-warning btn-sm" onclick="return confirm('Silmeye eminsiniz?');"> Delete </a>
                                    </td>
                                </tr>
                            <?php } $result->close(); ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else : ?>
        <div class="container">
            <div class="row">
                <div class="alert alert-danger">
                    <h>Ne pitaytes zayti v sistemu, v protivnom sluchae mi vas zablokiruem na veki vechnie! </span> Pojaluysta vernites nazad <a href="login.php">Login</a></h>
                </div>
            </div>
        </div>
   <?php endif; ?>
</div>
</body>
</html>

