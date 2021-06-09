<?php include('db_connect.php') ?>
<?php
$twhere = "";
if ($_SESSION['login_type'] != 1)
  $twhere = "  ";
?>

<div style="font-size: 26px; margin-top: 15px; margin-bottom: 20px;" class="col-12">
  Vitaj späť!<br><b><?php echo $_SESSION['login_name'] ?></b>
</div>

<?php

$where = "";
if ($_SESSION['login_type'] == 2) {
  $where = " where manager_id = '{$_SESSION['login_id']}' ";
} elseif ($_SESSION['login_type'] == 3) {
  $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
}
$where2 = "";
if ($_SESSION['login_type'] == 2) {
  $where2 = " where p.manager_id = '{$_SESSION['login_id']}' ";
} elseif ($_SESSION['login_type'] == 3) {
  $where2 = " where concat('[',REPLACE(p.user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
}
?>

<div class="row">
  <div class="col-md-8">
    <div class="card card-outline card-success">
      <div class="card-header">
        <b>Progres úloh</b>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0 table-hover">
            <colgroup>
              <col width="5%">
              <col width="30%">
              <col width="35%">
              <col width="15%">
              <col width="15%">
            </colgroup>
            <thead>
              <th>#</th>
              <th>Pracovný tím</th>
              <th>Progres</th>
              <th>Stav</th>
              <th></th>
            </thead>
            <tbody>
              <?php
              $i = 1;
              $stat = array("ČAKÁ SA", "ZAČALO", "PREBIEHA", "POZASTAVENÉ", "PO SPLATNOSTI", "SPLNENÉ");
              $where = "";
              if ($_SESSION['login_type'] == 2) {
                $where = " where manager_id = '{$_SESSION['login_id']}' ";
              } elseif ($_SESSION['login_type'] == 3) {
                $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
              }
              $qry = $conn->query("SELECT * FROM team_list $where order by name asc");
              while ($row = $qry->fetch_assoc()) :
                $prog = 0;
                $tprog = $conn->query("SELECT * FROM category_list where project_id = {$row['id']}")->num_rows;
                $cprog = $conn->query("SELECT * FROM category_list where project_id = {$row['id']}")->num_rows; // and status = 3
                $prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
                $prog = $prog > 0 ?  number_format($prog, 0) : $prog;
                $prod = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
                if ($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])) :
                  if ($prod  > 0  || $cprog > 0)
                    $row['status'] = 2;
                  else
                    $row['status'] = 1;
                elseif ($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])) :
                  $row['status'] = 4;
                endif;
              ?>
                <tr>
                  <td>
                    <a style="color: black;" href="./index.php?page=view_team&id=<?php echo $row['id'] ?>">
                      <?php echo $i++ ?>
                  </td>
                  <td>
                    <a style="color: black;" href="./index.php?page=view_team&id=<?php echo $row['id'] ?>">
                      <?php echo ucwords($row['name']) ?>
                    </a>
                    <br>
                    <small>
                      Do <?php echo date("d.m.Y", strtotime($row['end_date'])) ?>
                    </small>
                  </td>
                  <td class="project_progress">
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                      </div>
                    </div>
                    <small>
                      Splnené na <?php echo $prog ?>%
                    </small>
                  </td>
                  <td class="project-state">
                    <?php
                    /*
                    if ($stat[$row['status']] == 'ČAKÁ SA') {
                      echo "<span class='badge badge-secondary'>{$stat[$row['status']]}</span>";
                    } elseif ($stat[$row['status']] == 'ZAČALO') {
                      echo "<span class='badge badge-primary'>{$stat[$row['status']]}</span>";
                    } elseif ($stat[$row['status']] == 'PREBIEHA') {
                      echo "<span class='badge badge-info'>{$stat[$row['status']]}</span>";
                    } elseif ($stat[$row['status']] == 'POZASTAVENÉ') {
                      echo "<span class='badge badge-warning'>{$stat[$row['status']]}</span>";
                    } elseif ($stat[$row['status']] == 'PO SPLATNOSTI') {
                      echo "<span class='badge badge-danger'>{$stat[$row['status']]}</span>";
                    } elseif ($stat[$row['status']] == 'SPLNENÉ') {
                      echo "<span class='badge badge-success'>{$stat[$row['status']]}</span>";
                    }
                    */
                    ?>
                  </td>
                  <td>
                    <a class="btn btn-primary btn-sm" href="./index.php?page=view_team&id=<?php echo $row['id'] ?>">
                      <i class="fas fa-folder">
                      </i>
                      Prehľad
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-12">
        <div class="small-box bg-light shadow-sm border">
          <div class="inner">
            <h3><?php echo $conn->query("SELECT * FROM team_list $where")->num_rows; ?></h3>

            <p>Počet tímov</p>
          </div>
          <div class="icon">
            <i class="fa fa-layer-group"></i>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-12">
        <div class="small-box bg-light shadow-sm border">
          <div class="inner">
            <h3><?php echo $conn->query("SELECT t.*,p.name as pname,p.start_date,p.status as pstatus, p.end_date,p.id as pid FROM category_list t inner join team_list p on p.id = t.project_id $where2")->num_rows; ?></h3>
            <p>Počet úloh</p>
          </div>
          <div class="icon">
            <i class="fa fa-tasks"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>