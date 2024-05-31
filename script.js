const formAddTask = document.querySelector('#formAddTask');
const tableTasks = document.querySelector('.table');
const inputTaskName = document.querySelector('#inputTaskName');
const checkboxes = document.querySelectorAll('.form-check-input');
const modifyButtons = document.querySelectorAll('.modify-button');
const deleteButtons = document.querySelectorAll('.delete-button');





const URL_ACTIONS = 'actions.php';

const updateTask = async function(e) {
    try {
        await fetch(URL_ACTIONS, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'update_task',
                done: this.checked,
                taskId: this.dataset.id
            })
        });
    } catch (error) {
        console.error('Error updating task:', error);
    }
}

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateTask);
})

formAddTask.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.append('date', new Date().toLocaleString());

    try {
        const response = await fetch(URL_ACTIONS, {
            method: 'POST',
            body: formData
        });
        const json = await response.json();

        // Vérifie si le code de la réponse est 'ADD_TASK_OK', sinon, ne rien faire
        if (json.code !== 'ADD_TASK_OK') return;

        // Insère une nouvelle ligne et deux cellules dans la table des tâches
        const row = tableTasks.insertRow();
        const firstCell = row.insertCell();
        const secondCell = row.insertCell();

        // Ajoute une classe CSS à la première cellule pour centrer son contenu
        firstCell.classList.add('text-center');

        // Crée une checkbox avec les propriétés nécessaires
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.addEventListener('change', updateTask);
        checkbox.classList.add('form-check-input');
        checkbox.dataset.id = json.taskId;

        // Crée un nœud de texte pour le nom de la tâche
        const taskName = document.createTextNode(json.taskName);

        // Ajoute la checkbox à la première cellule et le nom de la tâche à la deuxième cellule
        firstCell.appendChild(checkbox);
        secondCell.appendChild(taskName);

        // Crée un lien pour modifier et supprimer
        const modifyLink = document.createElement('a');
        modifyLink.textContent = 'Modify';
        modifyLink.href = '#';
        modifyLink.classList.add('edit-task');
        modifyLink.dataset.id = json.taskId;
        modifyLink.addEventListener('click', modifyTask);

        const deleteLink = document.createElement('a');
        deleteLink.textContent = 'Delete';
        deleteLink.href = '#';
        deleteLink.classList.add('delete-task');
        deleteLink.dataset.id = json.taskId;
        deleteLink.addEventListener('click', deleteTask);

        // Ajoute les liens à la troisième cellule
        const thirdCell = row.insertCell();
        thirdCell.appendChild(modifyLink);
        thirdCell.appendChild(deleteLink);

        // Réinitialise le champ d'entrée pour le nom de la tâche
        inputTaskName.value = '';
        
    } catch (error) {
        console.error('Error adding task:', error);
    }
});

modifyButtons.forEach(button => {
    button.addEventListener('click', modifyTask);
});

const modifyTask = async function(e) {
    e.preventDefault();
    const newTaskName = prompt("Enter new task name");

    if (newTaskName === null || newTaskName === "") return;

    try {
        await fetch(URL_ACTIONS, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'modify_task',
                newTaskName: newTaskName,
                taskId: this.dataset.id
            })
        });

        // Update task name in the table
        this.parentNode.nextSibling.textContent = newTaskName;
    } catch (error) {
        console.error('Error modifying task:', error);
    }
}

deleteButtons.forEach(button => {
    button.addEventListener('click', deleteTask);
});

const deleteTask = async function(e) {
    e.preventDefault();
    const taskCheckbox = this.parentNode.parentNode.querySelector('.form-check-input');
    
    if (!taskCheckbox.checked && !confirm("Are you sure you want to delete this task?")) return;

    try {
        await fetch(URL_ACTIONS, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'delete_task',
                taskId: this.dataset.id
            })
        });

        // Remove task row from the table
        this.parentNode.parentNode.remove();
    } catch (error) {
        console.error('Error deleting task:', error);
    }
}

// Add event listeners to modify and delete links
document.querySelectorAll('.edit-task').forEach(link => {
    link.addEventListener('click', modifyTask);
});

document.querySelectorAll('.delete-task').forEach(link => {
    link.addEventListener('click', deleteTask);
});


