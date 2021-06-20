<?php include 'db_connect.php' ?>
<div class="col-md-12">
  <div class="card card-outline card-success shadow-sm">
    <div class="card-header">
      <b>Progres tímu</b>
      <div class="card-tools">
        <button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Vytlačiť alebo uložiť</button>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive" id="printable">
        <table class="table m-0 table-bordered">
          <thead>
            <th></th>
            <th>Tím</th>
            <th>Počet úloh</th>
            <th>Dokončených úloh</th>
            <th>Pracovný čas</th>
            <th>Progres</th>
            <th>Stav</th>
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
              $tprog = $conn->query("SELECT * FROM category_list where project_id = {$row['id']}")->num_rows;
              $cprog = $conn->query("SELECT * FROM category_list where project_id = {$row['id']} ")->num_rows; // and status = 3
              $prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
              $prog = $prog > 0 ?  number_format($prog, 0) : $prog;
              $prod = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
              $dur = $conn->query("SELECT sum(time_rendered) as duration FROM task_list where project_id = {$row['id']}");
              $dur = $dur->num_rows > 0 ? $dur->fetch_assoc()['duration'] : 0;
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
                  <?php echo $i++ ?>
                </td>
                <td>
                  <a>
                    <?php echo ucwords($row['name']) ?>
                  </a>
                  <br>
                  <small>
                    Do: <?php echo date("Y-m-d", strtotime($row['end_date'])) ?>
                  </small>
                </td>
                <td class="text-center">
                  <?php echo number_format($tprog) ?>
                </td>
                <td class="text-center">
                  <?php echo number_format($cprog) ?>
                </td>
                <td class="text-center">
                  <?php echo number_format($dur) . ' Hodín' ?>
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
                  ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card card-outline card-success shadow-sm">
      <div class="card-header">
        <b>Úlohy členov</b>
        <div class="card-tools">
          <button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print2"><i class="fa fa-print"></i> Vytlačiť alebo uložiť</button>
        </div>
      </div>
      <div class="card-body">
      <div class="table-responsive" id="printable2">
        <?php
        $progress = $conn->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as uname,u.avatar,t.task FROM task_list p inner join users u on u.id = p.user_id inner join category_list t on t.id = p.task_id");
        while ($row = $progress->fetch_assoc()) :
        ?>
          <div class="post">

            <div class="user-block">
              <img class="img-circle img-bordered-sm" src="assets/uploads/<?php echo $row['avatar'] ?>" alt="Profilový obrázok">
              <span class="username">
                <a href="#"><?php echo ucwords($row['uname']) ?>- <?php echo ucwords($row['task']) ?></a>
              </span>
              <span class="description">
                <span class="fa fa-calendar-day"></span>
                <span><b><?php echo date('M d, Y', strtotime($row['date_created'])) ?></b></span>
                <span class="fa fa-user-clock"></span>
                <span>Začiatok: <b><?php echo date('h:i A', strtotime($row['date_created'] . ' ' . $row['start'])) ?></b></span>
                <span> | </span>
                <span>Koniec: <b><?php echo date('h:i A', strtotime($row['date_created'] . ' ' . $row['end'])) ?></b></span>
              </span>
            </div>
            <div>
              <?php echo html_entity_decode($row['comment']) ?>
            </div>
          </div>
          <div class="post clearfix"></div>
        <?php endwhile; ?>
      </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('#print').click(function() {
    start_load()
    var _h = $('head').clone()
    var _p = $('#printable').clone()
    var _d = "<p<b>Report pracovných tímov</b></p>"
    _p.prepend(_d)
    _p.prepend(_h)
    var nw = window.open("", "", "width=900,height=600")
    nw.document.write(_p.html())
    nw.document.close()
    nw.print()
    setTimeout(function() {
      nw.close()
      end_load()
    }, 750)
  })

  $('#print2').click(function() {
    start_load()
    var _h = $('head').clone()
    var _p = $('#printable2').clone()
    var _d = "<p<b>Report zadaných úloch</b></p>"
    _p.prepend(_d)
    _p.prepend(_h)
    var nw = window.open("", "", "width=900,height=600")
    nw.document.write(_p.html())
    nw.document.close()
    nw.print()
    setTimeout(function() {
      nw.close()
      end_load()
    }, 750)
  })
</script>