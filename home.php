<?php
include 'authenticate-user.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <title>VisionVibes</title>
    <style>
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #7caf4c;
            color: white;
        }
        .error {
            background-color: #943726;
            color: white;
        }
        .card {
            border: none;
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
    <script>
        window.onload = function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success') && urlParams.get('success') == '1') {
                displayMessage("Login successful!", "success");
            } else if (urlParams.has('success') && urlParams.get('success') == '2') {
                displayMessage("Order placed successfully. Shop more! Thankyou!.", "success");
            }else if (urlParams.has('error') && urlParams.get('error') == '3') {
                displayMessage("Payment Failed", "error");
            }
            
        };

        function displayMessage(message, type) {
            var messageContainer = document.createElement('div');
            messageContainer.textContent = message;
            messageContainer.classList.add('message', type);
            document.body.insertBefore(messageContainer, document.body.firstChild);
            setTimeout(function() {
                messageContainer.remove();
            }, 3000); // Remove message after 3 seconds
        }

        // Initialize Bootstrap components
        $(document).ready(function(){
            $('.dropdown-toggle').dropdown();
        });
    </script>
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'nav.php'; ?>

    <!-- Page Content -->
    <div class="container mt-5 position-relative">
        <!-- banner image -->
        <img src="https://www.shutterstock.com/image-photo/trendy-sunglasses-sale-banner-summer-260nw-2140221363.jpg" class="banner-img" alt="Banner Image">
        <div class="row">
            <div class="col-lg-12 text-center">
                <br>
                <h1 class="display-4" style="font-weight: bold;">Wear Your Style!</h1>
                <p class="lead" style="font-weight: 500;">Find your look just matching your style and personality!</p>
            </div>
        </div>
    </div><br><br>
<hr>
    <!-- Featured Products Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <img src="https://partners.lenskart.com/cdn/shop/products/john-jacobs-jj-e11083-c9-eyeglasses_7i5a7830_1_2_2_d4d4b916-f4e4-4914-a43f-0225f00bc03e_1200x1200.jpg?v=1633582425" class="card-img-top" alt="Product 1">
                    <div class="card-body">
                        <h5 class="card-title">Women Collection</h5>
                        <p class="card-text">Eyes that Sparkle: Discover the Elegance of Our Women's Eyewear Collection</p>
                        <a href="eyeglasses-prod.php" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <img src="https://uk.lindafarrow.com/cdn/shop/products/LFL1052C1OPT-REYNOLDS.jpg?v=1648039073" class="card-img-top" alt="Product 2">
                    <div class="card-body">
                        <h5 class="card-title">Men Collection</h5>
                        <p class="card-text">Sharper Vision, Bolder Style: Unleash the Power of Our Men's Eyewear Collection</p>
                        <a href="eyeglasses-prod.php" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <img src="kidsimage.webp" class="card-img-top" alt="Product 3">
                    <div class="card-body">
                        <h5 class="card-title">Kids Collection</h5>
                        <p class="card-text">Frame the Future: Cute and Comfy Eyewear for Your Little Ones</p>
                        <a href="eyeglasses-prod.php" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    
<!-- Trending Products Section -->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2 class="display-6" style="font-weight: bold;">Trending Products</h2>
            <p class="lead" style="font-weight: 400;">Discover our latest and most popular eyewear products.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <img src="https://partners.lenskart.com/cdn/shop/products/vincent-chase-vc-e13786-c1-eyeglasses_vincent-chase-vc-e13786-c1-eyeglasses_g_3325_1200x1200.jpg?v=1677473015" class="card-img-top" alt="Trending Product 1">
                <div class="card-body">
                    <h5 class="card-title">Elegant Geometric Frames</h5>
                    <p class="card-text">Shop sleek elegance with our geometric frames.</p>
                    <a href="eyeglasses-prod.php" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <img src="https://static5.lenskart.com/media/catalog/product/pro/1/thumbnail/628x301/9df78eab33525d08d6e5fb8d27136e95//v/i/vincent-chase-vc-e16456-c2-eyeglasses_img_7104_05_12_2023.jpg" class="card-img-top" alt="Trending Product 2">
                <div class="card-body">
                    <h5 class="card-title">Classic Aviator Frames</h5>
                    <p class="card-text">Timeless style meets modern flair with our aviator frames.</p>
                    <a href="eyeglasses-prod.php" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <img src="https://static5.lenskart.com/media/catalog/product/pro/1/thumbnail/628x301/9df78eab33525d08d6e5fb8d27136e95//l/i/Transparent-Gold-Transparent-Full-Rim-Wayfarer-Lenskart-Air-Signia-LA-E11821-C3-Eyeglasses_lenskart-air-la-e11821-fall-rim-wfe-stais-stel-c1-eyeglasses_g_251307_02_2022.jpg" class="card-img-top" alt="Trending Product 3">
                <div class="card-body">
                    <h5 class="card-title">Trending Transparent Frames</h5>
                    <p class="card-text">Stay on-trend with our transparent frames collection.</p>
                    <a href="eyeglasses-prod.php" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<!-- Categories -->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2 class="display-6" style="font-weight: bold;">Eyewear Categories</h2>
            <p class="lead" style="font-weight: 400;">Discover stylish eyewear for every occasion in our curated categories.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <img src="https://www.eyeons.com/images/cache/catalog/products/marc-jacobs/mjb-537-0807-00-874x437.jpg" class="card-img-top" alt="Trending Product 1">
                <div class="card-body">
                    <h5 class="card-title">Eyeglasses</h5>
                    <p class="card-text">Find your perfect pair with our stylish eyeglasses.</p>
                    <a href="eyeglasses-prod.php" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQfPZfF-zaY7rdD6pR-K1vn9KJOe_h7iL1B5A&usqp=CAU" class="card-img-top" alt="Trending Product 2">
                <div class="card-body">
                    <h5 class="card-title">Sunglasses</h5>
                    <p class="card-text">Shade your eyes in style with our chic sunglasses.</p>
                    <a href="sunglasses-prod.php" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <img src="https://www.eurooptica.com/cdn/shop/products/got-op-ukkie-slate-00_1400x.jpg?v=1677612176" class="card-img-top" alt="Trending Product 3">
                <div class="card-body">
                    <h5 class="card-title">Screen Glasses</h5>
                    <p class="card-text">Protect your eyes in style with our screen glasses.</p>
                    <a href="screenglasses-prod.php" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<!-- Testimonials Section -->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2 class="display-6" style="font-weight: bold;">What Our Customers Say</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">"The aviator frames I got are a classic! The build quality is superb, and they add a touch of sophistication to my look. Fantastic product and service."</p>
                    <p class="text-right"><strong>- Devansh</strong></p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">"As a parent, finding durable and stylish eyewear for my kids was a priority. The kids' collection at VisionVibes exceeded my expectations. My children love their new goggles!"</p>
                    <p class="text-right"><strong>- Kavya</strong></p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">"I recently ordered a pair of blue light blocking glasses for work, and they have made a noticeable difference in reducing eye strain. VisionVibes delivers both functionality and style."</p>
                    <p class="text-right"><strong>- Ishaan</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Featured Brands Section -->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2 class="display-6" style="font-weight: bold;">Featured Brands</h2>
            <p class="lead" style="font-weight: 400;">Explore top-notch eyewear brands that define style and quality.</p>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
    <div class="col-lg-2">
        <a href="https://india.ray-ban.com/">
            <img src="https://i.pinimg.com/originals/09/bc/d6/09bcd63e5f54460df25a1f4fdaa1c065.jpg" alt="Ray-Ban" class="img-fluid">
        </a>
    </div>
    <div class="col-lg-2">
        <a href="https://www.johnjacobseyewear.com/">
            <img src="https://media.licdn.com/dms/image/C4D22AQHjOIVD0NaGLw/feedshare-shrink_800/0/1679583053175?e=2147483647&v=beta&t=CQGP8nmuQXaCIJpd5YKcNWVWKPUmZVCcmh_osg6yJ_M" alt="John Jacobs" class="img-fluid">
        </a>
    </div>
    <div class="col-lg-2">
        <a href="https://www.leecooper.com/">
            <img src="https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/0023/8503/brand.gif?itok=xs71GdV_" alt="Lee Cooper" class="img-fluid">
        </a>
    </div>
    <div class="col-lg-2">
        <a href="https://www.coach.com/">
            <img src="https://m.media-amazon.com/images/S/al-eu-726f4d26-7fdb/eb3a4241-39a1-4e44-a6fd-5c47bae9b644.jpg" alt="Vincent Chase" class="img-fluid">
        </a>
    </div>
    <div class="col-lg-2">
        <a href="https://www.oakley.com/">
            <img src="https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/072016/untitled-1_279.png?itok=YRJhrklt" alt="Oakley" class="img-fluid">
        </a>
    </div>
</div>

</div>    
<hr>
    <!-- // Footer Section -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    O⌄O VisionVibes
                </div>
                <div class="footer-text">
                    <p>&copy; 2023 Vision Vibes. All Rights Reserved.</p>
                </div>
            </div>
        </div>
        <hr style="margin-left: 5%; margin-right: 5%">
        <p style="text-align: center;">Designed with <span class="heart">&hearts;</span> by Nandana</p>
    </footer>


    <!-- // JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/7785e19128.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha384-7v1vbll1aXQN+/6fkI65f8F6TfT8/zy4PXdMW9sQY3TI4NdIiFqQ0W/gFqgoj3I1" crossorigin="anonymous"></script>

    
</body>

</html>

