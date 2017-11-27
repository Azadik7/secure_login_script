<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
include_once 'checkuser/check_user.php';

if (login_check($mysqli) == true) {
    if($_POST['name'] && $_POST['last_name'] && $_POST['price'] && $_POST['date'] || $_POST['description']){
        $name       = $_POST['name'];
        $last_name  = $_POST['last_name'];
        $price      = $_POST['price'];
        $date       = $_POST['date'];
        $description = $_POST['description'];
        $id         = $_POST['id'];
        $usd = $price;
        $azn = grab_valyuta($date, $usd);

        $update = $mysqli->prepare("UPDATE clients SET price_usa = ?, price_azn = ?, name = ?, last_name = ?, description = ?, date = ?  WHERE id= ? ");
        $update->bind_param("iissssi", $usd, $azn, $name, $last_name, $description, $date, $id );
        $update->execute();
        header("Location: ../edit.php?id=".$id);
        $update->close();
    }
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
    <link rel="stylesheet" href="styles/jquery-ui.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <style>
        .error { color: red; }
    </style>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker();
        } );
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
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

    <?php if ( login_check($mysqli) == true ) : ?>
        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $data = $mysqli->prepare("SELECT * FROM clients WHERE id=$id");
                $data->execute();
                $result = $data->get_result();
                $row = $result->fetch_assoc();
            }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading"><a href="/protected_page.php" title="Edit list">List</a> </div>

                        <div class="panel-body">

                            <form action="/edit.php" method="post">
                                <div class="form-group">
                                    <label for="name">Ad:</label>
                                    <input name="name" type="text" class="form-control" id="name" value="<?=$row['name']?>">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Soyad:</label>
                                    <input name="last_name" type="text" class="form-control" id="last_name"  value="<?=$row['last_name']?>">
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="price">Qiymət $:</label>
                                        <input name="price" type="number" class="form-control" id="price"  value="<?=$row['price_usa']?>">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label>Qiymət azn:</label>
                                        <input class="form-control" value="<?=$row['price_azn']?>" disabled="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="datepicker">Date:</label>
                                    <input name="date" type="text" class="form-control" id="datepicker" value="<?=$row['date']?>">
                                </div>

                                <div class="form-group">
                                    <label for="description">Qeyd:</label>
                                    <textarea name="description" class="form-control" rows="5" id="description"><?=$row['description']?></textarea>
                                </div>

                                <input type="hidden" name="id" value="<?=$row['id']?>">
                                <button type="submit" class="btn btn-default">Update</button>
                            </form>
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

