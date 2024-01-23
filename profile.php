<?php
require_once "header.php";
require_once "Database.php";
require_once "PlagiarismData.php";
$PlagiarismData = new PlagiarismData();

$userId = $_SESSION['user_id'];
$userData = $PlagiarismData->getUser($userId);
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);


    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please provide a valid email address";
    }

    if (empty($username)) {
        $errors['username'] = "Username is required";
    }

    if ($userData) {
        //check if password do match
        $hashedPassword = $userData['password'];
 
        $verify = password_verify($password, $hashedPassword);

        if ($verify) {
            //update the profile
            $result = $PlagiarismData->updateUser($userId, ["username" => $username, "email" => $email]);

            if ($result)
                $success = "User details updated";
            else
                $errors['error'] = "Something went wrong try again";
        } else {
            $errors['error'] = "Invalid password";
        }
    } else {
        $errors['error'] = "Failed to confirm user details";
    } 

}


?>

<div class="container">
    <div class="row my-4">
        <div class="col-12 d-flex justify-content-center">
            <h4>My Profile</h4>
        </div>
        <div class="col-12 d-flex flex-column align-items-center justify-content-center">
            <?php if (isset($success)): ?>
                <span class="alert alert-success p-2 col-4">
                    <?= $success ?>
                </span>
            <?php elseif (isset($errors['error'])): ?>
                <span class="alert alert-danger p-2 col-4">
                    <?= $errors['error'] ?>
                </span>
            <?php endif ?>
            <form method="POST" class="col-4 mt-2 border shadow-sm p-4">
                <div class="form-floating mb-3">
                    <input type="username" name="username" required class="form-control" id="username"
                        placeholder="Username" value="<?= isset($userData['username']) ? $userData['username'] : NULL ?>">
                    <label for="username">Username</label>
                    <?php if (isset($errors['username'])): ?>
                        <small class="text-danger">
                            <?= $errors['username'] ?>
                        </small>
                    <?php endif ?>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" required class="form-control" id="email"
                        placeholder="name@example.com" value="<?= isset($userData['email']) ? $userData['email'] : NULL ?>">
                    <label for="email">Email address</label>
                    <?php if (isset($errors['email'])): ?>
                        <small class="text-danger">
                            <?= $errors['email'] ?>
                        </small>
                    <?php endif ?>
                </div>
                <div class="form-floating">
                    <input type="password" name="password" required class="form-control" id="password"
                        placeholder="Password">
                    <label for="password">Confirm with Password</label>
                </div>

                <div class="input-group pt-4">
                    <button type="submit" class="btn btn-success rounded-pill">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "footer.php" ?>