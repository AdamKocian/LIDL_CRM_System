<?php

$db_exists = file_exists("daypilot.sqlite");

$db = new PDO('sqlite:daypilot.sqlite');

if (!$db_exists) {
    //create the database
    $db->exec("CREATE TABLE events (
        id          INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
        name        TEXT,
        start       DATETIME,
        [end]       DATETIME,
        resource_id INTEGER
    );");

    $db->exec("CREATE TABLE groups (
        id   INTEGER       NOT NULL PRIMARY KEY,
        name VARCHAR (200)
    );");

    $db->exec("CREATE TABLE resources (
        id       INTEGER       PRIMARY KEY AUTOINCREMENT
                               NOT NULL,
        name     VARCHAR (200),
        group_id INTEGER
    );");

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
