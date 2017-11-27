<?php
session_start();
include_once 'includes/db_connect.php';
include_once 'checkuser/check_user.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>

    <link href="styles/bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="styles/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker();
        } );
    </script>
</head>
<body>
<div class="container">
    <div class="row">
        <br>
        <div class="col-md-6 col-md-offset-3  col-sm-12">
            <form action="add.php" method="post">
                <div class="form-group">
                    <label for="name">Ad <sup><small class="error">*</small></sup> <sub><?php if($_GET['name'] == 1) {  echo '<span class="error">\'Ad\' can not be empty</span>'; } ?></sub></label>
                    <input name="name" type="text" class="form-control" id="name" value="<?php if($_GET['name'] == true && $_GET['name'] != 1 ){ echo $_GET['name']; } ?>">
                </div>
                <div class="form-group">
                    <label for="last_name">Soyad <sup><small class="error">*</small></sup> <sub><?php if($_GET['last_name'] == 1){ echo '<span class="error">\'Soyad\' can not not be empty</span>'; } ?></sub></label>
                    <input name="last_name" type="text" class="form-control" id="last_name" value="<?php if($_GET['last_name'] == true && $_GET['last_name'] != 1){ echo $_GET['last_name']; } ?>">
                </div>

                <div class="form-group">
                    <label for="price">Qiymət <sup><small class="error">*</small></sup> <sub><?php if( $_GET['price'] == 'a'){ echo '<span class="error">\'Qiymət\' can not not be empty</span>'; } ?></sub></label>
                    <input name="price" type="number" class="form-control" id="price" value="<?php if($_GET['price'] == true && $_GET['price'] != 'a'){ echo $_GET['price']; } ?>">
                </div>

                <div class="form-group">
                    <label for="datepicker">Date <sup><small class="error">*</small></sup> <sub><?php if( $_GET['date'] == 1){ echo '<span class="error">\'Date\' can not not be empty</span>'; } ?></sub></label>
                    <input name="date" type="text" class="form-control" id="datepicker" value="<?php if($_GET['date'] == true && $_GET['date'] != 1){ echo $_GET['date']; } ?>">
                </div>

                <div class="form-group">
                    <label for="description">Qeyd:</label>
                    <textarea name="description" class="form-control" rows="5" id="description"><?php if($_GET['description'] == true){ echo $_GET['description']; } ?></textarea>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<?php if(isset($_SESSION['data'])){ ?>
<div class="modal fade in" id="myModal" role="dialog" style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?=$_SESSION['data']['name']?> <?=$_SESSION['data']['last_name']?></h4>
            </div>
            <div class="modal-body">
                <p>Tarix: <?=$_SESSION['data']['date']?></p>
                <p>Azn: <?=$_SESSION['data']['price_azn']?></p>
                <p>USD: <?=$_SESSION['data']['price_usa']?></p>
                <p>Qeyd: <?=$_SESSION['data']['description']?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="win">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade in"></div>
<?php unset($_SESSION['data']); ?>
<?php } ?>
<script>
    $('#win, .close').click(function () {
        document.querySelector('.in').remove();
        document.querySelector('.modal-backdrop').remove();
    });
</script>
</body>
</html>