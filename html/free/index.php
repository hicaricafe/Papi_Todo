<?php

require_once('config.php');
require_once('functions.php');

// DBに接続
connectDb();

$tasks = array();

// DBからとってきたデータを$tasksにつっこむ

$rs = mysql_query("select * from tasks where type != 'deleted' order by seq");
while ($row = mysql_fetch_assoc($rs)) {
    array_push($tasks, $row);
}

// var_dump($tasks);

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <title>FREE</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    </head>
    <style>
    .editTask, .deleteTask, .drag {
        cursor: pointer;
        color: blue;
    }
    .done {
        text-decoration: line-through;
    }
    </style>
    <body>
        <h1>FREE</h1>
        <p><input type="text" name="title" id="title"> <input type="button" value="追加" id="addTask"></p>
        <ul id="tasks">
        <?php foreach ($tasks as $task) : ?>
        <li id="task_<?php echo h($task['id']); ?>"><input type="checkbox" class="checkTask" <?php if ($task['type']=="done") { ?>checked<?php } ?>> <span <?php if ($task['type']=="done") { ?>class="done"<?php } ?>><?php echo h($task['title']); ?></span> <span <?php if ($task['type']=="notyet") { ?>class="editTask"<?php } ?>>[edit]</span> <span class="deleteTask">[delete]</span> <span class="drag">[drag]</span></li>
        <?php endforeach; ?>
        </ul>
        <script>
            $(function() {
                $('#title').focus();
                
                $('#tasks').sortable({
                    axis: 'y',
                    opacity: 0.2,
                    handle: '.drag',
                    // idは「..._x」
                    update: function() {
                        $.post('_ajax_sort_task.php', {
                            task: $(this).sortable('serialize')
                        });
                    }
                });
            
                $('#addTask').click(function() {
                    var title = $('#title').val();
                    $.post('_ajax_add_task.php', {
                        title: title
                    }, function(rs) {
                        // li要素としてtitleを追加
                        $('#tasks').append('<li id="task_'+rs+'"><input type="checkbox" class="checkTask"> <span></span> <span class="editTask">[edit]</span> <span class="deleteTask">[delete]</span> <span class="drag">[drag]</span></li>').find('li:last span:eq(0)').text(title);
                        // フォームを空にする
                        $('#title').val('').focus();
                    });
                });
                
                $('.deleteTask').live('click', function() {
                    if (confirm('are you sure?')) {
                        var id = $(this).parent().attr('id').replace('task_','');
                        $.post('_ajax_delete_task.php', {
                            // params
                            id : id
                        }, function(rs) {
                            // 処理
                            $('#task_'+id).fadeOut();
                        });
                    }
                });
                
                $('.checkTask').live('click', function() {
                    var id = $(this).parent().attr('id').replace('task_','');
                    var title = $(this).next();
                    $.post('_ajax_check_task.php', {
                        id: id
                    }, function(rs) {
                        if (title.hasClass('done')) {
                            title.removeClass('done').next().addClass('editTask');
                        } else {
                            title.addClass('done').next().removeClass('editTask');
                        }
                    });
                });

                $('.editTask').live('click', function() {
                    var id = $(this).parent().attr('id').replace('task_','');
                    var title = $(this).prev().text();
                    $('#task_'+id).empty().append($('<input type="text">').attr('value', title)).append('<input type="button" value="更新" class="updateTask">');
                    $('#task_'+id+' input:eq(0)').focus();
                });
                
                $('.updateTask').live('click', function() {
                    var id = $(this).parent().attr('id').replace('task_','');
                    var title = $(this).prev().val();
                    $.post('_ajax_update_task.php', {
                        id: id,
                        title: title
                    }, function(rs) {
                        var e = $('<input type="checkbox" class="checkTask"> <span></span> <span class="editTask">[edit]</span> <span class="deleteTask">[delete]</span> <span class="drag">[drag]</span>');
                        $('#task_'+id).empty().append(e).find('span:eq(0)').text(title);
                    });
                });

            });
        </script>
    </body>
</html>

