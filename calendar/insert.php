<?php

//insert.php

$connect = new PDO('mysql:host=localhost;dbname=tms_db', 'root', '');

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO user_productivity 
 (title, start, end) 
 VALUES (:title, :start, :end)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start' => $_POST['start'],
   ':end' => $_POST['end']
  )
 );
}


?>