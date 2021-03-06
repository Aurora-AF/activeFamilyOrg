<?php
/**
 * Created by PhpStorm.
 * User: Tefo
 * Date: 26/04/2016
 * Time: 3:22 PM
 */
include_once("analyticstracking.php");
session_start();
//$user_id = $_SESSION['user_session'];
$user_id = (isset($_SESSION['user_session']) ? $_SESSION['user_session'] : null); //get the user id if the user not login then set it to null
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";    //select the details about the user based on the user_id
$_SESSION['url'] = $_SERVER['REQUEST_URI']; //store the previous page url
require_once("../user/class.user.php");
$login = new USER(); //create a new user object
$stmt = $login->runQuery($sql); //run the select query to select the user info
$stmt->execute(array(":user_id"=>$user_id));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
if($login->is_loggedin()) : ?>
    <style type="text/css">
        #register {
            display: none;
        }
        #info{
            display: none;
        }
    </style>

<?php else: ?>

    <style type="text/css">
        #notlogedin {
            display: none;
        }
        #create {
            pointer-events: none;
            cursor: default;
            background-color: grey;
        }
    </style>
<?php endif; ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title><?php echo $title; ?></title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../favicon.ico">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,900,900italic,300italic,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700,300,100' rel='stylesheet' type='text/css'>
    <!-- Global CSS -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="../assets/plugins/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/plugins/flexslider/flexslider.css">
    <link rel="stylesheet" href="../assets/css/timefile.css">
    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="../map/assets/css/styles.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <script src="//fast.eager.io/MqcyGoWLl1.js"></script>
    <![endif]-->
