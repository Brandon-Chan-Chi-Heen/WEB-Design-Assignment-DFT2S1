<?php
$PAGE_TITLE = 'Ticketing';
    include('includes/index.php');
?>
<div>
        <h1>Participant side</h1>
        <?php
            require_once('includes/helper.php');
            
             $id      = '';
            $name    = '';
            $gender  = '';
            $program = '';
            
            if (!empty($_POST)) // Something posted back.
            
            $id      = strtoupper(trim($_POST['id']));
                $name    = trim($_POST['name']);
                $gender  = trim($_POST['gender']);
                $program = trim($_POST['program']);
                
                // Validations.
                $error['id']      = validateStudentID($id);
                $error['name']    = validateStudentName($name);
                $error['gender']  = validateGender($gender);
                $error['program'] = validateProgram($program);
                $error = array_filter($error); // Remove null values.
class Ticketing {
    //put your code here
}
