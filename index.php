<?php

include_once 'functions.php'

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">

    <link rel="stylesheet" href="styles.css" type="text/css">

    <title>ToDoList</title>
</head>

<body>

    <div class="container">

        <div class="row mt-3">
            <div  class="col offset-2">
                <h1>Mes Tâches</h1>
            </div>
        </div>

        <form class="row mt-3" id="formAddTask">
            <input type="hidden" name="action" value="add_task">
    
            <div class="col-6 offset-2">
                <label for="inputTaskName" class="visually-hidden">Tâche</label>
                <input type="text" class="form-control" name="taskName" id="inputTaskName" placeholder="Tâche" required>
            </div>
    
            <div class="col-4">
                <button type="submit" class="btn btn-primary mb-3">Ajouter</button>
            </div>
        </form>

        
        <div class="row">
            <div class="col-7 offset-2">
                <table class="table table-bordered tablestriped table-hover">
                <thead>
                    <th>Fait</th>
                    <th>Nom</th>
                    <th>Date</th>
                    <th>Action</th> 
                </thead>
                <tbody>
                    <?php
                    foreach ($tasks as $task) {
                        ?>
                        <tr <?= $task['checked'] ? 'class="table-success"' : '' ?>>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input" data-id="<?= $task['id'] ?>" <?= $task['checked'] ?>>
                            </td>
                            <td><?= $task['name'] ?></td>
                            <td><?= $task['date'] ?></td>
                            <td class="text-center">
                                <a href="#" type="submit" class="btn btn-primary btn-m edit-task" data-id="<?= $task['id'] ?>"><i class="fas fa-edit"></i></a>
                                <a href="#" type="submit" class="btn btn-danger btn-m delete-task" data-id="<?= $task['id'] ?>"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                </table>
            </div>
        </div>
        <!--
        <div class="col-5 offset-2" id="checklist">
            <?php
            foreach ($tasks as $task)
            {
                ?>
                <input name="<?= $task['id'] ?>" type="checkbox" id="0<?= $task['id'] ?>" data-id="0<?= $task['id'] ?>" <?= $task['checked'] ?>>
                    <label for="0<?= $task['id'] ?>"><?= $task['name'] ?></label>
                <?php
            }
            ?>
            
            <input name="2"  type="checkbox" id="02">
                <label for="02">Faire du cheval</label>
            <input value="3" name="r" type="checkbox" id="03">
                <label for="03">Coffee</label>

            <input value="66"  type="checkbox" id="066">
                <label for="066">Faire du cheval</label>
            <input value="4" name="r" type="checkbox" id="04">
                <label for="04">Coffee</label>
        </div>
        -->


    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>

    <script src="script.js"></script>
  
</body>

</html>