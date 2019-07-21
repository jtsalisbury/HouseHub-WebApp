<?php 
    include("../res/util/helper.php");

    if (!checkLogin()) {
        header("Location: ../account/login.php");
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

        <style>
            .card-horizontal {
                display: flex;
                flex: 1 1 auto;
            }

            .card-body p {
              white-space: nowrap;
              overflow: hidden;
              text-overflow: ellipsis;
            }

            .card-body {
                min-width: 0;
            }

            .card-img {
                width: 14rem;
                height: 184.4px;
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

            .saveUnsaveListing img {

            }
        </style>

        <title>HouseHub | All Listings</title>
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
                  <li class="nav-item active">
                    <a class="nav-link" href="#">View Listings</a>
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

        <div class="container-fluid" style="height: calc(100vh - 199.5px); margin-top: 30px; margin-bottom: 30px;">
            <div class="row">
                <div class="card offset-md-4 col-7" style="border: none;">
                    <div class="row">
                        <div class="card-body col-6">
                            <form class="form-inline">
                                <p style="height: 38px; line-height: 38px; margin: 0">Sort by:</p>
                                <div class="intput-group ml-2">
                                    <button type="button" class="btn btn-primary sort priceSort">Price</button>
                                </div>
                                <div class="intput-group ml-2">
                                    <button type="button" class="btn btn-primary sort postSort">Post Date</button>
                                </div>
                            </form>
                        </div>

                        <div class="text-center offset-1 col-5">
                            <p style="height: 78px; line-height: 78px; margin: 0" class="listingCount">
                                Showing 0 to 0 of 0 listings
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row h-100">
                <div class="card offset-sm-1 col-md-2 col-sm-10 align-self-center w-100" style="border: none;">
                    <form>
                        <div class="input-group ">
                            <input type="text" class="form-control" id="searchText" placeholder="Search...">
                            
                        </div>
                        <hr />

                        <div class="form-row form-group">
                            <div class="col">
                                <input type="text" id="minPrice" class="form-control" placeholder="Min Price">
                            </div>
                            <div class="col">
                                <input type="text" id="maxPrice" class="form-control" placeholder="Max Price">
                            </div>
                        </div>

                        <div class="form-check form-group">
                            <input type="checkbox" class="form-check-input" id="mySavedListings">
                            <label class="form-check-label" for="mySavedListings">My Saved Listings</label>
                        </div>

                        <div class="form-check form-group">
                            <input type="checkbox" class="form-check-input" id="myListings">
                            <label class="form-check-label" for="myListings">My Listings</label>
                        </div>

                        <button type="submit" id="applyFilter" class="btn btn-primary">Apply Filters</button>
                    </form>
                </div>

                <div class="card col-md-7 offset-sm-1 col-sm-10 align-self-center h-100" style="overflow-y: auto; border: none;">
                    <div class="text-center" id="loading">
                      <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                    </div>

                    <div class="text-center" id="noResults">
                      No Results
                    </div>

                    <div class="row">
                        <div class="col-12 mat-3 listingsContainer">
                            
                        </div>
                        <div class="container" id="loadMore">
                          <div class="row">
                            <div class="col text-center">
                              <button type="submit" id="doLoadMore" class="btn btn-primary">Load More</button>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="http://u747950311.hostingerapp.com/househub/site/res/js/main.js"></script>
        <script src="http://u747950311.hostingerapp.com/househub/site/res/js/viewListings.js"></script>
    </body>
</html>




          