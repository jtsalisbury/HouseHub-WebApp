$(document).ready(function() {
  $("#submit span").hide();

  $("#postForm").on("submit", function(e) {
    e.preventDefault();

    $("#submit").prop("disabled", true);
    $("#submit span").show();

    var title = $("#title").val();
    var loc   = $("#loc").val();
    var price = $("#base_price").val();
    var desc  = $("#desc").val();
    var numFiles = $("#pics", this)[0].files.length;

    $(".titleFeedback").text("Please ensure you enter a valid title!");
    $("#title").removeClass("is-invalid");
    $("#title")[0].setCustomValidity("");

    $(".locationFeedback").text("Please ensure you enter a valid location!");
    $("#loc").removeClass("is-invalid");
    $("#loc")[0].setCustomValidity("");

    $(".basePriceFeedback").text("Please ensure you enter a valid price!");
    $("#base_price").removeClass("is-invalid");
    $("#base_price")[0].setCustomValidity("");

    $(".addPriceFeedback").text("Please ensure you enter a valid price!");
    $("#add_price").removeClass("is-invalid");
    $("#add_price")[0].setCustomValidity("");

    $(".descFeedback").text("Please ensure you enter a valid description!");
    $("#desc").removeClass("is-invalid");
    $("#desc")[0].setCustomValidity("");

    $(".imageFeedack").text("Please ensure you add at least three images!");
    $("#pics").removeClass("is-invalid");
    $("#pics")[0].setCustomValidity("");

    validateInputs("needs-validation");

    var titleValid = $("#title")[0].checkValidity();
    var locValid   = $("#loc")[0].checkValidity();
    var priceValid = $("#base_price")[0].checkValidity();
    var descValid  = $("#desc")[0].checkValidity();
    var imgValid   = $("#pics")[0].checkValidity();

    if (!titleValid || !locValid || !priceValid || !descValid || !imgValid) {
      $("#submit").prop("disabled", false);
      $("#submit span").hide();
    }

    $.ajax({
      url: "http://u747950311.hostingerapp.com/househub/site/res/php/doPostListing.php",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(res) {
        console.log(res);
        $("#submit span").hide();
        $("#submit").prop("disabled", false);

        if (res == "") {
          return;
        }

        var data = JSON.parse(res);

        if (data["status"] == "error") {
          var err = false;

          if (data["message"] == "field_incorrect_type") {
            $(".basePriceFeedback").text("Be sure this is a number!");
            $("#base_price").addClass("is-invalid");
            $("#base_price")[0].setCustomValidity("error");

            $(".addPriceFeedback").text("If you added an additional price, ensure it's a number!");
            $("#add_price").addClass("is-invalid");
            $("#add_price")[0].setCustomValidity("error");

            err = true;
          }

          if (data["message"] == "location_not_valid") {
            $(".locationFeedback").text("Please ensure you enter a valid location!");
            $("#loc").addClass("is-invalid");
            $("#loc")[0].setCustomValidity("error");
          }

          if (data["message"] == "invalid_number_pictures") {
            $(".imageFeedack").text("Please ensure you add at least three images!");
            $("#pics").addClass("is-invalid");
            $("#pics")[0].setCustomValidity("error");

            err = true;
          }

          if (data["message"] == "invalid_file_type_supplied") {
            $(".imageFeedack").text("Please ensure these are all of the jpg,jpeg or png type!");
            $("#pics").addClass("is-invalid");
            $("#pics")[0].setCustomValidity("error");

            err = true;
          }

          if (data["message"] == "image_too_large") {
            $(".imageFeedack").text("Please ensure these are all less than 2MB!");
            $("#pics").addClass("is-invalid");
            $("#pics")[0].setCustomValidity("error");

            err = true;
          }

          if (data["message"] == "title_already_exists") {
            $(".titleFeedback").text("A listing with this title already exists!");
            $("#title").addClass("is-invalid");
            $("#title")[0].setCustomValidity("error");

            err = true;
          }

          if (!err) {
            console.log("internal error, contact admin " + data["message"]);
          }

          $("#submit").prop("disabled", false);
          $("#submit span").hide();
        
        } else {
          window.location.href = ("./view.php?id=" + data["pid"]);
        }
      },
      error: function(res) {
        console.log(res);
      }
    })


  })
})