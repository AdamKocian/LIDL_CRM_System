<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM task_list where id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
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
					<?php else : ?>
						<input type="hidden" name="task_id" value="<?php echo isset($_GET['tid']) ? $_GET['tid'] : '' ?>">
					<?php endif; ?>
					<div class="form-group">
						<label for="">Názov</label>
						<input type="text" class="form-control form-control-sm" name="title" value="<?php echo isset($title) ? $title : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="" class="control-label">Kategória</label>
						<select class="form-control form-control-sm select2" name="task_id">
							<option></option>
							<?php
							$tasks = $conn->query("SELECT * FROM category_list where project_id = {$_GET['pid']} order by task asc ");
							while ($row = $tasks->fetch_assoc()) :
							?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($task_id) && $task_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['task']) ?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="">Dátum začiatku</label>
						<input type="datetime-local" class="form-control form-control-sm" name="start" value="<?php echo isset($date) ? date("Y-MM-DD HH:mm:ss", strtotime($date)) : '' ?>" required>
					</div>

					<div class="form-group">
						<label for="">Dátum konca</label>
						<input type="datetime-local" class="form-control form-control-sm" name="end" value="<?php echo isset($date) ? date("Y-MM-DD HH:mm:ss", strtotime($date)) : '' ?>" required>
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
			placeholder: "Vyberte kategóriu",
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
				}
			}
		})
	})
</script>