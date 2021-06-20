<?php include 'db_connect.php' ?>
<?php
$project_id_query = "SELECT * ,(select count( DATEDIFF(t.end,t.start)*8 ) FROM lidl_db.task_list t JOIN lidl_db.category_list c ON t.task_id = c.id WHERE c.task = 'Dovolenka' and t.user_id = users.id and year(t.start) = year(now())) FROM users";


?>
<div class="col-md-12">
    <div class="card card-outline card-success shadow-sm">
        <div class="card-header">
            <b>Dovolenky zamestnancov</b>
            <div class="card-tools">
                <button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Vytlačiť alebo uložiť</button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" id="printable">
                <table class="table m-0 table-bordered">
                    <thead>

                        <th class="text-center"></th>
                        <th>Meno</th>
                        <th>Pozícia</th>
                        <th>Počet dní</th>
                        <th>Zostatok dovolenky</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $type = array('', "Admin", "Manažér tímu", "Zamestnanec");
                        $qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users order by concat(firstname,' ',lastname) asc");
                        while ($row = $qry->fetch_assoc()) :

                        ?>
                            <tr>
                                <th class="text-center"><?php echo $i++ ?></th>
                                <td><b><?php echo ucwords($row['name']) ?></b></td>
                                <td><b><?php echo $type[$row['type']] ?></b></td>
                                <td><b><?php echo $row['Dovolenka'] ?></b></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#print').click(function() {
        start_load()
        var _h = $('head').clone()
        var _p = $('#printable').clone()
        var _d = "<p<b>Report dovoleniek zamestnancov</b></p>"
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