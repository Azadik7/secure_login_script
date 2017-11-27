<?php

include_once 'psl-config.php';

function sec_session_start() {
    $session_name = 'sec_session_id';
    $secure = SECURE;

    // burda  JavaScript ile session id-ye girishi saxlamisham
    $httponly = true;

    // "sessions"-lari cookie istifade etmeye mecbur edir
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }

    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    session_name($session_name);
    session_start();
    session_regenerate_id();
}

function login($email, $password, $mysqli) {
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt 
				  FROM members 
                                  WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();

        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            if (checkbrute($user_id, $mysqli) == true) {
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

                $ip = get_client_ip();
                $block_time = time() + 1800;
                $block = $mysqli->prepare("INSERT INTO block_users ( ip, time  ) VALUES ( ?, ? )");
                $block->bind_param("si", $ip, $block_time );
                $block->execute();
                return false;
            } else {
                if ($db_password == $password) {
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                    return true;
                } else {
                    $now = time();
                    if (!$mysqli->query("INSERT INTO login_attempts(user_id, time) 
                                    VALUES ('$user_id', '$now')")) {
                        header("Location: ../error.php?err=Database error: login_attempts");
                        exit();
                    }
                    return false;
                }
            }
        } else {
            return false;
        }
    } else {
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }
}

function checkbrute($user_id, $mysqli) {
    $now = time();
    $valid_attempts = $now - ( 30 * 60);
    if ($stmt = $mysqli->prepare("SELECT time 
                                  FROM login_attempts 
                                  WHERE user_id = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->store_result();

        // yarim saat erzinde 3 defeden chox sehv girish edilse istifadechi yarim saat bloka salinir
        if ($stmt->num_rows > 3) {
            return true;
        } else {
            return false;
        }
    } else {
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }
}

function login_check($mysqli) {
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        if ($stmt = $mysqli->prepare("SELECT password 
				      FROM members 
				      WHERE id = ? LIMIT 1")) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
                if ($login_check == $login_string) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            header("Location: ../error.php?err=Database error: cannot prepare statement");
            exit();
        }
    } else {
        return false;
    }
}

function grab_valyuta($date, $price){
    $date_arr = explode('/', $date);
    $day = $date_arr[1];
    $moth = $date_arr[0];
    $year = $date_arr[2];
    $data = simplexml_load_file('https://www.cbar.az/currencies/'.$day.'.'.$moth.'.'.$year.'.xml');
    $json = json_encode($data);
    $array = json_decode($json,TRUE);
    $usd = $array["ValType"][1]["Valute"][44]["Value"];
    $azn = $price * $usd;
    return $azn;
}