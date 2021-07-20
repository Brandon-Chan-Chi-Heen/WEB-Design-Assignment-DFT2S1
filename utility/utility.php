<?php
// logging
// console logs to browser using javascript
function consoleLog(...$args)
{
    $echoedString = "<script>console.log(" . "\"" . array_shift($args) . "\"";

    foreach ($args as $strings) {
        $echoedString .= ", \"" . $strings . "\"";
    }

    $echoedString .= ");</script>";

    echo $echoedString;
}

// login utilities
// sets session based on user email
function setSession($email)
{
    session_start();
    $db = new Database();
    $userName = $db->getFullNameWithEmail($email);
    $_SESSION["fullName"] =  $userName;
    $db->disconnect();
};


// stop user session
function unSetSession()
{
    session_start();
    $db = new Database();
    $_SESSION["fullName"] =  '';
    session_destroy();
    $db->disconnect();
    header('location: ../Sign_In/Sign_In.php');
}

function processLogin($email, $password)
{
    $db = new Database();
    $passwordHash = md5($password);

    $result = $db->loginPasswordEmail($email, $passwordHash);

    if (is_null($result)) {
        $db->disconnect();
        consoleLog("invalid column values for query");
        return false;
    }
    $arrayCount = count($result);
    $validCreds = false;
    if ($arrayCount === 1) {
        $validCreds = true;
    }

    $db->disconnect();
    return $validCreds;
    // else die because multiple records
}

// database class call it to establish mysql connection

class Database
{
    private const DB_HOST = 'localhost';
    private const DB_PASSWORD = 'assignment';
    private const DB_USER = 'Assignment';
    private const DB_NAME = 'assignment';

    private $con;
    private $queryResult;

    private const tableColNames = array(
        "user" => array(
            "user_id",
            "email",
            "first_name",
            "last_name",
            "password"
        )
    );

    function __construct()
    {
        $this->con = mysqli_connect(self::DB_HOST, self::DB_USER, self::DB_PASSWORD, self::DB_NAME);
    }

    function disconnect()
    {
        $this->queryResult->free();
        $this->con->close();
    }

    function select($columnArray, $whereStatements, $table = 'user')
    {
        if (array_intersect($columnArray, self::tableColNames[$table]) != $columnArray) {
            consoleLog("Invalid column name");
            return null;
        }

        $queryStatement = "SELECT " . array_shift($columnArray);
        foreach ($columnArray as $col) {
            $queryStatement .= ", $col";
        }

        $queryStatement .= " FROM $table WHERE $whereStatements;";

        $this->queryResult = $this->con->query($queryStatement);
        return $this->queryResult->fetch_all();
    }

    function getIdfromEmail($email)
    {
        $whereStatement = "email = '$email'";
        return $this->select(array("email"), $whereStatement);
    }

    function loginPasswordEmail($email, $passwordHash)
    {
        $colArray = array(
            "email", "password"
        );
        $whereStatement = "email = '$email' AND password = '$passwordHash'";
        return $this->select($colArray, $whereStatement);
    }

    function getFullNameWithEmail($email)
    {
        $colArray = array(
            "first_name", "last_name"
        );
        $whereStatement = "email = '$email'";
        $nameArray = $this->select($colArray, $whereStatement)[0];
        $fullName = $nameArray[0] . ' ' .  $nameArray[1];
        return $fullName;
    }
}

function validifyLoginData($email, $password)
{
    $validEmail = false;
    if (!empty($email) && preg_match("/^[a-zA-Z0-9.!#\/$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $email)) {
        $validEmail = true;
        consoleLog("valid email");
    } else {
        consoleLog("invalid email");
    }

    $emptyPassword = true;
    if (!empty($password)) {
        $emptyPassword = false;
        consoleLog("non empty password");
    } else {
        consoleLog("empty password");
    }

    return $validEmail && !$emptyPassword;
}
