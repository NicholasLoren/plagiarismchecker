<?php


abstract class Database
{
    private $USERNAME = "root";
    private $DATABASE_NAME = "plagiarism";
    private $HOST_NAME = "localhost";
    private $DATABASE_PASSWORD = "";
    private $DB_CONNECTION = NULL;

    public function __construct()
    {
        $this->DB_CONNECTION = mysqli_connect($this->HOST_NAME, $this->USERNAME, $this->DATABASE_PASSWORD, $this->DATABASE_NAME);
    }

    public function query(string $query)
    {
        return mysqli_query($this->DB_CONNECTION, $query);
    }

    public function reportError()
    {
        return mysqli_error($this->DB_CONNECTION);
    }

    public function escape(string $word)
    {
        return mysqli_real_escape_string($this->DB_CONNECTION, trim($word));
    }

    function numRows($result)
    {
        return mysqli_num_rows($result);
    }
    function fetchAssoc($result)
    {
        return mysqli_fetch_assoc($result);
    }
    function fetchAllAssoc($result)
    {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

}