<?php
    error_reporting(E_ERROR | E_PARSE);

    include_once "../res/util/enums.php";
    include_once "../res/util/jwt.php";
    include("../res/util/helper.php");

    // Parse settings and initialize global Jobjects
    $data = parse_ini_file("../res/util/settings.ini");

    // Used for: creation, verification and decoding of tokens
    $jwt = new JWT($data["signKey"], $data["signAlgorithm"], $data["payloadSecret"], $data["payloadCipher"]);
  
    // Used for: global ENUMS
    $ENUMS = new ENUMS();

    if (!checkLogin()) {
        header("Location: ../account/login.php");
    }

    $id = $_GET["id"];

    if (empty($id)) {
        header("Location: ./viewall.php");
    }

    $data = array(
        "pid" => $id,
        "requesterid" => $_SESSION["uid"]
    );

    $token = $jwt->generateToken($data);
    $token = json_encode(array("token" => $token));

    $url = "http://u747950311.hostingerapp.com/househub/api/listings/retrieve.php";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $token);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    if ($result === false) {
        die("internal application error " . $result);
    }

    $result_d = json_decode($result, true);
    if ($result_d["status"] == "error") {
        die($result);
    }

    $token = $result_d["message"];
    if ($jwt->verifyToken($token) === false) {
        die("");
    }

    $payload = json_decode($jwt->decodePayload($token), true);

    if ($payload["total_listings"] != 1) {
        header("Location: ./viewall.php");
    }

    $listing = $payload["listings"][0];

    $contactURL = 'mailto:' . $listing['creator_email'] . '?subject=I am interested in your property!&body=Hey ' . $listing['creator_fname'] . ',%0AI saw your property listed on HouseHub as ' . $listing['title'] . ' and would love to learn more.%0APlease let me know if this property is still available!%0A%0A Thanks!';

    $savedImageURL = "http://u747950311.hostingerapp.com/househub/site/res/img/" . (($listing["saved"] == "1") ? "heart_full" : "heart_outline") . ".svg";

    $isOwner = ($_SESSION["uid"] == $listing["creator_uid"]);
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="http://u747950311.hostingerapp.com/househub/site/res/css/bootstrap.min.css">
        <link rel="apple-touch-icon" sizes="57x57" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//favicon-16x16.png">
        <link rel="manifest" href="http://u747950311.hostingerapp.com/househub/site/res/img/icon//manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="http://u747950311.hostingerapp.com/househub/site/res/img/icon//ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <style>
            .card-horizontal {
                display: flex;
                flex: 1 1 auto;
            }

            .card-img {
                width: 14rem;
                height: 184.4px;
            }

            .carousel-control-prev-icon {
                background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%2000' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
            }

            .carousel-control-next-icon {
                background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%2000' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
            }

            .carousel .carousel-indicators li {
                background-color: #fff;
                background-color: rgba(70, 70, 70, 0.25);
            }

            .carousel .carousel-indicators .active {
                background-color: #444;
            }

            .carousel-img {
                max-height: 360px;
            }

            .location-map {
                width: 100%;
                max-height: 350px;
            }

            h4.card-title {
                margin-top: 12px;
            }

            .saveUnsaveListing {
                width: 32px;
                height: 32px;
            }

            .saveUnsaveListing {
                height: 32px;
                width: 32px;

                background: transparent;
                border: none !important;
            }
        </style>

        <title>HouseHub | View Listings</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">
                <img src="http://u747950311.hostingerapp.com/househub/site/res/img/hh-icon.png" height="35" width="35" alt="">
            </a>
            <a class="navbar-brand" href="#">HouseHub</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                            
                <ul class="navbar-nav ml-auto justify-content-end">
                  <li class="nav-item">
                    <a class="nav-link active" href="./viewall.php">View Listings</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="./create.php">Post Listing</a>
                  </li>
                  <li class="nav-item btn-group">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">My Account</a>
                    
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="../account/update.php">Update Information</a>
                      <a class="dropdown-item" href="../account/logout.php">Logout</a>
                    </div>
                  </li>
                </ul>
            </div>

        </nav>

       <div class="container-fluid" style="height: calc(100vh - 91.5px - 56px); margin-top: 30px;">
            <div class="row h-100">
                <div class="card offset-sm-1 col-md-2 col-sm-10 align-self-center w-100" style="border: none;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">$<? echo $listing["base_price"]; ?>/month + <? echo $listing["add_price"]; ?></li>
                        <li class="list-group-item">Posted by <a href='../account/view.php?id=<? echo $listing["creator_uid"]; ?>' class='userLink'><? echo $listing["creator_fname"] . " " . $listing["creator_lname"]; ?></a></li>
                        <li class="list-group-item">Created on <? echo date_format(date_create($listing["created"]), "n/j/y"); ?></li>
                        <a href="<? echo $contactURL; ?>" target="_blank" class="list-group-item list-group-item-action">Contact subleasor</a>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between h-100">
                                <button class="saveUnsaveListing <? echo ($listing["saved"] == "saved" ? "saved" : ''); ?> " pid="<? echo $listing["pid"]; ?>">
                                    <img class='m-auto' src="<? echo $savedImageURL; ?>" width="20" />
                                </button>

                                <? if ($listing["hidden"] == 1) { ?>
                                    <span class='badge badge-secondary align-self-center' style='height: 20px;'>Hidden</span>
                                <? } ?>
                            </div>
                        </li>
                        <? if ($isOwner) { ?>
                            <a href="./update.php?id=<? echo $listing['pid']; ?>" target="_self" class="list-group-item list-group-item-action">Modify Listing</a>
                        <? } ?>
                    </ul>
                </div>

                <div class="card col-md-7 offset-sm-1 col-sm-10 align-self-center h-100" style="overflow-y: auto; border: none;">
                    <div class="row">
                        <div class="col-12 mat-3">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class='card-title'><? echo $listing["title"] ?></h2>
                                    
                                    <div id="listingImages" class="carousel slide" data-ride="carousel">
                                      <ol class="carousel-indicators">
                                        <?
                                            for ($i = 0; $i < $listing["num_pictures"]; $i++) {
                                                echo "<li class='" . ($i == 0 ? "active" : "") . "' data-target='#listingImages' data-slide-to='" . $i . "'></li>";
                                            }
                                        ?>
                                      </ol>
                                      <div class="carousel-inner">
                                        <?
                                            $pid = $listing["pid"];
                                            for ($i = 0; $i < $listing["num_pictures"]; $i++) {
                                                $url = "http://u747950311.hostingerapp.com/househub/api/images/" . $pid . "/" . $listing["images"][$i];

                                                echo "<div class='carousel-item " . ($i == 0 ? "active" : "") . "'><img class='mx-auto d-block carousel-img' src='" . $url . "' alt='posting image'></div>";
                                            }
                                        ?>
                                      </div>
                                      <a class="carousel-control-prev" href="#listingImages" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                      </a>
                                      <a class="carousel-control-next" href="#listingImages" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                      </a>
                                    </div>

                                    <h4 class="card-title">About</h4>
                                    <div class="card-text">
                                        <? echo $listing["desc"]; ?>
                                    </div>

                                    <h4 class="card-title">Location</h4>
                                    <iframe
                                      class="location-map"
                                      frameborder="0" style="border:0"
                                      src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDrqRMlAyg4AfgxS26_LFJVd_h2ZgXjAdA&q=<? echo $listing['loc']; ?>" allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<footer class="page-footer font-small blue">
  <div class="footer-email text-center py-3"> Questions or Concerns? <a href="mailto:househubteam@gmail.com" target="_blank">Contact us!</a> 
  </div>
</footer>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="http://u747950311.hostingerapp.com/househub/site/res/js/main.js"></script>
        <script>
            $(document).ready(function() {
                $(".saveUnsaveListing").on("click", function(e) {
                    e.preventDefault();

                    var pid = $(this).attr("pid");
                    var btn = $(this);

                    $.ajax({
                        "url": "http://u747950311.hostingerapp.com/househub/site/res/php/doSaveUnsave.php",
                        "type": "POST",
                        "data": { "pid": pid },
                        success: function(res) {
                          console.log(res);
                          var data = JSON.parse(res);

                          console.log(data);

                          if (data["status"] == "error") {
                            return;
                          }

                          var savedUrl = "http://u747950311.hostingerapp.com/househub/site/res/img/" + ((data["action"] == "saved") ? "heart_full" : "heart_outline") + ".svg";

                          btn.children("img").prop("src", savedUrl);

                          console.log(this);
                        },
                        error: function(res) {

                        }
                    })
                })

                
            })
        </script>
    </body>
</html>




          