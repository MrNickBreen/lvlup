<?php
header('Access-Control-Allow-Origin: *');
//makes connection to database
require 'config.php';

 $query="SELECT users.id, users.name, users.img
    FROM users";
if (isset($_GET['id'])) {
  $query.=" WHERE users.id=".$_GET['id']." LIMIT 0,1";
}

$result = mysql_query($query)or die($query . " -\n ".mysql_error());

header('Content-type: application/json');
$tmpUser = null;
$users = array();
while ($row = @mysql_fetch_assoc($result)){
  $tmpUser = array("id" => $row['id'],
  "name" => $row['name'],
  "img" => $row['img']);
  //,
  //"activities" => getUserActivities($row['id']));

  $users[] = $tmpUser;
}

if ($users != array()) {
  if (sizeof($users) == 1) {
    $users = $users[0];
  }
    echo json_encode(array("user"=> $users));
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