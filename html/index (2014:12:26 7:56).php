<?php



require_once('config.php');
require_once('functions.php');



$dbh = connectDb();

$tasks = array();

$sql = "select * from tasks where type != 'deleted' order by seq";
foreach ($dbh->query($sql) as $row){
	array_push($tasks, $row);
}



?>
<!DOCTYPE html>
<html lang= "ja">
<head>
	<meta charset="UTF-8">
	<title>TODOアプリ</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<style>
	.deleteTask {
		cursor: pointer;
		color: blue;
	}

	</style>
</head>


<body>
<h1>TODOアプリ</h1>


<ul>
<?php foreach ($tasks as $task) : ?> 
	<li id="task_<?php echo h($task['id']); ?>" data-id="<?php echo h($task['id']); ?>">




		<?php echo h($task['title']);?>




		<span class="deleteTask">[削除]</span>
	</li>
<?php endforeach; ?>
</ul>


	<script>
	$(function(){
		$(document).on('click', '.deleteTask', function(){
			if(confirm('本当に削除しますか？')){
				var id = $(this).parent(). data('id');
				$.post('_ajax_delete_task.php', {
				id: id
				}, function(rs) {
				$('#task_' + id).fadeOut(800);
				});
			}
		});
	});
</script>
</body>


</html>
