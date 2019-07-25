var curPage = 1;

var listings = [];

function createListing(data) {
  var url = 'http://u747950311.hostingerapp.com/househub/api/images/' + data["pid"] + "/" + data["images"][0];
  var savedUrl = "http://u747950311.hostingerapp.com/househub/site/res/img/" + ((data["saved"] === "1" || saved) ? "heart_full" : "heart_outline") + ".svg";

  var ele = `<div class='card mb-2 ` + "listing-" + data["pid"] + `'>
              <div class='card-horizontal' style='transform: rotate(0);'>
                  <div class='img-square-wrapper'>
                      <img class='card-img' src='` + url + `' alt='Property Image'>
                  </div>
                  <div class='card-body'>
                      <div class='d-flex'>
                        <h4 class='card-title text-truncate'> ` + data["title"] + `</h4>` + (data["hidden"] == 1 ? "<span class='badge badge-secondary ml-auto' style='height: 20px'>Hidden</span>" : "") + `
                      </div>

                      <p class='card-text text-truncate'>` + data["desc"] + `</p>
                      <p class='card-text text-truncate'>Price: $` + data["base_price"] + `</p>
                      <p class='card-text text-truncate'>Located at ` + data["loc"] + `</p>

                      <a href='#' class='listingLink stretched-link' pid='` + data["pid"] + `'></a>
                  </div>
              </div>
              <div class="card-footer text-muted">
                <div class='d-flex'>
                  <small class='text-muted btn btn-sm'>
                    Posted on ` + prettyDate(data["created"]) + " by <a href='#' uid='" + data["creator_uid"] + "' class='userLink'>" + data["creator_fname"] + " " + data["creator_lname"] + `</a>
                  </small>

                  <button class='ml-auto saveUnsaveListing ` + ((data["saved"] === "1" || saved) ? "saved" : "") + `' pid=` + data["pid"] + `>
                    <img class='m-auto' src='` + savedUrl + `' width="20" />
                  </button>

                </div>
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
      console.log("a " + a["created"]);
      console.log("b " + b["created"]);
      console.log(new Date(a["created"]) - new Date(b["created"]));

      var aDate = new Date(a["created"]);
      var bDate = new Date(b["created"]);

      return ((aDate < bDate) ? -1 : ((aDate > bDate) ? 1 : 0));
    }

    return b["pid"] - a["pid"];
  })
}

function populateListings() {
  $(".listingsContainer").empty();

  $.each(listings, function(i, e) {
    createListing(e);
  })
}

function parseDate(input) {
  var parts = input.match(/(\d+)/g);
  // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
  return new Date(parts[0], parts[1]-1, parts[2], parts[3], parts[4], parts[5]); //     months are 0-based
}

var listingCount = 0;
var totalListings = 0;
function requestListings(page, search, minPrice, maxPrice, saved, mine, targetUserID) {
  $("#noResults").hide();
  $("#loadMore").hide();

  var data = {
    "page": page,
    "search": search,
    "minPrice": minPrice,
    "maxPrice": maxPrice,
    "saved": saved,
    "mine": mine,
    "targetUserID": targetUserID,
    "show_hidden": mine
  };

  $("#loading").show();

  $.ajax({
    "url": "http://u747950311.hostingerapp.com/househub/site/res/php/doRequestListings.php",
    "type": "POST",
    "data": data,
    success: function(res) {

      console.log(res);
      var data = JSON.parse(res);

      console.log(data);

      if (data["status"] == "error") {
        return;
      }

      $("#loading").hide();

      if (data["listing_count"] == 0) {
        console.log("no results");
        $("#noResults").show();

      } else {
        $.each(data.listings, function(i, e) {
          listings.push(e);
        })

        sortListings();
        populateListings();
      }

      totalListings = data["total_listings"];

      if (data["total_pages"] > curPage && data["total_pages"] != 0) {
        $("#loadMore").show();
      }

      listingCount += data["listing_count"];
      $(".listingCount").text("Showing 1 to " + listingCount + " of " + data["total_listings"] + " results");
    },
    error: function(res) {
      console.log("error");
      console.log(res);
    }

  })
}

function saveUnsaveListing(pid, btn) {
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

      var savedUrl = "http://u747950311.hostingerapp.com/househub/site/res/img/" + ((data["action"] == "saved" || saved) ? "heart_full" : "heart_outline") + ".svg";

      btn.children("img").prop("src", savedUrl);

      if (data["action"] == "unsaved" && saved) {
        $(".listing-" + pid).remove();

        listingCount--;
        totalListings--;

        $(".listingCount").text("Showing 1 to " + listingCount + " of " + totalListings + " results");
      }
    },
    error: function(res) {

    }
  })
}

requestListings(1, "", "", "", "", "", "");

var minPrice, maxPrice, saved, mine, search;
minPrice = maxPrice = saved = mine = search = "";

$(document).ready(function() {
  $("#noResults").hide();
  $("#loadMore").hide();

  $("#applyFilter").on("click", function(e) {
    e.preventDefault();

    $(".listingsContainer").empty();

    minPrice = $("#minPrice").val();
    maxPrice = $("#maxPrice").val();
    saved = $("#mySavedListings").is(":checked");
    mine  = $("#myListings").is(":checked");
    search = $("#searchText").val();

    curPage = 1;
    listingCount = 0;

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

  $("#doLoadMore").on("click", function(e) {
    curPage++;

    requestListings(curPage, search, minPrice, maxPrice, saved, mine, "");
  })

  $(".priceSort").on("click", function(e) {
    if (!$(this).hasClass("active")) {
      $(this).addClass("active");
      $(".postSort").removeClass("active");

      priceSort = true;
      postSort = false;
    } else {
      $(this).removeClass("active");

      priceSort = false;
    }

    sortListings();
    populateListings();
  })

  $(".postSort").on("click", function(e) {
    if (!$(this).hasClass("active")) {
      $(this).addClass("active");
      $(".priceSort").removeClass("active");

      postSort = true;
      priceSort = false;
    } else {
      $(this).removeClass("active");

      postSort = false;
    }

    sortListings();
    populateListings();
  })

  $(document).on("click", ".listingLink", function(e) {
    e.preventDefault();

    window.location.href = "./view.php?id=" + $(this).attr("pid");
  })

  $(document).on("click", ".saveUnsaveListing", function(e) {
    saveUnsaveListing($(this).attr("pid"), $(this));
  })

  $(document).on("click", ".userLink", function(e) {
    e.preventDefault();

    window.location.href = "../account/view.php?id=" + $(this).attr("uid");
  })
})