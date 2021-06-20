<?php
require_once '_db.php';
    
$scheduler_groups = $db->query('SELECT id, name FROM lidl_db.team_list ORDER BY name');

class Group {}
class Resource {}

$groups = array();

foreach($scheduler_groups as $group) {
  $g = new Group();
  $g->id = "group_".$group['id'];
  $g->name = $group['name'];
  $g->expanded = true;
  $g->children = array();
  $groups[] = $g;
  
  $stmt = $db->prepare("SELECT users.id, concat(firstname, ' ', lastname) as name FROM lidl_db.users JOIN lidl_db.team_user ON users.id = team_user.user_id WHERE team_user.team_list_id = :group ORDER BY lastname");
  $stmt->bindParam(':group', $group['id']);
  $stmt->execute();
  $scheduler_resources = $stmt->fetchAll();  
  
  foreach($scheduler_resources as $resource) {
    $r = new Resource();
    $r->id = $resource['id'];
    $r->name = $resource['name'];
    $g->children[] = $r;
  }
}

header('Content-Type: application/json');
echo json_encode($groups);