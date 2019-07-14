var curPage = 1;

var listings = [];

function createListing(data) {
  var ele = `<div class='card mb-2'>
              <div class='card-horizontal' style='transform: rotate(0);'>
                  <div class='img-square-wrapper'>
                      <img class='card-img' src='https://images.prop24.com/203649576' alt='Property Image'>
                  </div>
                  <div class='card-body'>
                      <h4 class='card-title'> ` + data["title"] + `</h4>
                      <p class='card-text'>` + data["desc"] + `</p>
                      <p class='card-text'>Price: $` + data["base_price"] + `</p>

                      <a href='#' class='stretched-link' pid='` + data["pid"] + `'></a>
                  </div>
              </div>
              <div class="card-footer text-muted">
                <small class='text-muted'>Posted on ` + prettyDate(data["created"]) + " by <a href='../account/user.php'>" + data["creator_fname"] + " " + data["creator_lname"] + `</a></small>
              </div>
          </div>`;

  $(".listingsContainer").append(ele);
}

var priceSort = false;
var postSort = false;
function sortListings() {
  listings.sort(function(a, b) {
    if (priceSort) {
      return a["base_price"] - b["base_price"];
    }

    if (postSort) {
      return a["created"] = b["created"];
    }
     
  })
}

function populateListings() {
  $(".listingsContainer").empty();

  $.each(listings, function(i, e) {
    createListing(e);
  })
}

function requestListings(page, search, minPrice, maxPrice, saved, mine, targetUserID) {
  var data = {
    "page": page,
    "search": search,
    "minPrice": minPrice,
    "maxPrice": maxPrice,
    "saved": saved,
    "mine": mine,
    "targetUserID": targetUserID
  };

  $("#loading").show();

  $.ajax({
    "url": "http://u747950311.hostingerapp.com/househub/site/res/php/doRequestListings.php",
    "type": "POST",
    "data": data,
    success: function(res) {

      console.log(res);
      var data = JSON.parse(res);

      if (data["status"] == "error") {

      }

      $("#loading").hide();

      if (data["listing_count"] == 0) {
        console.log("no results");
      } else {
        $.each(data.listings, function(i, e) {
          listings.push(e);
        })

        sortListings();
        populateListings();
      }
    },
    error: function(res) {
      console.log("error");
      console.log(res);
    }


  })
}

requestListings(1, "", "", "", "", "", "");

var minPrice, maxPrice, saved, mine, search;
minPrice = maxPrice = saved = mine = search = "";

$(document).ready(function() {
  $("#applyFilter").on("click", function(e) {
    e.preventDefault();

    $(".listingsContainer").empty();

    minPrice = $("#minPrice").val();
    maxPrice = $("#maxPrice").val();
    saved = $("#mySavedListings").is(":checked");
    mine  = $("#myListings").is(":checked");
    search = $("#searchText").val();

    curPage = 1;

    listings = [];

    requestListings(curPage, search, minPrice, maxPrice, saved, mine, "");
  })

  $("#mySavedListings").change(function() {
    if(this.checked) {
      $("#myListings").prop("checked", false);
    }
  });

  $("#myListings").change(function() {
    if(this.checked) {
      $("#mySavedListings").prop("checked", false);
    }
  });

  $(".priceSort").on("click", function(e) {
    if (!$(this).hasClass("active")) {
      $(this).addClass("active");
      $(".postSort").removeClass("active");

      priceSort = true;
      postSort = false;

      sortListings();
      populateListings();
    } else {
      $(this).removeClass("active");

      priceSort = false;
    }
  })

  $(".postSort").on("click", function(e) {
    if (!$(this).hasClass("active")) {
      $(this).addClass("active");
      $(".priceSort").removeClass("active");

      postSort = true;
      priceSort = false;

      sortListings();
      populateListings();
    } else {
      $(this).removeClass("active");

      postSort = false;
    }
  })
})