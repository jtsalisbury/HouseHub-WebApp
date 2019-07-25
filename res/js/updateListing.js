$(document).ready(function() {
  $("#submit span").hide();

  $("#postForm").on("submit", function(e) {
    e.preventDefault();
    $("#submit").prop("disabled", true);
    $("#submit span").show();

    var fd = new FormData(this);
    fd.append("pid", $("#postForm").attr("pid"));

    $.ajax({
      url: "http://u747950311.hostingerapp.com/househub/site/res/php/doUpdateListing.php",
      type: "POST",
      data: fd,
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

        window.location.href = ("./view.php?id=" + data["pid"]);
      },
      error: function(res) {
        console.log(res);
      }
    })


  })
})