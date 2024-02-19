<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="./js/products.js"></script> -->
    <link rel="stylesheet" href="./css/side-bar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/filter-sort.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <style>
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <!-- Sidebar -->
                <div id="sidebar" class="sidebar">
                    <h5>Filter Options</h5>
                    <br>
                    <div class="form-group">
                        <h6><label>Brand</label></h6>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="brand" value="RayBan" id="brandRayBan">
                                <label class="form-check-label" for="brandRayBan">
                                    RayBan
                                </label>
                            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="brand" value="John_Jacobs" id="brandJohnJacobs">
                <label class="form-check-label" for="brandJohnJacobs">
                    John Jacobs
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="brand" value="Lee_Cooper" id="brandLeeCooper">
                <label class="form-check-label" for="brandLeeCooper">
                    Lee Cooper
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="brand" value="Vincent_Chase" id="brandVincentChase">
                <label class="form-check-label" for="brandVincentChase">
                    Vincent Chase
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="brand" value="Oakley" id="brandOakley">
                <label class="form-check-label" for="brandOakley">
                    Oakley
                </label>
    </div>
    <br>
    <div class="form-group">
        <h6><label for="price">Price Range</label></h6>
        <select class="form-control" id="price">
            <option value="">All Prices</option>
            <option value="under_1000">Under 1000</option>
            <option value="under_2000">Under 2000</option>
            <option value="under_3000">Under 3000</option>
            <option value="under_4000">Under 4000</option>
            <option value="under_5000">Under 5000</option>
            <option value="under_6000">Under 6000</option>
        </select>
    </div>
    <button type="button" id="applyFiltersBtn" class="btn btn-primary">Apply Filters</button>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- Sort Option -->
            <div id="sortOption" class="form-group" style="margin-left: 10%; margin-top: 5%; position: fixed; left: 0;">
                <label>Sort By</label>
                <select class="form-control" id="sort">
                    <option value="all">All Products</option>
                    <option value="price_low_high">Price Low to High</option>
                    <option value="price_high_low">Price High to Low</option>
                </select>
            </div>
        </div>
    </div>
</div>
</body>

</html>
