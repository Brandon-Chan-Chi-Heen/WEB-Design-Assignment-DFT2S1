<?php
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";

function unsetEditSessions()
{
    $_SESSION["cur_edit_id"] = "";
}
function setAdminSession($adminID)
{
    $db = new Database();
    $_SESSION["adminID"] =  $adminID;
    $db->disconnect();
};

// stop user session
function unSetAdminSession()
{
    $_SESSION["adminID"] =  '';
    session_destroy();
}

function processAdminLogin($adminID, $password)
{
    $db = new Database();
    $passwordHash = $password; //md5($password);

    $result = $db->loginPasswordAdmin($adminID, $passwordHash);

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
}
