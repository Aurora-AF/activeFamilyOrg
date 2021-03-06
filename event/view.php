<style>
    #map, #pano {
        float: left;
        height: 50%;
        width: 100%;
    }
</style>
<?php
include('../include/eventpath.php');
include('../include/config.php');



$eventId = $_GET['eventId'];

/* Execute a prepared statement by passing an array of values */

$stmt=$pdo->prepare('select * from events where eventId= ?');

$stmt->execute(array($eventId));
$list = $stmt->fetch(PDO::FETCH_ASSOC);
$address = $list['address']; //get the address of the event
$type = $list['type']; //get the type of the event
$day1 = date('d', strtotime($list['date'])); //get the day of the event
$day = date('D', strtotime($list['date'])); //get the date of the event
$month = date('M', strtotime($list['date']));   //get the month of the event

//set the google map api url
$url = "https://maps.googleapis.com/maps/api/geocode/json?address='$address'&sensor=true";
//set the format of the usl
$url = str_replace(' ', '%20', $url);
//get the response from google
$json = file_get_contents($url);
//decode the json response
$data = json_decode($json);

$lat = $data->results['0']->geometry->location->lat;
$lng = $data->results['0']->geometry->location->lng;
$title=$list['eventName'];
 ?>


<?php 

include('../include/header.php');
include('../include/navigation.php');

?>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '564570863724922',
            xfbml      : true,
            version    : 'v2.6'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<div
    class="fb-like"
    data-share="true"
    data-width="450"
    data-show-faces="true">
</div>

   <h2>
       Event Details
       <div class="form-group" style="float: right">
           <button type="submit" name="btn-login" class="btn btn-primary btn-lg" onclick="direct()">
               Venue Info
           </button>
       </div>

   </h2>
<br>
<div class="row">
    <div class="col-md-5">
        <dl>
            <dt><?php echo "Event title:"; ?></dt>
            <dd>
                <?php echo $list['eventName']; ?>
            </dd>
            <dt><?php echo "Description:"; ?></dt>
            <dd>
                <?php echo $list['eventDescription']; ?>
                &nbsp;
            </dd>
            <dt><?php echo "Category:"; ?></dt>
            <dd>
                <?php echo $list['type']; ?>
                &nbsp;
            </dd>
            <dt><?php echo "Location:"; ?></dt>
            <dd>
                <?php echo $list['address']; ?>
                &nbsp;
            </dd>
            <dt><?php echo "Suburb:"; ?></dt>
            <dd>
                <?php echo $list['suburb']; ?>
                &nbsp;
            </dd>
            <dt><?php echo "Capacity:"; ?></dt>
            <dd>
                <?php echo $list['capacity']; ?>
                &nbsp;
            </dd>
            <dt><?php echo "Time:"; ?></dt>
            <dd>
                <?php echo date('G:i', strtotime($list['date'])); ?>
                &nbsp;
            </dd>
        </dl>
        <time style="float: left" datetime="<?php echo $date?>" class="icon">
            <em><?php echo $day?></em>
            <strong><?php echo $month?></strong>
            <span><?php echo $day1?></span>
        </time>
    </div>
    <div class="col-md-7">
        <div id="map"></div>
    </div>
</div>
<div class="form-group">
    <button type="goBack" name="btn-login" class="btn btn-primary btn-lg" onclick="window.history.go(-1);">
        <i class="glyphicon glyphicon-circle-arrow-left"></i> &nbsp; Back
    </button>
</div>
<br/>
    <form action="" method="post">
    <td class="form-group">
        <?php
        $eventId = $list['eventId'];
        $curr_capa = $list['curr_capa'];
        $capacity = $list['capacity'];
        if(isset($_POST['btn-join']) && $curr_capa < $capacity) {
            $sql1 = "INSERT INTO eventParticipant VALUES ($eventId, $user_id)";
            $resp1 = $pdo->exec($sql1);
            if($resp1) {
                $sql2 = "UPDATE events SET curr_capa = curr_capa + 1 WHERE eventId = $eventId";
                $resp2 = $pdo->exec($sql2);
                if($resp2) {
                    echo '<script type="text/javascript">alert("Successfully Join!");</script>';
                }
            }
            else {
                echo '<script type="text/javascript">alert("Already Joined!");</script>';
            }
        }
        if(isset($_POST['btn-join']) && $curr_capa >= $capacity) {
            echo '<script type="text/javascript">alert("This event is full!");</script>';
        }
        ?>
    </td>
    </form>
    </div>

</section>
<?php

include('../include/footer.php');

?>

<!-- Javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/plugins/back-to-top.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-placeholder/jquery.placeholder.js"></script>
<script type="text/javascript" src="assets/plugins/FitVids/jquery.fitvids.js"></script>
<script type="text/javascript" src="assets/plugins/flexslider/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="assets/js/main.js"></script>

<script type="text/javascript">
    function direct() {
        var lat = <?php echo $lat?>;
        var lng = <?php echo $lng?>;
        var category = '<?php echo $type?>';
        window.location.href = '../map/info.php?lat=' + lat + '&lng=' + lng + '&cata=' + category;
    }
</script>
<script type="text/javascript">
    function initialize() {
        var fenway = {lat: <?php echo $lat?>, lng: <?php echo $lng?>};
        var map = new google.maps.Map(document.getElementById('map'), {
            center: fenway,
            zoom: 14
        });
        var marker = new google.maps.Marker({
            position: fenway,
            map: map,
            icon:"http://maps.google.com/mapfiles/ms/icons/green-dot.png"
        });
//        var panorama = new google.maps.StreetViewPanorama(
//            document.getElementById('pano'), {
//                position: fenway,
//                pov: {
//                    heading: 34,
//                    pitch: 10
//                }
//            });
        //map.setStreetView(panorama);
    }
</script>

<!-- Vimeo video API -->
<script src="http://a.vimeocdn.com/js/froogaloop2.min.js"></script>
<script type="text/javascript" src="assets/js/vimeo.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKWfGBpeBLZ2vVsvEeFdJrOEkVH7sE9Uk&callback=initialize">
</script>
</body>
</html>

