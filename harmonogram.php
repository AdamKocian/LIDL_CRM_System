<?php include('db_connect.php') ?>
<?php

$project_id_query = "SELECT id FROM team_list WHERE user_ids LIKE '%" . $_SESSION['login_id'] . "%'  OR manager_id LIKE '%" . $_SESSION['login_id'] . "%'";

$statement = $conn->prepare($project_id_query);

$result = mysqli_query($conn, $project_id_query);

$project_id = mysqli_fetch_assoc($result);

$_SESSION['project_id'] = $project_id['id'];

?>
<?php
$twhere = "";
if ($_SESSION['login_type'] != 1)
    $twhere = "  ";
?>

<div class="card-tools">
    <button style="position: fixed; right: 40px; bottom: 90px; padding: 12px; z-index: 3; " class="btn btn-primary bg-gradient-primary btn-sm" type="text" id="new_productivity_task"><i class="fa fa-plus"></i> Pridať task</button>
    <!-- <button style="position: block; right: 40px; top: 30px; padding: 7px; " class="btn btn-primary bg-gradient-primary btn-sm" type="text" id="new_productivity_task"><i class="fa fa-plus"></i> Pridať task</button>-->
</div>

<script>
    $('#new_productivity_task').click(function() {
        uni_modal("<i class='fa fa-plus'></i> Nová úloha", "manage_task.php?pid=<?php echo isset($_GET['id']) ? $_GET['id'] : ''  ?>", 'large', ) //fix predtým statického teamu (ind)$project_id
    })


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
                eventRender: function(event, element) {},
                eventTextColor: '#FFFFFF', //#000000
                allDay: false,
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
                    // var title = prompt("Zadajte názov udalosti");
                    var title = $('#new_productivity_task').click(function() {
                        uni_modal("<i class='fa fa-plus'></i> Nová úloha", "manage_task.php?pid=<?php echo isset($_GET['pid']) ? $_GET['pid'] : ''  ?>", 'large', )
                    })

                    if (title) {
                        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                        var project_id = '<?php echo $_SESSION['project_id']; ?>';
                        var user_id = '<?php echo $_SESSION['login_id']; ?>';
                        var salesChartCanvas = $('#salesChart').get(0); // Bez .getContext('2d') na konci to nerobí problémy, no funguje to aj bez tohto riadka

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
                                alert_toast('Udalosť bola úspešne pridaná', "success");
                            }
                        })
                    } else { // quickfix
                        alert_toast("Chyba! Udalosť nebola pridaná", 'failue')
                        setTimeout(function() {
                            location.reload()
                        }, 1500)
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
                            alert_toast('Aktualizácia udalosti', "success");
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
                            alert_toast('Údaje sa úspešne uložili', "success");

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
                                alert_toast('Udalosť bola odstránená', "success");
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