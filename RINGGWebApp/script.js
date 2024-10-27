document.addEventListener("DOMContentLoaded", function () {
    const addTaskButton = document.getElementById("add-task");
    const saveTasksButton = document.getElementById("save-tasks");
    const taskList = document.getElementById("task-list");

    // Verificação para garantir que o taskList não é null
    if (!taskList) {
        console.error("Elemento 'task-list' não encontrado!");
        return;
    }

    if (addTaskButton) {
        addTaskButton.addEventListener("click", function () {
            const title = document.getElementById("task-title").value.trim();
            const checkboxTitle = document.getElementById("checkbox-title").value.trim();
            const priority = document.getElementById("priority").value;
            const startDate = document.getElementById("start-date").value;
            const endDate = document.getElementById("end-date").value;

            if (!title || !checkboxTitle || !startDate || !endDate) {
                alert("Por favor, preencha todos os campos obrigatórios.");
                return;
            }

            fetch("php/add_task.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    title,
                    checkboxTitle,
                    priority,
                    startDate,
                    endDate,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadTasks();
                    clearInputs();
                } else {
                    alert("Erro ao adicionar tarefa: " + data.message);
                }
            });
        });
    }

    if (saveTasksButton) {
        saveTasksButton.addEventListener("click", function () {
            fetch("php/save_tasks.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ action: 'save' }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Tarefas salvas com sucesso!");
                } else {
                    alert("Erro ao salvar tarefas: " + data.message);
                }
            });
        });
    }

    function loadTasks() {
        fetch("php/fetch_tasks.php")
            .then(response => response.json())
            .then(tasks => {
                taskList.innerHTML = ""; // Limpa a lista antes de adicionar
                tasks.forEach(task => {
                    const taskDiv = document.createElement("div");
                    taskDiv.className = "task";
                    taskDiv.style.borderLeft = `5px solid ${task.priority}`;
                    taskDiv.innerHTML = `
                        <h3 contenteditable="true">${task.title}</h3>
                        <input type="checkbox"> ${task.checkbox_title}
                        <span>${task.start_date} - ${task.end_date}</span>
                        <button onclick="deleteTask(${task.id})">Remover</button>
                    `;
                    taskList.appendChild(taskDiv);
                });
            });
    }

    window.deleteTask = function (taskId) {
        fetch("php/delete_task.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: taskId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadTasks(); // Recarrega as tarefas após a exclusão
            } else {
                alert("Erro ao remover tarefa: " + data.message);
            }
        });
    };

    function clearInputs() {
        document.getElementById("task-title").value = '';
        document.getElementById("checkbox-title").value = '';
        document.getElementById("priority").value = '';
        document.getElementById("start-date").value = '';
        document.getElementById("end-date").value = '';
    }

    loadTasks();
});
