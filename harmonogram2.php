<?php include('db_connect.php') ?>
<?php
$sql = "SELECT id, title, description, start, end, color FROM user_productivity";



?>
<?php
$twhere = "";
if ($_SESSION['login_type'] != 1)
    $twhere = "  ";
?>

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
    <link href="./harmonogram/core@4.4.1/main.min.css" rel="stylesheet" />
    <link href="./harmonogram/daygrid@4.4.1/main.min.css" rel="stylesheet" />
    <link href="./harmonogram/timegrid@4.4.1/main.min.css" rel="stylesheet" />
    <script src="./harmonogram/core@4.4.1/main.min.js"></script>
    <script src="./harmonogram/interaction@4.4.1/main.min.js"></script>
    <script src="./harmonogram/daygrid@4.4.1/main.min.js"></script>
    <script src="./harmonogram/timegrid@4.4.1/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid'],
                defaultView: 'dayGridMonth',
                defaultDate: '2021-05-01',
                nowIndicator: 'true',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

            });

            calendar.render();
        });
    </script>

</head>

<body>

    <div id='calendar'></div>



</body>

</html>