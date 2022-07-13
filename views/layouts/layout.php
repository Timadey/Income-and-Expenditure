<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <!-- <link rel="stylesheet" href="../assets/js/sweet_alert/package/dist/sweetalert2.min.css"> -->
        <link rel="stylesheet" href="assets/css/style.css">

        <title><?php echo $page_title; ?></title>
    </head>

    <body style="padding: 10px">
        <header class="p-3 bg-white text-dark fixed-top">
            <div class="container">
                <div class="d-flex flex-wrap align-items-right justify-content-center justify-content-lg-start">
                    <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                        <img src="/assets/img/bootstrap/bootstrap.svg" alt="Bootstrap" width="32" height="32"><b>udget</b></a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="/" class="nav-link px-2 text-dark">Home</a></li>
                        <li><a href="/book/add" class="nav-link px-2 text-dark">Add New Book</a></li>
                        <li><a href="#" class="nav-link px-2 text-dark">Transactions</a></li>
                        <li><a href="#" class="nav-link px-2 text-dark">About</a></li>
                    </ul>

                    <?php echo !isset($_SESSION['user_id']) ? "<div class='text-end'>
                        <a href='/login'><button type='button' class='btn btn-outline-dark me-2'>Login</button></a>
                        <a href='/register'><button type='button' class='btn btn-outline-primary me-2'>Sign-up</button></a></div>" : $_SESSION['email'].
                        "<a href='/logout' class='nav-link px-2 text-danger'>(Logout)</a></div>";
                    ?>
                </div>
            </div>
        </header>


        <div class="container" style="padding-top:100px">
            <?php 
                echo ($_SESSION['msg']) ?? "";
                unset($_SESSION['msg']);
                echo $content; 
            ?>
        </div>


        <div class="container">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top ">
                <div class="col-md-4 d-flex align-items-center">
                    <a href="#" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                        <img src="/assets/img/bootstrap/bootstrap.svg" alt="Bootstrap" width="32" height="32"><b>udget</b>
                    </a>
                    <span class="text-muted">© 2022 Timadey, Inc</span>
                </div>

                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                    <li class="ms-3"><a class="text-muted" href="https://www.twitter.com/iamtimadey"><img src="/assets/img/bootstrap/twitter.svg" alt="Bootstrap" width="32" height="32"></a></li>
                    <li class="ms-3"><a class="text-muted" href="https://www.github.com/timadey"><img src="/assets/img/bootstrap/github.svg" alt="Bootstrap" width="32" height="32"></a></li>
                    <li class="ms-3"><a class="text-muted" href="#"><img src="/assets/img/bootstrap/facebook.svg" alt="Bootstrap" width="32" height="32"></use></svg></a></li>
                </ul>
            </footer>
        </div>


        <!-- <script src="../assets/js/sweet_alert/package/dist/sweetalert2.min.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->
        <script src="assets/js/my-login.js"></script>
        <!-- <script src="../assets/js/jquery/jquery.js"></script> -->
    </body>
</html>