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
                defaultDate: '2020-05-07',
                nowIndicator: 'true',
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





<div class="card-body">
					<?php
					$progress = $conn->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as uname,u.avatar,t.task FROM user_productivity p inner join users u on u.id = p.user_id inner join task_list t on t.id = p.task_id where p.project_id = $id order by unix_timestamp(p.date_created) desc ");
					while ($row = $progress->fetch_assoc()) :
					?>
						<div class="post">

							<div class="user-block">
								<?php if ($_SESSION['login_id'] == $row['user_id']) : ?>
									<span class="btn-group dropleft float-right">
										<span class="btndropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<div class="dropdown-menu">
											<a class="dropdown-item manage_progress" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['task'] ?>">Upraviť</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item delete_progress" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Vymazať</a>
										</div>
									</span>
								<?php endif; ?>
								<img class="img-circle img-bordered-sm" src="assets/uploads/<?php echo $row['avatar'] ?>" alt="Profilový obrázok">
								<span class="username">
									<a href="#"><?php echo ucwords($row['uname']) ?>[ <?php echo ucwords($row['task']) ?> ]</a>
								</span>
								<span class="description">
									<span class="fa fa-calendar-day"></span>
									<span><b><?php echo date('M d, Y', strtotime($row['date'])) ?></b></span>
									<span class="fa fa-user-clock"></span>
									<span>Začiatok: <b><?php echo date('h:i A', strtotime($row['date'] . ' ' . $row['start_time'])) ?></b></span>
									<span> | </span>
									<span>Koniec: <b><?php echo date('h:i A', strtotime($row['date'] . ' ' . $row['end_time'])) ?></b></span>
								</span>



							</div>
							<!-- /.user-block -->
							<div>
								<?php echo html_entity_decode($row['comment']) ?>
							</div>

							<p>
								<!-- <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a> -->
							</p>
						</div>
						<div class="post clearfix"></div>
					<?php endwhile; ?>
				</div>







    <div id='calendar'></div>
</body>

</html>