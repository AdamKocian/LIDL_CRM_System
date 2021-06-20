<?php

session_start();
$connect = new PDO('mysql:host=localhost;dbname=lidl_db', 'root', '');

$data = array();

$query = "SELECT task_list.id, task_list.title, task_list.start, task_list.end, category_list.category_color AS color FROM task_list JOIN category_list ON category_list.id = task_list.task_id WHERE task_list.project_id = " . $_SESSION['project_id'];

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