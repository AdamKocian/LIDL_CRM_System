<?php

$connect = new PDO('mysql:host=localhost;dbname=lidl_db', 'root', '');

if(isset($_POST["id"]))
{
 $query = "
 UPDATE user_productivity 
 SET title=:title, start=:start, end=:end 
 WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start' => $_POST['start'],
   ':end' => $_POST['end'],
   ':id'   => $_POST['id']
  )
 );
}

?>