<?php

session_start();
$connect = new PDO('mysql:host=localhost;dbname=lidl_db', 'root', '');

$data = array();

$query = "
SELECT * FROM task_list WHERE project_id = " . $_SESSION['project_id'];

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["title"],
  'start'   => $row["start"],
  'end'   => $row["end"],
  'color'   => $row["color"]

 );
}

echo json_encode($data);

?>