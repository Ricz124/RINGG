document.addEventListener("DOMContentLoaded", function () {
    const addTaskButton = document.getElementById("add-task");
    const taskList = document.getElementById("task-list");

    addTaskButton.addEventListener("click", function () {
        const title = document.getElementById("task-title").value;
        const checkboxTitle = document.getElementById("checkbox-title").value;
        const priority = document.getElementById("priority").value;
        const startDate = document.getElementById("start-date").value;
        const endDate = document.getElementById("end-date").value;

        if (title && checkboxTitle && startDate && endDate) {
            fetch("add_task.php", {
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
                } else {
                    alert("Erro ao adicionar tarefa");
                }
            });
        }
    });

    function loadTasks() {
        fetch("fetch_tasks.php")
            .then(response => response.json())
            .then(tasks => {
                taskList.innerHTML = "";
                tasks.forEach(task => {
                    const taskDiv = document.createElement("div");
                    taskDiv.className = "task";
                    taskDiv.style.borderLeft = `5px solid ${task.priority}`;
                    taskDiv.innerHTML = `
                        <h3>${task.title}</h3>
                        <input type="checkbox"> ${task.checkboxTitle}
                        <span>${task.start_date} - ${task.end_date}</span>
                        <button onclick="deleteTask(${task.id})">Remover</button>
                    `;
                    taskList.appendChild(taskDiv);
                });
            });
    }

    window.deleteTask = function (taskId) {
        fetch("delete_task.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: taskId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadTasks();
            } else {
                alert("Erro ao remover tarefa");
            }
        });
    };

    loadTasks();
});
