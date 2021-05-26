<?php include('db_connect.php') ?>
<?php
$sql = "SELECT id, title, description, start, end, project_id, color FROM user_productivity WHERE user_id = " . $_SESSION['login_id'];

$project_id_query = "SELECT id FROM project_list WHERE user_ids OR manager_id LIKE '%" . $_SESSION['login_id'] . "%'";
$statement = $conn->prepare($project_id_query);

$result = mysqli_query($conn, $project_id_query);

$project_id = mysqli_fetch_assoc($result);

$_SESSION['project_id'] = $project_id['id'];


//echo "user_id: " . $_SESSION['login_id']. "<br>";
//echo "project_id (tím): " . $_SESSION['project_id'] . "<br>";
//echo "<pre>" . var_export($_SESSION, true) . "</pre>";

//echo "<pre>".var_export($project_id['project_id'], true)."</pre>";


?>
<?php
$twhere = "";
if ($_SESSION['login_type'] != 1)
    $twhere = "  ";
?>

<div class="card-tools">
    <button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="new_productivity_task"><i class="fa fa-plus"></i> Pridať task</button>
</div> 
<script>
/*
    $('#new_task').click(function() {
        uni_modal("Nová úloha pre <?php echo ucwords($name) ?>", "manage_task.php?pid=<?php echo $id ?>", "mid-large")
    })
    $('.edit_task').click(function() {
        uni_modal("Upraviť Úlohu: " + $(this).attr('data-task'), "manage_task.php?pid=<?php echo $id ?>&id=" + $(this).attr('data-id'), "mid-large")
    })
    $('.view_task').click(function() {
        uni_modal("Detaily Úlohy", "view_task.php?id=" + $(this).attr('data-id'), "mid-large")
    })
    */
    $('#new_productivity_task').click(function() {
        uni_modal("<i class='fa fa-plus'></i> Nová úloha", "manage_progress.php?pid=<?php echo 3 ?>", 'large',)
    })
    /*
    $('.manage_progress').click(function() {
        uni_modal("<i class='fa fa-edit'></i> Upraviť progres", "manage_progress.php?pid=<?php echo $id ?>&id=" + $(this).attr('data-id'), 'large')
    })
    $('.delete_progress').click(function() {
        _conf("Naozaj chcete vymazať tento progres?", "delete_progress", [$(this).attr('data-id')])
    })
    */

    function delete_progress($project_id) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=delete_progress',
            method: 'POST',
            data: {
                id: $project_id
            },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Údaje boli úspešne odstránené", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 1500)

                }
            }
        })
    }
</script>
<?php

//var_dump($_SESSION);


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

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8' />
    <title>
        Harmonogram
    </title>
    <style>
        #calendar {
            max-width: 100%;
            margin: 10px auto;
        }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link href="./calendar/fullcalendar.css" rel="stylesheet" />
    <link href="./calendar/bootstrap.css" rel="stylesheet" />
    <script src="./calendar/jquery.min.js"></script>
    <script src="./calendar/jquery-ui.min.js"></script>
    <script src="./calendar/moment.min.js"></script>
    <script src="./calendar/fullcalendar.min.js"></script>
    <script src="./calendar/locale-all.js"></script>

    <script>
        $(document).ready(function() {
            var calendar = $('#calendar').fullCalendar({
                editable: true,
                locale: 'sk',
                nowIndicator: 'true',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'

                },
                events: './calendar/load.php',
                selectable: true,
                selectHelper: true,
                minTime: '07:00:00',
                maxTime: '19:00:00',
                select: function(start, end, allDay) {
                    var title = prompt("Zadajte názov udalosti");
                    if (title) {
                        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                        var project_id = '<?php echo $_SESSION['project_id']; ?>';
                        var user_id = '<?php echo $_SESSION['login_id']; ?>';
                        console.log(project_id);
                        console.log(user_id);

                        $.ajax({
                            url: "./calendar/insert.php",
                            type: "POST",
                            data: {
                                title: title,
                                start: start,
                                end: end,
                                project_id: project_id,
                                user_id: user_id
                            },
                            success: function() {
                                calendar.fullCalendar('refetchEvents');
                                alert("Udalosť bola úspešne pridaná");
                            }
                        })
                    }
                },
                editable: true,
                eventResize: function(event) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: "./calendar/update.php",
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id
                        },
                        success: function() {
                            calendar.fullCalendar('refetchEvents');
                            alert('Aktualizácia udalosti');
                        }
                    })
                },

                eventDrop: function(event) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: "./calendar/update.php",
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id
                        },
                        success: function() {
                            calendar.fullCalendar('refetchEvents');
                            alert("Udalosť bola aktualizovaná");
                        }
                    });
                },

                eventClick: function(event) {
                    if (confirm("Naozaj chcete odstrániť udalosť?")) {
                        var id = event.id;
                        $.ajax({
                            url: "./calendar/delete.php",
                            type: "POST",
                            data: {
                                id: id
                            },
                            success: function() {
                                calendar.fullCalendar('refetchEvents');
                                alert("Udalosť bola odstránená");
                            }
                        })
                    }
                },

            });
        });
    </script>
    </script>

</head>

<body>

    <div id='calendar'></div>



</body>

</html>