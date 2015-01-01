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
	<title>田中</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<style>
	.deleteTask, .drag, .editTask{
		cursor: pointer;
		color: blue;
	}
	.done{
		text-decoration: line-through;
		color: gray;
	}

	</style>
</head>


<body>
<h1>田中</h1>
<p>
	<input type="text" id="title">
	<input type="button" id="addTask" value="追加">
</p>


<ul id ="tasks">
<?php foreach ($tasks as $task) : ?> 
	<li id="task_<?php echo h($task['id']); ?>" data-id="<?php echo h($task['id']); ?>">

		<input type="checkbox" class = "checkTask"  <?php if($task['type']==done) {echo "checked"; } ?> >

		<span class="<?php echo h($task['type']);?>"><?php echo h($task['title']);?></span>

　
		<span <?php if ($task['type']=="notyet"){echo'class="editTask"';}?>>[編集]</span>
		<span class="deleteTask">[削除]</span>
		<span class="drag">[drag]</span>
<!-- 		<span>[作成日]<?php echo h($task['created']);?></span>
		<span>[更新日]<?php echo h($task['modified']);?></span> -->


	</li>

<?php endforeach; ?>

</ul>


	<script>
	$(function(){
		$('#title').focus();

		$('#addTask').click(function(){
			var title = $('#title').val();
			$.post('_ajax_add_task.php',{
				title: title
			}, function(rs){
				var e = $(
					'<li id="task_'+rs+'"data-id="'+rs+'">' + 
					'<input type="checkbox" class="checkTask">' +
					'<span></span>' +
					'<span class="editTask">[編集]</span> '  +
					'<span class="deleteTask">[削除]</span> '  +
					'<span class="drag">[drag]</span> ' + 
					'</li>'

					);
					$('#tasks').append(e).find('li:last span:eq(0)').text(title);
					$('#title').val('').focus();

			});
		});

		$(document).on('click', '.editTask', function(){
			var id = $(this).parent().data('id');
			var title = $(this).prev().text();
			$('#task_' + id)
			.empty()
			.append($('<input type="text">').attr('value',title))
			.append('<input type="button" value="更新" class="updateTask">');
			$('#task_'+id+ 'input:eq(0)').focus();

		});

		$(document).on('click', '.updateTask', function(){
			var id = $(this).parent().data('id');
			var title = $(this).prev().val();
			$.post('_ajax_update_task.php',{
				id: id,
				title: title
			}, function(rs){
				var e = $(
					'<input type="checkbox" class="checkTask">' +
					'<span></span>' +
					'<span class="editTask">[編集]</span> '  +
					'<span class="deleteTask">[削除]</span> '  +
					'<span class="drag">[drag]</span> ' 




					);
					$('#task_'+id).empty().append(e).find('span:eq(0)').text(title);
			});


		});





		$('#tasks').sortable({
			axis: 'y',
			opacity: 0.2,
			handle: '.drag',
			update: function(){
				$.post('_ajax_sort_task.php',{
					task: $(this). sortable('serialize')
				});
			}
		});

		$(document).on('click', '.checkTask', function(){
			var id = $(this).parent().data('id');
			var title = $(this).next();
			$.post('_ajax_check_task.php',{
				id: id
			}, function(rs){
				if (title.hasClass('done')){
					title.removeClass('done').next().addClass('editTask');
				} else{
					title.addClass('done').next().removeClass('editTask');
				}
			});

		});

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
