<?php

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$time = time();
$ip = get_client_ip();

$b_user = $mysqli->prepare("SELECT * 
                                  FROM block_users 
                                  WHERE ip = ? AND time >= '$time'");
$b_user->bind_param('s', $ip);
$b_user->execute();
$get_user = $b_user->get_result();
$get_user = $get_user->fetch_assoc();
$b_user->close();
if($get_user){
$have_time = $get_user['time'] - time();
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome</title>
        <meta http-equiv="Refresh" content="2; url=https://www.google.com/">
        <link href="styles/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <script src="js/bootstrap.js"></script>
    </head>
    <body>
    <div class="container">
        <div class="row">
            <div class="alert alert-danger text-center">
                <h2>Vi v bloke, cherez <?=$have_time?> sec vash login razblokiruetsa</h2>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php die; } ?>