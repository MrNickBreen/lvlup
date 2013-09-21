<?php
header('Access-Control-Allow-Origin: *');
//makes connection to database
require 'config.php';

if (isset($_GET['id'])) {
  $id=$_GET['id'];

  $query="SELECT users.id, users.name, users.img
    FROM users
    WHERE users.id=".$id." LIMIT 0,1";

  $result = mysql_query($query)or die($query . " -\n ".mysql_error());

  header('Content-type: application/json');
  $tmpUser = null;
  if(is_resource($result) && mysql_num_rows($result) > 0 ){
    $row = mysql_fetch_array($result);
    $tmpUser = array("id" => $row['id'],
    "name" => $row['name'],
    "img" => $row['img'],
    "activities" => getUserActivities($id));
  }

  if ($tmpUser != null) {
    echo json_encode(array("success"=>true, "result" => $tmpUser));
  }
}
else {
  echo json_encode(array("success"=>false, "result" => 'What user are you trying to lookup?'));
}
  mysql_close($con);

  function getUserActivities($userId) {
    $query="SELECT activities.id, activities.name, users_activities.date_created, users_activities.exertion, users_activities.rejuvenation, users_activities.hours
      FROM users_activities
      INNER JOIN activities
      ON activities.id=users_activities.activity_id
      WHERE  users_activities.user_id=".$userId;

    $activities = array();

    $result = mysql_query($query)or die($query . " -\n".mysql_error());
    while($row = mysql_fetch_array($result)){
            $activities[] = array("id" => $row['id'], "name" => $row['name'], "date_created" => $row['date_created'], "exertion" => $row['exertion'], "rejuvenation" => $row['rejuvenation'], "hours" => $row['hours']);
    }
    return $activities;
  }
?>