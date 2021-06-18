<?php include 'db_connect.php' ?>
<?php 
/*
SELECT *,concat(firstname,' ',lastname) as name,
ifnull((select sum( DATEDIFF(task_list.end,task_list.start)*8 ) from task_list join category_list on task_list.task_id = category_list.id where task_list.user_id = users.id and category_list.task = 'Dovolenka'),0) as dovolenka
FROM users
ORDER BY concat(firstname,' ',lastname) asc
*/
?>
<div class="col-md-12">
    <div class="card card-outline card-success">
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
                        <th>Počet dní</th>
                        <th>Zostatok dovolenky</th>
                        <th>Akcia</th>

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
                                <td><b><?php echo $row['email'] ?></b></td>
                                <td><b><?php echo $type[$row['type']] ?></b></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                        Upraviť
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item view_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Vidieť</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="./index.php?page=edit_user&id=<?php echo $row['id'] ?>">Upraviť</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Vymazať</a>
                                    </div>
                                </td>
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
        var _d = "<p class='text-center'><b>Report dovoleniek zamestnancov (<?php echo date("F d, Y") ?>)</b></p>"
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