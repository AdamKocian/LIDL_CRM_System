<?php
include 'db_connect.php';
$stat = array("ČAKÁ SA", "ZAČALO", "PREBIEHA", "POZASTAVENÉ", "PO SPLATNOSTI", "SPLNENÉ");
$qry = $conn->query("SELECT * FROM team_list where id = " . $_GET['id'])->fetch_array();
foreach ($qry as $k => $v) {
	$$k = $v;
}
$tprog = $conn->query("SELECT * FROM category_list where category_list_id = {$id}")->num_rows;
$cprog = $conn->query("SELECT * FROM category_list where category_list_id = {$id}")->num_rows; // and status = 3
$prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
$prog = $prog > 0 ?  number_format($prog, 2) : $prog;
$prod = $conn->query("SELECT * FROM task_list where project_id = {$id}")->num_rows;
if ($status == 0 && strtotime(date('Y-m-d')) >= strtotime($start_date)) :
	if ($prod  > 0  || $cprog > 0)
		$status = 2;
	else
		$status = 1;
elseif ($status == 0 && strtotime(date('Y-m-d')) > strtotime($end_date)) :
	$status = 4;
endif;
$manager = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where id = $manager_id");
$manager = $manager->num_rows > 0 ? $manager->fetch_array() : array();
?>
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-12">
			<div class="callout callout-info">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-6">
							<dl>
								<dt><b class="border-primary">Názov tímu</b></dt>
								<dd><?php echo ucwords($name) ?></dd>
								<dt><b class="border-primary">Popis</b></dt>
								<dd><?php echo html_entity_decode($description) ?></dd>
							</dl>
						</div>
						<div class="col-md-6">
							<dl>
								<dt><b class="border-primary">Začiatok</b></dt>
								<dd><?php echo date("F d, Y", strtotime($start_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-primary">Koniec</b></dt>
								<dd><?php echo date("F d, Y", strtotime($end_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-primary">Stav</b></dt>
								<dd>
									<?php
									if ($stat[$status] == 'ČAKÁ SA') {
										echo "<span class='badge badge-secondary'>{$stat[$status]}</span>";
									} elseif ($stat[$status] == 'ZAČALO') {
										echo "<span class='badge badge-primary'>{$stat[$status]}</span>";
									} elseif ($stat[$status] == 'PREBIEHA') {
										echo "<span class='badge badge-info'>{$stat[$status]}</span>";
									} elseif ($stat[$status] == 'POZASTAVENÉ') {
										echo "<span class='badge badge-warning'>{$stat[$status]}</span>";
									} elseif ($stat[$status] == 'PO SPLATNOSTI') {
										echo "<span class='badge badge-danger'>{$stat[$status]}</span>";
									} elseif ($stat[$status] == 'SPLNENÉ') {
										echo "<span class='badge badge-success'>{$stat[$status]}</span>";
									}
									?>
								</dd>
							</dl>
							<dl>
								<dt><b class="border-primary">Manažér</b></dt>
								<dd>
									<?php if (isset($manager['id'])) : ?>
										<div class="d-flex align-items-center mt-1">
											<img class="img-circle img-thumbnail p-0 shadow-sm border-info img-sm mr-3" src="assets/uploads/<?php echo $manager['avatar'] ?>" alt="Avatar">
											<b><?php echo ucwords($manager['name']) ?></b>
										</div>
									<?php else : ?>
										<small><i>Manažér bol zmazaný z databázy</i></small>
									<?php endif; ?>
								</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<span><b>Členovia tímu</b></span>
					<div class="card-tools">
					</div>
				</div>
				<div class="card-body">
					<ul class="users-list clearfix">
						<?php
						if (!empty($user_ids)) :
							$members = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where id in ($user_ids) order by concat(firstname,' ',lastname) asc");
							while ($row = $members->fetch_assoc()) :
						?>
								<li>
									<img src="assets/uploads/<?php echo $row['avatar'] ?>" alt="Profilový obrázok">
									<a class="users-list-name" href="javascript:void(0)"><?php echo ucwords($row['name']) ?></a>
								</li>
						<?php
							endwhile;
						endif;
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<span><b>Kategórie</b></span>
					<?php if ($_SESSION['login_type'] != 3) : ?>
						<div class="card-tools">
							<button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="new_task"><i class="fa fa-plus"></i> Pridať kategóriu</button>
						</div>
					<?php endif; ?>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-condensed m-0 table-hover">
							<colgroup>
								<col width="5%">
								<col width="25%">
								<col width="30%">
								<col width="15%">
								<col width="15%">
							</colgroup>
							<tbody>
								<?php
								$i = 1;
								$tasks = $conn->query("SELECT * FROM category_list where category_list_id = {$id} order by task asc");
								while ($row = $tasks->fetch_assoc()) :
									$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
									unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
									$desc = strtr(html_entity_decode($row['description']), $trans);
									$desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td class=""><b><?php echo ucwords($row['task']) ?></b></td>
										<td class="">
											<p class="truncate"><?php echo strip_tags($desc) ?></p>
										</td>
										<td>
<?php
											echo $row["category_color"];
											?>
										</td>
										<td class="text-center">
											<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
												Akcia
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item view_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['task'] ?>">Zobraziť</a>
												<div class="dropdown-divider"></div>
												<?php if ($_SESSION['login_type'] != 3) : ?>
													<a class="dropdown-item edit_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['task'] ?>">Upraviť</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item delete_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Vymazať</a>
												<?php endif; ?>
											</div>
										</td>
									</tr>
								<?php
								endwhile;
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<b>Úlohy členov</b>
					<div class="card-tools">
						<button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="new_productivity"><i class="fa fa-plus"></i> Pridať úlohu</button>
					</div>
				</div>
				<div class="card-body">
					<?php
					$progress = $conn->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as uname,u.avatar,t.task FROM task_list p inner join users u on u.id = p.user_id inner join category_list t on t.id = p.task_id where p.project_id = $id order by unix_timestamp(p.date_created) desc ");
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
									<span>Začiatok: <b><?php echo date('h:i A', strtotime($row['date'] . ' ' . $row['start'])) ?></b></span>
									<span> | </span>
									<span>Koniec: <b><?php echo date('h:i A', strtotime($row['date'] . ' ' . $row['end'])) ?></b></span>
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
<style>
	.users-list>li img {
		border-radius: 50%;
		height: 67px;
		width: 67px;
		object-fit: cover;
	}

	.users-list>li {
		width: 33.33% !important
	}

	.truncate {
		-webkit-line-clamp: 1 !important;
	}
</style>
<script>
	$('#new_task').click(function() {
		uni_modal("Nová kategória pre <?php echo ucwords($name) ?>", "manage_category.php?pid=<?php echo $id ?>", "mid-large")
	})
	$('.edit_task').click(function() {
		uni_modal("Upraviť kategóriu: " + $(this).attr('data-task'), "manage_category.php?pid=<?php echo $id ?>&id=" + $(this).attr('data-id'), "mid-large")
	})
	$('.view_task').click(function() {
		uni_modal("Detaily kategórie", "view_category.php?id=" + $(this).attr('data-id'), "mid-large")
	})
	$('#new_productivity').click(function() {
		uni_modal("<i class='fa fa-plus'></i> Nová úloha", "manage_task.php?pid=<?php echo $id ?>", 'large')
	})
	$('.manage_progress').click(function() {
		uni_modal("<i class='fa fa-edit'></i> Upraviť úlohu", "manage_task.php?pid=<?php echo $id ?>&id=" + $(this).attr('data-id'), 'large')
	})
	$('.delete_progress').click(function() {
		_conf("Naozaj chcete vymazať tento progres?", "delete_progress", [$(this).attr('data-id')])
	})

	function delete_progress($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_progress',
			method: 'POST',
			data: {
				id: $id
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


