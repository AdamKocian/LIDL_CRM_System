<?php
$host = "127.0.0.1";
$port = 3306;
$username = "username";
$password = "password";
$database = "html5-scheduler";

$db = new PDO("mysql:host=$host;port=$port",
               $username,
               $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE DATABASE IF NOT EXISTS `$database`");
$db->exec("use `$database`");

function tableExists($dbh, $id)
{
    $results = $dbh->query("SHOW TABLES LIKE '$id'");
    if(!$results) {
        return false;
    }
    if($results->rowCount() > 0) {
        return true;
    }
    return false;
}

$exists = tableExists($db, "resources");

if (!$exists) {

    //create the database
    $db->exec("CREATE TABLE IF NOT EXISTS events (
        id INTEGER  PRIMARY KEY AUTO_INCREMENT NOT NULL,
        name TEXT,
        start DATETIME,
        end DATETIME,
        resource_id VARCHAR(30))");

    $db->exec("CREATE TABLE groups (
        id INTEGER  PRIMARY KEY NOT NULL,
        name VARCHAR(200)  NULL)");

    $db->exec("CREATE TABLE resources (
        id INTEGER  PRIMARY KEY AUTO_INCREMENT NOT NULL,
        name VARCHAR(200)  NULL,
        group_id INTEGER  NULL)");

  // group data
  $items = array(
      array('id' => 1, 'name' => 'People'),
      array('id' => 2, 'name' => 'Tools')
  );

  $insert = "INSERT INTO groups (id, name) VALUES (:id, :name)";
  $stmt = $db->prepare($insert);

  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':name', $name);

  foreach ($items as $item) {
    $id = $item['id'];
    $name = $item['name'];
    $stmt->execute();
  }

  // resource data
  $items = array(
      array('name' => 'Person 1', 'group_id' => 1),
      array('name' => 'Person 2', 'group_id' => 1),
      array('name' => 'Person 3', 'group_id' => 1),
      array('name' => 'Person 4', 'group_id' => 1),
      array('name' => 'Tool 1', 'group_id' => 2),
      array('name' => 'Tool 2', 'group_id' => 2),
      array('name' => 'Tool 3', 'group_id' => 2),
      array('name' => 'Tool 4', 'group_id' => 2)
  );

  $insert = "INSERT INTO resources (name, group_id) VALUES (:name, :group_id)";
  $stmt = $db->prepare($insert);

  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':group_id', $group_id);

  foreach ($items as $item) {
    $name = $item['name'];
    $group_id = $item['group_id'];
    $stmt->execute();
  }
}