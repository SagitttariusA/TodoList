<?php

include_once 'config.php';

global $db;

$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

$action = (isset($_POST['action'])) ? $_POST['action'] : $data['action'];

switch ($action) {
    case 'add_task':
        addTask();
        break;
    case 'update_task':
        upadateTask($data);
        break;
    case 'modify_task':
        modifyTask($data);
        break;
    case 'delete_task':
        deleteTask($data);
        break;
    default:
        # code...
        break;
}

function addTask(): void
{
    global $db;

    if (!isset($_POST['taskName'])) return;

    $db->addTask($_POST['taskName']);

    echo json_encode([
        'code' => 'ADD_TASK_OK',
        'taskId' => $db->getDatabase()->lastInsertRowID(),
        'taskName' => $_POST['taskName']
    ]);
}

function upadateTask(array $data): void
{
    global $db;

    if(!isset($data['taskId'], $data['done'])) return;

    $db->updateTask(intval($data['taskId']), intval($data['done']));

    echo json_encode([
        'code' => 'UPDATE_TASK_OK'
    ]);
}
function modifyTask(array $data): void
{
    global $db;

    if(!isset($data['taskId'], $data['newTaskName'])) return;

    $db->modifyTask(intval($data['taskId']), $data['newTaskName']);

    echo json_encode([
        'code' => 'MODIFY_TASK_OK'
    ]);
}

function deleteTask(array $data): void
{
    global $db;

    if(!isset($data['taskId'])) return;

    $db->deleteTask(intval($data['taskId']));

    echo json_encode([
        'code' => 'DELETE_TASK_OK'
    ]);
}