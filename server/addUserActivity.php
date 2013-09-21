<?php
header('Access-Control-Allow-Origin: *');
// TODO: mysql_query is being retired, change DB access to use the new command.
// TODO: this code is suseptiable to sql attacks, however, will be fixed when we upgrade to new DB access: http://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php

require 'config.php'; //makes connection to database

if (isset($_POST['userId']) && isset($_POST['activityId']) && isset($_POST['exertion']) && isset($_POST['rejuvenation']) && isset($_POST['hours'])) {

        $query="INSERT INTO users_activities(user_id, activity_id, exertion, rejuvenation, hours)
                VALUES ('".$_POST['userId']."', '".$_POST['activityId']."', '".$_POST['exertion']."', '".$_POST['rejuvenation']."', '".$_POST['hours']."');";

        $result = mysql_query($query)or die($query."   - ".mysql_error());
        $usersActivitiesId = mysql_insert_id();

        // TODO: extract this code into a method with parameters success and result text.
        echo json_encode(array("success"=>true, "result" => $usersActivitiesId));
}
else {
        echo json_encode(array("success"=>false, "result" => 'Error with adding activity. Did you fill out all the parameters?'));
}
mysql_close($con);
?>