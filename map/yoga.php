<?php
include("../include/mapPath.php");
//$_SESSION['url'] = $_SERVER['REQUEST_URI'];
include('../include/header.php');?>

<script src="//fast.eager.io/WCgAF8HnKW.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
    $('.selectpicker').selectpicker({
        style: 'btn-info',
        size: 4
    });
</script>
<?php
include('../include/navigation.php');

?>
<!--Template from: http://derekeder.com/searchable_map_template-->
<!--Php can get latitude and longitude of category from previous map-->

<?php
$user_id = (isset($_SESSION['user_session']) ? $_SESSION['user_session'] : null);

$stmt = $login->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));

$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>


            <div class='container-fluid'>
    <div class='row'>
        <div class='col-md-4'>

            <div class='well'>
                <h1 class="title">
                    Yoga
                                    </h1>
                <div class="btn-group">
                    <button class="btn btn-defult dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pick a Category
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a onclick="updateBasketball()">Basketball</a></li>
                        <li><a onclick="updateBBQ()" >BBQ</a></li>
                        <li><a onclick="updateDog()">Dog Friendly Areas</a></li>
                        <li><a onclick="updateSwim()">Swim Pools</a></li>
                        <li><a onclick="updateYoga()">Yoga</a></li>
                    </ul>
                </div>
                <hr>
                <p>
                    <input class='form-control' id='search_address' placeholder='Enter an address or an intersection' type='text' onfocus="document.getElementById('search_address').value=''" onclick="document.getElementById('search_address').value=''" />

                </p>
                <a class='btn btn-primary btn-lg' id='search' href='#'>
                    <i class='glyphicon glyphicon-search'></i>
                    Search
                </a>
                <a id='find_me' href='#' class="btn btn-primary btn-lg">Locate</a>
            <p> <br></p>
                <p>
                    <label>
                <p><b>Please select the Search radius</b></p>

                <select id='search_radius' class="selectpicker" >
                    <option value='400'>2 blocks</option>
                    <option value='500'>1/2 km</option>
                    <option value='1000'>1 km</option>
                    <option value='2000'>2 km</option>
                    <option value='5000' selected="selected">5 km</option>
                </select>
                </label>

                </p>
                </div>
            <div class='alert alert-info' id='result_box' ><strong id='result_count'></strong></div>
            


        </div>
        <div class='col-md-8'>
            <noscript>
                <div class='alert alert-info'>
                    <h4>Your JavaScript is disabled</h4>
                    <p>Please enable JavaScript to view the map.</p>
                </div>
            </noscript>
            <div id='map_canvas'></div>

        </div>
    </div>
</div>

<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery.address.js"></script>
<script type="text/javascript" src="js/bootstrap.min.map.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKWfGBpeBLZ2vVsvEeFdJrOEkVH7sE9Uk&libraries=places"></script>
<script type="text/javascript" src="js/maps_lib.js"></script>
<script type='text/javascript'>
    //<![CDATA[
    $(window).resize(function () {
        var h = 650,
            offsetTop = 105;// Calculate the top offset
        $('#map_canvas').css('height', (h - offsetTop));
    }).resize();

    $(function() {
        var myMap = new MapsLib({
            fusionTableId:      "18NjJhapsdfaQ_ZN0QgcKMASRGF7LrR6upyvxMdFA",
            googleApiKey:       "AIzaSyAKWfGBpeBLZ2vVsvEeFdJrOEkVH7sE9Uk",
            locationColumn:     "Location",
            map_center:         [-37.8141,144.9633]

        });
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('search_address'));

        $(':checkbox').click(function(){
            myMap.doSearch();
        });

        $(':radio').click(function(){
            myMap.doSearch();
        });

        $('#search_radius').change(function(){
            myMap.doSearch();
        });

        $('#search').click(function(){
            myMap.doSearch();
        });

        $('#find_me').click(function(){
            myMap.findMe();
            return false;
        });

        $('#reset').click(function(){
            myMap.reset();
            return false;
        });

        $(":text").keydown(function(e){
            var key =  e.keyCode ? e.keyCode : e.which;
            if(key === 13) {
                $('#search').click();
                return false;
            }
        });
    });
    //]]>
</script>

        </div><!--//container-->        
    </section><!--//steps-->

<?php

include('../include/footer.php')

?>

<script type="text/javascript" src="assets/plugins/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="assets/plugins/back-to-top.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-placeholder/jquery.placeholder.js"></script>
<script type="text/javascript" src="assets/plugins/FitVids/jquery.fitvids.js"></script>
<script type="text/javascript" src="assets/plugins/flexslider/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="assets/js/main.js"></script>
<script type="text/javascript">
    // Parse the URL
    //
    function updateBasketball(){
        var txtOne = document.getElementById('search_address').value;
        var txtTwo = document.getElementById('search_radius').value;

        window.location.href = "basketball.php#/?address=" + txtOne + "&radius=" + txtTwo;
    }
    function updateBBQ(){
        var txtOne = document.getElementById('search_address').value;
        var txtTwo = document.getElementById('search_radius').value;

        window.location.href = "bbq.php#/?address=" + txtOne + "&radius=" + txtTwo;
    }
    function updateDog(){
        var txtOne = document.getElementById('search_address').value;
        var txtTwo = document.getElementById('search_radius').value;

        window.location.href = "dog.php#/?address=" + txtOne + "&radius=" + txtTwo;
    }
    function updateSwim(){
        var txtOne = document.getElementById('search_address').value;
        var txtTwo = document.getElementById('search_radius').value;

        window.location.href = "swim.php#/?address=" + txtOne + "&radius=" + txtTwo;
    }
    function updateYoga(){
        var txtOne = document.getElementById('search_address').value;
        var txtTwo = document.getElementById('search_radius').value;

        window.location.href = "yoga.php#/?address=" + txtOne + "&radius=" + txtTwo;
    }
</script>
            
</body>
</html> 

