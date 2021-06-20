<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM task_list where id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}

$connect = new PDO('mysql:host=localhost;dbname=lidl_db', 'root', '');

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO task_list 
 (title, start, end, project_id, user_id ) 
 VALUES (:title, :start, :end, :project_id, :user_id)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start' => $_POST['start'],
   ':end' => $_POST['end'],
   ':project_id' => $_POST['project_id'],
   ':user_id' => $_POST['user_id']
  )
 );
}
?>