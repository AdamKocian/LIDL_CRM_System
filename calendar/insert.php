<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM task_list where id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}

$connect = new PDO('mysql:host=localhost;dbname=lidl_db', 'root', '');

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO task_list 
 (title, start, end, project_id, user_id ) 
 VALUES (:title, :start, :end, :project_id, :user_id)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start' => $_POST['start'],
   ':end' => $_POST['end'],
   ':project_id' => $_POST['project_id'],
   ':user_id' => $_POST['user_id']
  )
 );
}


?>
<div class="container-fluid">
	<form action="" id="manage-progress">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-5">
					<?php if (!isset($_GET['tid'])) : ?>
						<div class="form-group">
							<label for="" class="control-label">Cieľ tímu</label>
							<select class="form-control form-control-sm select2" name="task_id">
								<option></option>
								<?php
								$tasks = $conn->query("SELECT * FROM task_list where project_id = {$_GET['pid']} order by task asc ");
								while ($row = $tasks->fetch_assoc()) :
								?>
									<option value="<?php echo $row['id'] ?>" <?php echo isset($task_id) && $task_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['task']) ?></option>
								<?php endwhile; ?>
							</select>
						</div>
					<?php else : ?>
						<input type="hidden" name="task_id" value="<?php echo isset($_GET['tid']) ? $_GET['tid'] : '' ?>">
					<?php endif; ?>
					<div class="form-group">
						<label for="">Názov</label>
						<input type="text" class="form-control form-control-sm" name="title" value="<?php echo isset($title) ? $title : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="">Dátum</label>
						<input type="date" class="form-control form-control-sm" name="date" value="<?php echo isset($date) ? date("Y-m-d", strtotime($date)) : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="">Začiatok</label>
						<input type="time" class="form-control form-control-sm" name="start" value="<?php echo isset($start) ? date("H:i", strtotime("2020-01-01 " . $start)) : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="">Koniec</label>
						<input type="time" class="form-control form-control-sm" name="end" value="<?php echo isset($end) ? date("H:i", strtotime("2020-01-01 " . $end)) : '' ?>" required>
					</div>
				</div>
				<div class="col-md-7">
					<div class="form-group">
						<label for="">Popis úlohy</label>
						<textarea name="comment" id="" cols="30" rows="10" class="summernote form-control" required="">
							<?php echo isset($comment) ? $comment : '' ?>
						</textarea>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	$(document).ready(function() {
		$('.summernote').summernote({
			height: 200,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ol', 'ul', 'paragraph', 'height']],
				['table', ['table']],
				['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
			]
		})
		$('.select2').select2({
			placeholder: "Please select here",
			width: "100%"
		});
	})
	$('#manage-progress').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_progress',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast('Údaje sa úspešne uložili', "success");
					setTimeout(function() {
						location.reload()
					}, 1500)
				} else {
					alert_toast('Údaje sa úspešne uložili', "success");
					setTimeout(function() {
						location.reload()
					}, 1500)
			}
		}
	})
</script>

<?php

?>