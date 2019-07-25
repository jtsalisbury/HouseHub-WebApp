<?php 
    include("../res/util/helper.php");
    error_reporting(E_ERROR | E_PARSE);

    include_once "../res/util/enums.php";
    include_once "../res/util/jwt.php";

    if (!checkLogin()) {
        header("Location: ./login.php");
    }

    // Parse settings and initialize global Jobjects
    $data = parse_ini_file("../res/util/settings.ini");

    // Used for: creation, verification and decoding of tokens
    $jwt = new JWT($data["signKey"], $data["signAlgorithm"], $data["payloadSecret"], $data["payloadCipher"]);
  
    // Used for: global ENUMS
    $ENUMS = new ENUMS();

    $id = $_SESSION["uid"];
    if(empty($id)){
        header("Location: ../listings/viewall.php");
    }

    $data = array("uid" => $id);

    $token = $jwt->generateToken($data);
    $token = json_encode(array("token" => $token));

    $url = "http://u747950311.hostingerapp.com/househub/api/user/retrieve.php";
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

        <title>HouseHub | Update Account</title>
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
                    <a class="nav-link" href="../listings/viewall.php">View Listings</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../listings/create.php">Post Listing</a>
                  </li>
                  <li class="nav-item btn-group">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">My Account</a>
                    
                    <div class="dropdown-menu dropdown-menu-right active">
                      <a class="dropdown-item active" href="./update.php">Update Information</a>
                      <a class="dropdown-item" href="./logout.php">Logout</a>
                    </div>
                  </li>
                </ul>
            </div>

        </nav>


        <div class="container" style="height:90vh">
           <div class="row h-100">

                <div class="card offset-md-3 col-md-6 offset-sm-1 col-sm-10 align-self-center">
                    <div class="card-body">
                        <h5 class="card-title">Update Information</h5>

                        <p>
                            Hey there! Want to update your account? No problem!
                            <br />
                            Throw in your details and let us do the heavy lifting!
                        </p>

                        <form class="needs-validation" novalidate>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><img src="../res/img/person.svg" height="15.281" width="15.281"></div>
                                </div>
                                <input type="text" class="form-control" id="fname" placeholder="First Name" required value="<? echo $payload['fname']; ?>">
                                <div class="invalid-feedback fnameFeedback">
                                    Please ensure you enter a valid first name!
                                </div>
                            </div>

                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><img src="../res/img/person.svg" height="15.281" width="15.281"></div>
                                </div>
                                <input type="text" class="form-control" id="lname" placeholder="Last Name" required value="<? echo $payload['lname']; ?>">
                                <div class="invalid-feedback lnameFeedback">
                                    Please ensure you enter a valid last name!
                                </div>
                            </div>



                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><img src="../res/img/envelope-closed.svg" height="15.281" width="15.281"></div>
                                </div>
                                <input type="email" class="form-control" id="email" placeholder="Email" required value="<? echo $payload['email']; ?>">
                                <div class="invalid-feedback emailFeedback">
                                    Please ensure you enter a valid email!
                                </div>
                            </div>

                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><img src="../res/img/key.svg" height="15.281" width="15.281"></div>
                                </div>
                                <input type="password" class="form-control" id="password" placeholder="New Password" autocomplete="off">
                            </div>

                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><img src="../res/img/key.svg" height="15.281" width="15.281"></div>
                                </div>
                                <input type="password" class="form-control" id="password-re" placeholder="Re-enter New Password" autocomplete="off">
                            </div>

                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><img src="../res/img/key.svg" height="15.281" width="15.281"></div>
                                </div>
                                <input type="password" class="form-control" id="curpass" placeholder="Current Password" required>
                                <div class="invalid-feedback curpasswordFeedback">
                                    Please ensure you enter a password!
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="doRegister">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="http://u747950311.hostingerapp.com/househub/site/res/js/main.js"></script>

        <script>
            $(document).ready(function() {

                $("#doRegister").on("click", function(e) {
                    e.preventDefault();

                    $("#doRegister").attr("disabled", true);

                    var pass = $("#password").val();
                    var repass = $("#password-re").val();
                    var email = $("#email").val();
                    var fname = $("#fname").val();
                    var lname = $("#lname").val();
                    var curpass = $("#curpass").val();

                    $(".emailFeedback").text("Please ensure you enter a valid email!");
                    $("#email").removeClass("is-invalid");
                    $("#email")[0].setCustomValidity("");

                    $(".curpasswordFeedback").text("Please ensure you enter a password!");
                    $("#curpass").removeClass("is-invalid");
                    $("#curpass")[0].setCustomValidity("");

                    $(".fnameFeedback").text("Please ensure you enter a valid first name!");
                    $("#fname").removeClass("is-invalid");
                    $("#fname")[0].setCustomValidity("");

                    $(".lnameFeedback").text("Please ensure you enter a valid last name!");
                    $("#lname").removeClass("is-invalid");
                    $("#lname")[0].setCustomValidity("");

                    validateInputs("needs-validation");

                    var passValid = $("#curpass")[0].checkValidity();
                    var emailValid = $("#email")[0].checkValidity();
                    var fnameValid = $("#fname")[0].checkValidity();
                    var lnameValid = $("#lname")[0].checkValidity();

                    if (passValid === false || emailValid === false || fnameValid === false || lnameValid === false) {
                        $("#doRegister").attr("disabled", false);

                        return false;
                    }

                    $.ajax({
                        "url": "http://u747950311.hostingerapp.com/househub/site/res/php/doUpdateUser.php",
                        "type": "POST",
                        "data": {
                            "email": email, 
                            "password": pass,
                            "fname": fname,
                            "lname": lname,
                            "repass": repass,
                            "curpass": curpass
                        },
                        success: function(res) {

                            console.log(res);

                            if (res === "") {
                                return;
                            }

                            var payload = JSON.parse(res);

                            if (payload["status"] === "error") {

                                var err = false;
                                if (payload["message"] == "password_not_equal") {
                                    $(".curpasswordFeedback").text("Incorrect password entered!");
                                    $("#curpass").addClass("is-invalid");
                                    $("#curpass")[0].setCustomValidity("error");

                                    err = true;
                                } 
                                
                                if (payload["message"] == "update_user_new_pass_not_equal") {

                                    err = true;
                                }
                                
                                if (!err) {
                                    alert("internal error; contact admin" + payload["message"]);
                                }

                                $("#doRegister").attr("disabled", false);

                            } else {

                                window.location.href = "./view.php?id=" + payload["uid"];
                            }
                        }
                    })



                })

                

            })
        </script>
    </body>
</html>