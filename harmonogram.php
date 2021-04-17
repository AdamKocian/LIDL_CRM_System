<?php include('db_connect.php') ?>
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
    <link href='https://unpkg.com/@fullcalendar/core@4.4.1/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/daygrid@4.4.1/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/timegrid@4.4.1/main.min.css' rel='stylesheet' />
    <script src='https://unpkg.com/@fullcalendar/core@4.4.1/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/interaction@4.4.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/daygrid@4.4.1/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/timegrid@4.4.1/main.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid'],
                defaultView: 'dayGridMonth',
                defaultDate: '2020-05-07',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [{
                        title: 'All Day Event',
                        start: '2020-05-01'
                    },
                    {
                        title: 'Long Event',
                        start: '2020-05-07',
                        end: '2020-05-10'
                    },
                    {
                        groupId: '999',
                        title: 'Repeating Event',
                        start: '2020-05-09T16:00:00'
                    },
                    {
                        groupId: '999',
                        title: 'Repeating Event',
                        start: '2020-05-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: '2020-05-11',
                        end: '2020-05-13'
                    },
                    {
                        title: 'Meeting',
                        start: '2020-05-12T10:30:00',
                        end: '2020-05-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2020-05-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2020-05-12T14:30:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2020-05-13T07:00:00'
                    },
                    {
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: '2020-05-28'
                    }
                ]
            });

            calendar.render();
        });
    </script>

</head>

<body>
    <div id='calendar'></div>
</body>

</html>
