<?php
    // Connecting Database . . .
    session_start();
    require_once "config/content_db.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Page</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Rating -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="css/font-awesome.min.css">



    <link rel="stylesheet" href="stars.css">

    <!-- STYLE Album Card-->
        <style>
            .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            }
    
            @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
            }
    
            .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
            }
    
            .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
            }
    
            .bi {
            vertical-align: -.125em;
            fill: currentColor;
            }
    
            .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
            }
    
            .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            }
    
            .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
    
            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
            }
    
            .bd-mode-toggle {
            z-index: 1500;
            }
    
            .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
            }
        </style>





</head>
<body>
    <!-- Nevigator Bar -->
        <div class="container">
            <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
                <a class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                    <!-- Logo -->
                    WongNok
                </a>
        
                <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="mem_page.php" class="nav-link px-2 link-secondary">Home</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Features</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Pricing</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">FAQs</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">About</a></li>
                </ul>
        
                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-outline-primary me-2" href="mem_page.php">Login</button>
                    <button type="button" class="btn btn-primary" href="mem_page.php">Sign-up</button>
                </div>
            </header>
        </div>

    <!-- Hero Section -->
        <div class="px-4 py-5 my-5 text-center">
                <img class="d-block mx-auto mb-4" src="config/web_img/eat-yummy.gif" alt="" width="72" height="57">
                <h1 class="display-5 fw-bold">WongNok</h1>
                <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">เว็บไซต์แบ่งปันสูตรอาหาร</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <button type="button" class="btn btn-primary btn-lg px-4 gap-3">Primary button</button>
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4">Secondary</button>
                </div>
            </div>
        </div>        

    <!-- Album Display --> 

        <div class="album py-5 bg-body-tertiary">
            <div class="container"> 
                
            
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                    <?php 
                        $stmt = $conn->query("SELECT * FROM content");
                        $stmt->execute();
                        $users = $stmt->fetchAll();

                        if (!$users) {
                            //แสดงข้อความ No data available เมื่อไม่มีข้อมูล
                            echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                        } else {
                        foreach($users as $user)  {  
                        ?>

                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="rounded" width="100%" src="img_db/<?php echo $user['img']; ?>" alt="">                            
                            <div class="card-body">


                                <b><?php echo $user['topic']; ?> </b>
                                <p class="card-text"><?php echo $user['content']; ?> </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                    </div>
                                    <small class="text-body-secondary">Reviewer: <?php echo $user['reviewer']; ?></small>
                                    
                                </div>

                                <!-- Star Rating -->
                                <div class="container d-flex justify-content-center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="stars">
                                                <form action="">
                                                    <input class="star star-5" id="<?php echo $user['idcontent']; ?>star-5" type="radio" name="star"/>
                                                    <label class="star star-5" for="<?php echo $user['idcontent']; ?>star-5"></label>
                                                    <input class="star star-4" id="<?php echo $user['idcontent']; ?>star-4" type="radio" name="star"/>
                                                    <label class="star star-4" for="<?php echo $user['idcontent']; ?>star-4"></label>
                                                    <input class="star star-3" id="<?php echo $user['idcontent']; ?>star-3" type="radio" name="star"/>
                                                    <label class="star star-3" for="<?php echo $user['idcontent']; ?>star-3"></label>
                                                    <input class="star star-2" id="<?php echo $user['idcontent']; ?>star-2" type="radio" name="star"/>
                                                    <label class="star star-2" for="<?php echo $user['idcontent']; ?>star-2"></label>
                                                    <input class="star star-1" id="<?php echo $user['idcontent']; ?>star-1" type="radio" name="star"/>
                                                    <label class="star star-1" for="<?php echo $user['idcontent']; ?>star-1"></label>
                                                </form>
                                            </div>                                                        
                                        </div>                                          
                                    </div>
                                </div>
                                
                                
                            </div>                       
                        </div>
                    </div> 

                    <?php }  } ?> 

                </div>
            </div>
        </div>                   
   
   


    <!-- Footer -->
        <div class="container">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <div class="col-md-4 d-flex align-items-center">
                    <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
                    </a>
                    <span class="mb-3 mb-md-0 text-body-secondary">© 2024 Company, Inc</span>
                </div>
            
                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                    <li class="ms-3"><a class="text-body-secondary" href="#"><img class="d-block mx-auto mb-4" src="config/web_img/eat-yummy.gif" width="24" height="24"><use xlink:href="#twitter"></use></img></a></li>
                    <li class="ms-3"><a class="text-body-secondary" href="#"><img class="d-block mx-auto mb-4" src="config/web_img/eat-yummy.gif" height="24"><use xlink:href="#instagram"></use></img></a></li>
                    <li class="ms-3"><a class="text-body-secondary" href="#"><img class="d-block mx-auto mb-4" src="config/web_img/eat-yummy.gif" height="24"><use xlink:href="#facebook"></use></img></a></li>
                </ul>
            </footer>
        </div>


    <script src="js/bootstrap.min.js"></script>
</body>
</html>