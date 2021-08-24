<?php
require_once dirname(__FILE__) . "/../env_variables.php";
// logging
// console logs to browser using javascript
function concatPaths(...$paths)
{
    $toReturn = array_shift($paths);
    foreach ($paths as $path) {
        if ($path != "") {
            $toReturn .=  "/" . $path;
        }
    }
    return  $toReturn;
}

function consoleLog(...$args)
{
    $echoedString = "<script>console.log(" . "`" . array_shift($args) . "`";

    foreach ($args as $strings) {
        $echoedString .= ", `" . $strings . "`";
    }

    $echoedString .= ");</script>";

    echo $echoedString;
}

function getVariableParentPath($fullPath, $levelsUp)
{
    $path = parse_url($fullPath)["path"];
    $pathArr  = explode("/", $path);
    $discardedChilds = array_slice($pathArr,  0, -$levelsUp);
    return implode("/", $discardedChilds);
}

function pretty($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

// login utilities
// sets session based on user email
function setSession($email)
{
    $db = new Database();
    $userID = $db->getIdFromEmail($email);
    $_SESSION["userID"] =  $userID;
    $db->disconnect();
};

// stop user session
function unSetSession()
{
    $_SESSION["userID"] =  '';
    session_destroy();
}

function registerUser($firstName, $lastName, $email, $password, $gender)
{
    $db = new Database();
    $passwordHash = $password; //md5($password);
    $cols = array("email", "first_name", "last_name", "password", "gender");
    $values = array($email, $firstName, $lastName, $passwordHash, $gender);
    $db->insert($cols, $values, "user");
}

function processLogin($email, $password)
{
    $db = new Database();
    $passwordHash = $password; //md5($password);

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
    consoleLog($validCreds ? "true" : "false");
    return $validCreds;
    // else die because multiple records
}




// database class call it to establish mysql connection
class Database
{
    private const DB_HOST = 'localhost';
    private const DB_PASSWORD = '';
    private const DB_USER = 'root';
    private const DB_NAME = 'assignment';

    public $con;
    public $queryResult;

    private const tableColNames = array(
        "administrator" => array(
            "admin_id",
            "password",
            "first_name",
            "last_name"
        ),
        "user" => array(
            "user_id",
            "email",
            "first_name",
            "last_name",
            "password",
            "gender"
        ),
        "display_event" => array(
            "Event_Title",
            "Event_Description",
            "Event_Price"
        ),
        "participants" => array(
            "user_id",
            "last_name",
            "first_name",
            "gender",
            "Event_Title_FK"
        )
    );

    function __construct()
    {
        $this->con = mysqli_connect(self::DB_HOST, self::DB_USER, self::DB_PASSWORD, self::DB_NAME);
        if (mysqli_connect_error($this->con)) {
            die('Connect Error (' . mysqli_connect_errno($this->con) . ') '
                . mysqli_connect_error($this->con));
        }
    }

    function disconnect()
    {
        if (!is_null($this->queryResult) && !is_bool($this->queryResult)) {
            mysqli_free_result($this->queryResult);
        }
        mysqli_close($this->con);
    }

    function select($columnArray, $whereStatements, $table = 'user', $fetchAll = true)
    {
        if (array_intersect($columnArray, self::tableColNames[$table]) != $columnArray && $columnArray[0] != "*") {
            consoleLog("Invalid column name");
            return null;
        }

        $queryStatement = "SELECT " . array_shift($columnArray);
        foreach ($columnArray as $col) {
            $queryStatement .= ", $col";
        }

        if ($whereStatements == "") {
            $queryStatement .= " FROM $table";
        } else {
            $queryStatement .= " FROM $table WHERE $whereStatements;";
        }

        $this->queryResult = mysqli_query($this->con, $queryStatement);
        if (!$this->queryResult) {
            consoleLog("No Results Found for query : ", $queryStatement);
        }

        return mysqli_fetch_all($this->queryResult);
    }

    function getQueryResult()
    {
        return $this->queryResult;
    }

    function insert($columnArray, $values, $table = 'user')
    {
        // please make sure to pass exactly the same amount of 
        // values corresponding to the amount of columns
        // did not make a validation for that
        if (array_intersect($columnArray, self::tableColNames[$table]) != $columnArray) {
            consoleLog("Invalid column name");
            return null;
        }

        $queryStatement = "INSERT INTO $table (" . array_shift($columnArray);
        foreach ($columnArray as $col) {
            $queryStatement .= ", $col";
        }
        $queryStatement .= ") VALUES ('" . array_shift($values) . "'";

        foreach ($values as $value) {
            $queryStatement .= ", '$value'";
        }

        $queryStatement .= ");";

        $this->queryResult = $this->con->query($queryStatement);

        if ($this->con->errno == 1062) {
            throw new Exception(mysqli_error($this->con), mysqli_errno($this->con));
        }
        consoleLog($this->queryResult);
    }

    function update($columnArray, $values, $whereStatement, $table = 'user')
    {
        if (array_intersect($columnArray, self::tableColNames[$table]) != $columnArray) {
            consoleLog("Invalid column name");
            return null;
        }

        $queryStatement = "UPDATE $table SET ";

        for ($i = 0; $i < count($columnArray); $i++) {
            $queryStatement .= "{$columnArray[$i]} = '{$values[$i]}', ";
        }
        $queryStatement = rtrim($queryStatement, ", ");

        $queryStatement .= " WHERE $whereStatement;";
        $this->queryResult = mysqli_query($this->con, $queryStatement);
        if ($this->queryResult) {
            return true;
        }
        return false;
    }

    function getIdfromEmail($email)
    {
        $whereStatement = "email = '$email'";
        return $this->select(array("user_id"), $whereStatement)[0][0];
    }

    function loginPasswordEmail($email, $passwordHash)
    {
        $colArray = array(
            "email", "password"
        );
        $whereStatement = "email = '$email' AND password = '$passwordHash'";
        return $this->select($colArray, $whereStatement);
    }

    function loginPasswordAdmin($adminID, $passwordHash)
    {
        $colArray = array(
            "admin_id", "password"
        );
        $whereStatement = "admin_id = '$adminID' AND password = '$passwordHash'";
        return $this->select($colArray, $whereStatement, "administrator");
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

function validifyNames($firstName, $lastName)
{
    $regExp = "/^[a-zA-Z\s]$/";
    $validFirstName = false;
    $validLastName = false;

    if (!empty($firstName) && preg_match($regExp, $firstName)) {
        $validFirstName = true;
    }

    if (!empty($firslastNametName) && preg_match($regExp, $lastName)) {
        $validLastName = true;
    }

    return $validFirstName && $validLastName;
}
