<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>

    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="<?php echo base_url("public/css/style.css") ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
    </script>
</head>

<body>
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="./index.php" class="nav-link px-2 text-secinondary">Home</a></li>
                    <li><a href="./about.php" class="nav-link px-2 text-white">About us</a></li>
                    <li><a href="./services.php" class="nav-link px-2 text-white">Services</a></li>
                    <li><a href="./contact.php" class="nav-link px-2 text-white">Contact us</a></li>
                </ul>
                <div class="float-end ">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="public/img/avatar4.jpg" style="border:1px solid #ccc; border-radius:50%" width=" 32"
                            height="32">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="<?php echo base_url("auth") ?>">Login
                            </a>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a href="<?php echo base_url('auth/signUp') ?>" class="dropdown-item"
                                id="btn-logout">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</body>
</body>

</html>