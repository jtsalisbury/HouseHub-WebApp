<?php 
    include("../res/util/helper.php");

    if (checkLogin()) {
        header("Location: ../listings/viewall.php");
    }
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

        <title>HouseHub | Register</title>
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
        </nav>

        <div class="container" style="height:calc(100vh - 61.5px - 56px);">
           <div class="row h-100">

                <div class="card offset-md-3 col-md-6 offset-sm-1 col-sm-10 align-self-center">
                    <div class="card-body">
                        <h5 class="card-title">Register</h5>

                        <p>
                            Hey there! Welcome to HouseHub!
                            <br>
                            We're excited you'd like to join!
                        </p>

                        <form class="needs-validation" novalidate>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><img src="../res/img/person.svg" height="15.281" width="15.281"></div>
                                </div>
                                <input type="text" class="form-control" id="fname" placeholder="First Name" required>
                                <div class="invalid-feedback fnameFeedback">
                                    Please ensure you enter a valid first name!
                                </div>
                            </div>

                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><img src="../res/img/person.svg" height="15.281" width="15.281"></div>
                                </div>
                                <input type="text" class="form-control" id="lname" placeholder="Last Name" required>
                                <div class="invalid-feedback lnameFeedback">
                                    Please ensure you enter a valid last name!
                                </div>
                            </div>



                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><img src="../res/img/envelope-closed.svg" height="15.281" width="15.281"></div>
                                </div>
                                <input type="email" class="form-control" id="email" placeholder="Email" required>
                                <div class="invalid-feedback emailFeedback">
                                    Please ensure you enter a valid email!
                                </div>
                            </div>

                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><img src="../res/img/key.svg" height="15.281" width="15.281"></div>
                                </div>
                                <input type="password" class="form-control" id="password" placeholder="Password" required>
                                <div class="invalid-feedback passwordFeedback">
                                    Please ensure you enter a password!
                                </div>
                            </div>

                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><img src="../res/img/key.svg" height="15.281" width="15.281"></div>
                                </div>
                                <input type="password" class="form-control" id="password-re" placeholder="Re-enter Password" required>
                                <div class="invalid-feedback password-reFeedback">
                                    Please ensure you enter a password!
                                </div>
                            </div>


                            <p>
                                Already have an account? <a href="login.php" target="_self">Login here</a>
                            </p>

                            <button type="submit" class="btn btn-primary" id="doRegister">Submit</button>
                        </form>

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

                $("#doRegister").on("click", function(e) {
                    e.preventDefault();

                    $("#doRegister").attr("disabled", true);

                    var pass = $("#password").val();
                    var repass = $("#password-re").val();
                    var email = $("#email").val();
                    var fname = $("#fname").val();
                    var lname = $("#lname").val();

                    $(".emailFeedback").text("Please ensure you enter a valid email!");
                    $("#email").removeClass("is-invalid");
                    $("#email")[0].setCustomValidity("");

                    $(".passwordFeedback").text("Please ensure you enter a password!");
                    $("#password").removeClass("is-invalid");
                    $("#password")[0].setCustomValidity("");

                    $(".password-reFeedback").text("Please ensure you enter a password!");
                    $("#password-re").removeClass("is-invalid");
                    $("#password-re")[0].setCustomValidity("");

                    $(".fnameFeedback").text("Please ensure you enter a valid first name!");
                    $("#fname").removeClass("is-invalid");
                    $("#fname")[0].setCustomValidity("");

                    $(".lnameFeedback").text("Please ensure you enter a valid last name!");
                    $("#lname").removeClass("is-invalid");
                    $("#lname")[0].setCustomValidity("");

                    validateInputs("needs-validation");

                    var passValid = $("#password")[0].checkValidity();
                    var repassValid = $("#password-re")[0].checkValidity();
                    var emailValid = $("#email")[0].checkValidity();
                    var fnameValid = $("#fname")[0].checkValidity();
                    var lnameValid = $("#lname")[0].checkValidity();

                    if (passValid === false || emailValid === false || repassValid === false || fnameValid === false || lnameValid === false) {
                        $("#doRegister").attr("disabled", false);

                        return false;
                    }

                    $.ajax({
                        "url": "http://u747950311.hostingerapp.com/househub/site/res/php/doRegister.php",
                        "type": "POST",
                        "data": {
                            "email": email, 
                            "password": pass,
                            "fname": fname,
                            "lname": lname,
                            "repass": repass
                        },
                        success: function(res) {
                            if (res === "") {
                                return;
                            }

                            var payload = JSON.parse(res);

                            if (payload["status"] === "error") {

                                var err = false;
                                if (payload["message"] == "failed_insert_user_exists") {
                                    $(".emailFeedback").text("An account already exists with this email!");
                                    $("#email").addClass("is-invalid");
                                    $("#email")[0].setCustomValidity("error");

                                    err = true;
                                } 
                                
                                if (payload["message"] == "password_not_equal") {
                                    $(".passwordFeedback").text("Passwords do not match!");
                                    $("#password").addClass("is-invalid");
                                    $("#password")[0].setCustomValidity("error");

                                    $(".password-reFeedback").text("Passwords do not match!");
                                    $("#password-re").addClass("is-invalid");
                                    $("#password-re")[0].setCustomValidity("error");

                                    err = true;

                                }
                                
                                if (!err) {
                                    alert("internal error; contact admin" + payload["message"]);
                                }

                                $("#doRegister").attr("disabled", false);

                            } else {
                                set("fname", payload["fname"]);
                                set("lname", payload["lname"]);
                                set("email", payload["email"]);
                                set("admin", payload["admin"]);
                                set("created", payload["created"]);
                                set("uid", payload["uid"]);

                                window.location.href = "../listings/viewall.php";
                            }
                        }
                    })



                })

                

            })
        </script>
    </body>
</html>