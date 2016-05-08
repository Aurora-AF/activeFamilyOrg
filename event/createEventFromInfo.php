<?php
include('../include/eventpath.php');
include ('../include/header.php');
include('../include/navigation.php');
include('../include/config.php');
require_once("../user/class.user.php");
$user_id = $_SESSION['user_session'];
$user = new User();

if(isset($_POST['btn-submit'])) {
    $address = $_GET['address'];
    $suburb = $_GET['suburb'];
    $title = (isset($_POST['eTitle']) ? $_POST['eTitle'] : null);
    $desc = (isset($_POST['description']) ? $_POST['description'] : null);
    $curr_capa = 0;
    $status='active';
    $capacity = (isset($_POST['capOption']) ? $_POST['capOption'] : null);
    $date = (isset($_POST['eDate']) ? $_POST['eDate'] : null);
    if (!empty($date)) {
        $date = date('Y-m-d G:i', strtotime($date));
    }
    else {
        $date = null;
    }
    $type = $_GET['cata'];
    if(!empty($title) && !empty($desc) && !empty($capacity) && !empty($date) && !empty($type)) {
        $sql =  "INSERT INTO events (create_user_id, eventName, eventDescription, type, address, suburb, capacity, curr_capa, date, status)
              VALUES (:user_id,:title,:desc,:type,:address,:suburb,:capacity,:curr_capa,:date,:status)";
        $data = array(':user_id'=>"$user_id",':title'=>"$title",':desc'=>"$desc",':type'=>"$type", ':address'=>"$address",':suburb'=>"$suburb",':capacity'=>$capacity, ':curr_capa'=>$curr_capa,':date'=>"$date",':status'=>"$status");
        $stmt = $user->runQuery($sql);
        $stmt->execute($data);

        if($stmt) {
            echo '<script type="text/javascript">
                    alert("Event Successfully Created!!!");
                    window.location.href = "listEvent.php";
                  </script>';
        }
    }

//    $sql ="SELECT eventId FROM events WHERE eventName = :title_name";
//    $data = array(':title_name'=>"$title");
//    $stmt = $user->runQuery($sql);
//    $stmt->execute($data);
//
//    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
//    $event_id = $userRow['eventId'];
//    $data=array(':event_id'=>$event_id,':user_id'=>$user_id);
//    $sql = "INSERT INTO eventParticipant (eventId,user_id) VALUES (:event_id, :user_id)";
//    $stmt = $user->runQuery($sql);
//    $stmt->execute($data);

}


?>
<link rel="stylesheet" href="style.css" type="text/css"  />


<script src="js/jquery.js"></script>


<form class="form-signin" method="post" id="login-form">
    <h2 class="form-signin-heading">Create Your Event</h2><hr />
    <?php
    if(isset($error))
    {
        foreach($error as $error)
        {
            ?>
            <div class="alert alert-danger">
                <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
            </div>
            <?php
        }
    }
    ?>
    <div class="form-group">
        Title<span>*</span>
        <input type="text" class="form-control" name="eTitle" placeholder="Event Title" required />
        <span id="check-e"></span>
    </div>

    <div class="form-group">
        Description<span>*</span><br>
            <textarea rows="5" cols="52" id="description" name="description" style="border-color: lightgray;" autofocus required></textarea>
        <span id="check-e"></span>
    </div>
    <div class="form-group">
        Hold Date<span>*</span>
        <input id="datetimepicker" type="text" class="form-control" name="eDate" id="eDate" required />
        <span id="check-e"></span>
    </div>
    <div class="form-group">
        Capacity<span>*</span>
<!--        <input class="form-control" placeholder="Please Insert Integer" type="text" name="capOption" id="capOption" style="ime-mode:disabled" onKeyUp="this.value=this.value.replace(/[^\.\d]/g,'');this.value=this.value.replace('.','');"  required />-->
        <input class="form-control" placeholder="Please Insert Integer" type="text" name="capOption" id="capOption" type="text" onblur="checkInt(this.value,100);" required/>

        <span id="check-e"></span>
    </div>
    <div class="form-group">
<!--        Capacity<span>*</span>-->
<!--        <label>-->
<!--            <select name="capOption" size="0" id="eType" style="width: 7em" required>-->
<!--                <option selected="selected" value="">Number</option>-->
<!--                <option>5</option>-->
<!--                <option>10</option>-->
<!--                <option>15</option>-->
<!--                <option>20</option>-->
<!--            </select>-->
<!--        </label>-->
<!--        <span id="check-e"></span>-->
<!--        Categories<span>*</span>-->
<!--        <label>-->
<!--            <select name="taskOption" size="0" id="eType" style="width: 10em" required>-->
<!--                <option selected="selected" value="">All Activities</option>-->
<!--                <option>BBQ</option>-->
<!--                <option>Walking Dog</option>-->
<!--                <option>Yoga</option>-->
<!--                <option>Sports Club</option>-->
<!--                <option>Basketball</option>-->
<!--            </select>-->
<!--        </label>-->
    </div>
    <hr />
    <div class="form-group">
        <button type="submit" name="btn-submit" class="btn btn-primary btn-lg">
            <i class="glyphicon glyphicon-log-in"></i>&nbsp; Submit
        </button>
    </div>
    <br />
</form>
</section>
<script>$(document).ready(function() {$('#datetimepicker').datetimepicker();});  </script>

<?php include('../include/footer.php'); ?>
</body>
<link rel="stylesheet" type="text/css" href="datetimepicker-master/jquery.datetimepicker.css"/ >
<script src="datetimepicker-master/jquery.js"></script>
<script src="datetimepicker-master/build/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/plugins/back-to-top.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-placeholder/jquery.placeholder.js"></script>
<script type="text/javascript" src="assets/plugins/FitVids/jquery.fitvids.js"></script>
<script type="text/javascript" src="assets/plugins/flexslider/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="assets/js/main.js"></script>

<script>
    function checkInt(n,max){
        var regex = /^\d+$/;
        if(regex.test(n)){
            if(n<max && n>0){
            }else{
                alert("Please insert number less than"+max)
            }
        }else{
            alert("It is not integer");
        }
    }
</script>



</html>


