$(document).ready(function() {
  $("#postForm").on("submit", function(e) {
    e.preventDefault();

    $.ajax({
      url: "http://u747950311.hostingerapp.com/househub/site/res/php/doPostListing.php",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(res) {
        if (res == "") {
          return;
        }

        var data = JSON.parse(res);

        console.log(res);
        console.log(data);

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