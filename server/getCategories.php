<?php
header('Access-Control-Allow-Origin: *');
//makes connection to database
require 'config.php';
$query='SELECT id,parent_id,name, description
                FROM categories
                ORDER BY parent_id ASC';

$result = mysql_query($query);
if (!$result) {
  die("Error on getCategories: " . mysql_error()."  Query: ".$query);
}

header('Content-type: application/json');

// Iterate through the rows, json entries for each
while ($row = @mysql_fetch_assoc($result)){
  $tmpCategory = array("id" => $row['id'],
  "parent_id" => $row['parent_id'],
  "name" => $row['name'],
  "description" => $row['description']);

  $json[] = $tmpCategory;
}

echo json_encode($json);
mysql_close($con);
?>