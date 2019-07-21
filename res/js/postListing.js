$(document).ready(function() {
  $("#submit span").hide();

  $("#postForm").on("submit", function(e) {
    e.preventDefault();
    $("#submit").prop("disabled", true);
    $("#submit span").show();

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
          return;
        }

        set("pid", data["pid"]);

        window.location.href = "./view.php";
      },
      error: function(res) {
        console.log(res);
      }
    })


  })
})