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
                    <img src="assets/img/bootstrap/bootstrap.svg" alt="Bootstrap" width="32" height="32"><b>udget</b></a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="" class="nav-link px-2 text-dark">Home</a></li>
                    <li><a href="" class="nav-link px-2 text-dark">Books</a></li>
                    <li><a href="" class="nav-link px-2 text-dark">Transactions</a></li>
                    <li><a href="" class="nav-link px-2 text-dark">About</a></li>
                </ul>

                <?php echo !isset($_SESSION['user_id']) ? "<div class='text-end'>
                    <a href='authenticate/login.php'><button type='button' class='btn btn-outline-dark me-2'>Login</button></a>
                    <a href='authenticate/signup.php'><button type='button' class='btn btn-outline-primary me-2'>Sign-up</button></a></div>" : $_SESSION['email'].
                    "<a href='logout.php' class='nav-link px-2 text-danger'>(Logout)</a></div>";
                ?>
                


            </div>
        </div>
    </header>
    <div class="container" style="padding:100px">