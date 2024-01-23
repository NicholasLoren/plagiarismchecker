<?php
session_start();

$loggedIn = $_SESSION['loggedIn'];
$profileImage = $_SESSION['image'];

if (!$loggedIn) {
    header("location:login.php");
} 

?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Plagiarism Checker</title>
    <link rel="stylesheet" href="./assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/custom.css">
    <link rel="shortcut icon" href="./assets/images/logo.svg" type="image/svg+xml">
    <script src="./assets/jquery/jquery.js" defer=""></script>
    <script src="./assets/circle-progressbar/circle-progress.min.js" defer=""></script>
</head> 
<body class="roboto h-100  bg-tree">

    <nav class="navbar navbar-expand-lg bg-success">
        <div class="container">
            <a class="navbar-brand text-white text-uppercase" href="./">
                <img alt="Logo" width="30" height="24" src="./assets/images/logo.svg"
                    class="d-inline-block align-text-center ">
                Assignment Plagiarism Checker
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav w-100   mb-2 mb-lg-0 justify-content-end align-items-center d-flex">
                    <li class="nav-item">
                        <a class="nav-link  text-white text-uppercase font-weight-bolder" href="index.php">Plagiarism
                            check</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  text-white text-uppercase font-weight-bolder" href="all-reports.php">Reports</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="./assets/profiles/<?= $profileImage ?>" width="30" height="24"
                                class="border rounded-circle" alt="">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item " href="./profile.php">My Profile</a></li>
                            <li><a class="dropdown-item " href="javascript:void(0)"
                                    onclick="copyToClipboard('https://pladiarismchecker.com')">Invite Friends</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item " href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>