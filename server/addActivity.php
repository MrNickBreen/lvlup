<?php
header('Access-Control-Allow-Origin: *');
// TODO: mysql_query is being retired, change DB access to use the new command.
require 'config.php'; //makes connection to database

if (isset($_POST['name']) && isset($_POST['categories'])) {
        $name=$_POST['name'];
        $description=$_GET['description'];

        $query="SELECT name
                FROM activities
                WHERE name = '$name';";
        $result = mysql_query($query)or die($query."   - ".mysql_error());

        if (mysql_num_rows($result) == 0) {
                $query="INSERT INTO activities(name)
                        VALUES ('$name');";

                $result = mysql_query($query)or die($query."   - ".mysql_error());
                $activityId = mysql_insert_id();

                foreach(json_decode($_POST['categories']) as $categoryId) {
                        $query="INSERT INTO activities_categories(activity_id, category_id)
                                VALUES ('$activityId', '$categoryId');";
                        $result = mysql_query($query)or die($query."   - ".mysql_error());
                }

                echo json_encode(array("success"=>true, "result" => $activityId));
        }
        else {
                echo json_encode(array("success"=>false, "result" => 'This activity already exists. No activity was created.'));
        }
}
mysql_close($con);
?>