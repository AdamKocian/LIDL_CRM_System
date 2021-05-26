<?php

if(isset($_POST["id"]))
{
 $connect = new PDO('mysql:host=localhost;dbname=lidl_db', 'root', '');
 $query = "
 DELETE from task_list WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>