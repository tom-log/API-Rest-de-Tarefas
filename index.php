<?php

$tasks_file = 'tasks.json';

// Verifica se o arquivo de tarefas existe e cria-o se não existir
if (!file_exists($tasks_file)) {
    file_put_contents($tasks_file, '[]');
}

// Função que retorna a lista de todas as tarefas - GET http://localhost:8000/tasks
function getTasks()
{
    global $tasks_file;
    $tasks = json_decode(file_get_contents($tasks_file), true);
    header('Content-Type: application/json');
    echo json_encode($tasks);
}

// Função que cria uma nova tarefa - POST http://localhost:8000/tasks
function createTask()
{
    global $tasks_file;
    $tasks = json_decode(file_get_contents($tasks_file), true);
    $data = json_decode(file_get_contents('php://input'), true);
    $id = count($tasks) + 1;
    $task = array('id' => $id, 'name' => $data['name'], 'description' => $data['description']);
    array_push($tasks, $task);
    file_put_contents($tasks_file, json_encode($tasks, JSON_UNESCAPED_UNICODE));
    header('Content-Type: application/json');
    echo json_encode($task, JSON_UNESCAPED_UNICODE);
}

// Função que retorna uma tarefa específica por seu ID - GET http://localhost:8000/tasks/1
function getTaskById($id)
{
    global $tasks_file;
    $tasks = json_decode(file_get_contents($tasks_file), true);
    foreach ($tasks as $task) {
        if ($task['id'] == $id) {
            header('Content-Type: application/json');
            echo json_encode($task);
            return;
        }
    }
    header('HTTP/1.1 404 Not Found');
}


// Função que atualiza uma tarefa existente por seu ID - PUT http://localhost:8000/tasks/1
function updateTask($id)
{
    global $tasks_file;
    $tasks = json_decode(file_get_contents($tasks_file), true);
    $data = json_decode(file_get_contents('php://input'), true);
    foreach ($tasks as &$task) {
        if ($task['id'] == $id) {
            $task['name'] = $data['name'];
            $task['description'] = $data['description'];
            file_put_contents($tasks_file, json_encode($tasks, JSON_UNESCAPED_UNICODE));
            header('Content-Type: application/json');
            echo json_encode($task);
            return;
        }
    }
    header('HTTP/1.1 404 Not Found');
}


// Função que exclui uma tarefa por seu ID - DELETE http://localhost:8000/tasks/1
function deleteTask($id)
{
    global $tasks_file;
    $tasks = json_decode(file_get_contents($tasks_file), true);
    foreach ($tasks as $key => $task) {
        if ($task['id'] == $id) {
            unset($tasks[$key]);
            file_put_contents($tasks_file, json_encode($tasks, JSON_UNESCAPED_UNICODE));
            header('Content-Type: application/json');
            echo json_encode(array('message' => 'Tarefa removida com sucesso.'));
            return;
        }
    }
    header('HTTP/1.1 404 Not Found');
}


// Verifica o método HTTP e chama a função correspondente
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_SERVER['REQUEST_URI'] == '/tasks') {
        getTasks();
    } else if (preg_match('/\/tasks\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
        getTaskById($matches[1]);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SERVER['REQUEST_URI'] == '/tasks') {
        createTask();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    if (preg_match('/\/tasks\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
        updateTask($matches[1]);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (preg_match('/\/tasks\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
        deleteTask($matches[1]);
    }
}
