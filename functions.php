<?php

include_once 'config.php';

global $db;

$db->initialaze();

$tasks = $db->getTasks();

foreach ($tasks as $taskIndex => $task) {
    $tasks[$taskIndex]['checked'] = ($task['done'] === 1) ? 'checked' : null;
}