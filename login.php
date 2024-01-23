<?php
require_once("./Database.php");
require_once("./PlagiarismData.php");
$PlagiarismData = new PlagiarismData();

//Register user if data is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $PlagiarismData->escape($_POST['email']);
    $password = $PlagiarismData->escape($_POST['password']);
    $errors = array();

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please provide a valid email address";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    }


    //Save user to database 
    if (empty($errors)) { 
        $user = $PlagiarismData->login($email);

        if (!$user) {
            $errors['error'] = "Invalid email or password";
        } else {
            $passwordHashed = $user['password'];

            //verify password
            $verify = password_verify($password, $passwordHashed);

            if (!$verify) {
                $errors['error'] = "Invalid email or password"; 
            }else{
                //redirect user to dashbord
                session_start();
                $_SESSION['loggedIn'] = true;
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['image'] = $user['image'];
                $_SESSION['image'] = $user['image'];
                $_SESSION['created_at'] = $user['created_at'];

                header("location:index.php");

            } 

        }
    }
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
</head>

<body class="min-vh-100 d-flex flex-column justify-content-center align-items-center gap-1 bg-tree">
    <img src="./assets/images/logo.svg" alt="Logo" width="64" height="64">
    <h4 class="text-capitalize mt-2">Assignment Plagiarism Checker</h4> 
    <?php if (isset($errors['error'])): ?>
        <span class="alert alert-danger bg-danger text-white p-2 col-4 text-center">
            <?= $errors['error'] ?>
        </span>
    <?php endif ?>
    <form method="POST" class="col-4 mt-2 border shadow-sm p-4">
        <h6 class="text-muted text-center mb-3">To get started <br>Login with your account credentials </h6>
        <div class="form-floating mb-3">
            <input type="email" name="email" required class="form-control" id="floatingInput"
                placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" required class="form-control" id="floatingPassword"
                placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <div class="d-flex justify-content-between mt-3">
            <a href="javascript:void(0)" title="TO be implemented soon" class="text-decoration-none text-primary fw-medium">Forgot Password?</a>
            <a href="register.php" class="text-decoration-none  text-success fw-medium">Register here</a>
        </div>
        <div class="input-group pt-4">
            <button type="submit" class="btn btn-success rounded-pill">Signin</button>

        </div>
    </form>
</body>