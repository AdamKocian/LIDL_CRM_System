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
		<dt><b class="border-bottom border-primary">Názov</b></dt>
		<dd><?php echo ucwords($task) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Farba</b></dt>
		<dd>
			<?php
			echo $category_color;
			?>
		</dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Popis</b></dt>
		<dd><?php echo html_entity_decode($description) ?></dd>
	</dl>
</div>