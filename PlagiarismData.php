<?php
class PlagiarismData extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addUser(array $userData)
    {
        list("username" => $username, "email" => $email, "password" => $password) = $userData;
        $query = "INSERT INTO users (username,email,password) VALUES('$username','$email','$password')";
        return $this->query($query);
    }

    public function login(string $email)
    {
        $query = "SELECT * FROM users WHERE email ='$email' LIMIT 1";
        $result = $this->query($query);

        if (!empty($this->reportError())) {
            return NULL;
        }

        if ($this->numRows($result) === 1) {
            return $this->fetchAssoc($result);
        } else {
            return NULL;
        }
    }

    public function addUserReport(array $reportData)
    {
        list("userId" => $userId, "reportId" => $reportId) = $reportData;
        $query = "INSERT INTO checks(user_id,report_id) VALUES('$userId','$reportId')";
        return $this->query($query);
    }

    function getAllUserChecks(int $userId)
    {
        $query = "SELECT checks.* FROM checks INNER JOIN users ON users.user_id = checks.user_id WHERE users.user_id = '$userId' ORDER BY checks.created_at DESC";

        $result = $this->query($query);

        return $this->fetchAllAssoc($result);
    }

    function getUser(int $userId)
    {
        $query = "SELECT * FROM users WHERE user_id = '$userId' LIMIT 1";
        $result = $this->query($query);
        return $this->fetchAssoc($result);
    }

    function updateUser(int $userId, $data)
    {
        list("username" => $username, "email" => $email) = $data;
        $query = "UPDATE users SET username='$username', email = '$email' WHERE user_id = '$userId' LIMIT 1";
        return $this->query($query);
    }
}

