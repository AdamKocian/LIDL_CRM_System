<?php

//delete.php

if(isset($_POST["id"]))
{
 $connect = new PDO('mysql:host=localhost;dbname=tms_db', 'root', '');
 $query = "
 DELETE from user_productivity WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>