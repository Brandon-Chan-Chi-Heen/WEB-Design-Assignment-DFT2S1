<?php
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
// if admin

// if user
// suggestions

// results 

function search($toSearch, $colArray, $toSearchColArray, $table, $orderCol = false, $sort = "ASC")
{
    if (!$orderCol) {
        $orderCol = $colArray[0];
    }
    $terms = explode(" ", $toSearch);

    // array unique
    $db = new Database();
    $finalResult =  array();
    $whereStatement = "";
    foreach ($toSearchColArray as $col) {
        foreach ($terms as $term) {
            $whereStatement .= "$col LIKE '%$term%' OR ";
        }
    }
    $whereStatement = rtrim($whereStatement, " OR");
    $whereStatement = "$whereStatement ORDER BY $orderCol $sort";

    consoleLog($whereStatement);
    $finalResult = $db->select($colArray, $whereStatement, $table);
    $db->disconnect();
    return $finalResult;
}
