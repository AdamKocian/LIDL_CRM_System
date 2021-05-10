<?php

$connect = new PDO('mysql:host=localhost;dbname=tms_db', 'root', '');

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO user_productivity 
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