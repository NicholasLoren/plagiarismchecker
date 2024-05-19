<?php

require_once("./Database.php");
require_once("./PlagiarismData.php");
$PlagiarismData = new PlagiarismData();

//Register user if data is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $PlagiarismData->escape($_POST['email']);
    $password = $PlagiarismData->escape($_POST['password']);
    $confirmPassword = $PlagiarismData->escape($_POST['confirm-password']);
    $errors = array();

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please provide a valid email address";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    }

    if (empty($confirmPassword)) {
        $errors['confirm-password'] = "Confirm Password is required";
    }

    if ($password !== $confirmPassword) {
        $errors['confirm-password'] = "Passwords should match";
    }

    //Save user to database 
    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $username = (explode("@", $email))[0];

        $user = $PlagiarismData->addUser(['email' => $email, 'password' => $password, 'username' => $username]);
        if (empty($PlagiarismData->reportError())) {
            $success = "Account created successfully. <a href='login.php' class='fw-bold text-black text-decoration-none'>Login here</a>";
        } else {
            $errors['error'] = "Could not establish connection. Try again later"; 
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
    <?php if (isset($success) && !empty($success)): ?>
        <span class="alert alert-success">
            <?= $success ?>
        </span>
    <?php elseif (isset($errors['error'])): ?>
        <span class="alert alert-danger">
            <?= $errors['error'] ?>
        </span>
    <?php endif ?>
    <form method="POST" class="col-4 mt-2 border shadow-sm p-4">
        <h6 class="text-muted text-center mb-3">To get started <br>Create a new account with us today. </h6>
        <div class="form-floating mb-3">
            <input type="email" name="email" required class="form-control" id="floatingInput"
                placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
            <?php if (isset($errors['email'])): ?>
                <small class="text-danger">
                    <?= $errors['email'] ?>
                </small>
            <?php endif ?>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="password" required class="form-control" id="floatingPassword"
                placeholder="Password">
            <label for="floatingPassword">Password</label>
            <?php if (isset($errors['password'])): ?>
                <small class="text-danger">
                    <?= $errors['password'] ?>
                </small>
            <?php endif ?>
        </div>
        <div class="form-floating">
            <input type="password" name="confirm-password" required class="form-control" id="floatingPassword"
                placeholder="Confirm Password">
            <label for="floatingPassword">Confirm Password</label>
            <?php if (isset($errors['confirm-password'])): ?>
                <small class="text-danger">
                    <?= $errors['confirm-password'] ?>
                </small>
            <?php endif ?>
        </div>
        <div class="d-flex justify-content-between mt-3">
            <a href="login.php" class="text-decoration-none text-success fw-medium">Login here instead</a>
            <button type="submit" class="btn btn-success rounded-pill">Signup</button>
        </div> 
    </form>
</body>