<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM category_list where id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<dl>
		<dt><b class="border-bottom border-primary">Úloha</b></dt>
		<dd><?php echo ucwords($task) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Stav</b></dt>
		<dd>
			<?php
			if ($status == 1) {
				echo "<span class='badge badge-secondary'>Čaká sa</span>";
			} elseif ($status == 2) {
				echo "<span class='badge badge-primary'>Prebieha</span>";
			} elseif ($status == 3) {
				echo "<span class='badge badge-success'>Splnené</span>";
			}
			?>
		</dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Popis</b></dt>
		<dd><?php echo html_entity_decode($description) ?></dd>
	</dl>
</div>