<?php

//Store tasks in a single session
session_start();

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['add_task']) && !empty($_POST['task'])) {
        $task = htmlspecialchars($_POST['task']);
        $_SESSION['tasks'][] = ['description' => $task, 'completed' => false];

    } elseif (isset($_POST['complete_task'])) {
        $index = (int)$_POST['index'];
        $_SESSION['tasks'][$index]['completed'] = true;
    
    } elseif (isset($_POST['delete_task'])) 
        $index = (int)$_POST['index'];
        unset($_SESSION['tasks'][$index]);
        $_SESSION['tasks'] = array_values($_SESSION['tasks']);
    }
// reditect to html file in order to avoid resubmission
header("Location: todo.html");
exit(); 

//Display tasks, with options to mark them as complete or delete them.
?>

<ul>
    <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
        <li class="<?= $task['completed'] ? 'completed' : '' ?>">
                <?= htmlspecialchars($task['description']) ?>

                <form action="todo.php" method="post" style="display:inline;">
                    <button type="submit" name="complete_task">Complete</button>
                    <input type="hidden" name="index" value="<?= $index ?>">
                </form>

                <form action="todo.php" method="post" style="display:inline;">
                    <button type="submit" name="delete_task">Delete</button>
                    <input type="hidden" name="index" value="<?= $index ?>">
                </form>
        </li>
    <?php endforeach; ?>
</ul>


 