export const getters = {
    getTasksByStatus: ({ tasks }) => (status) => {
        let filteredTasks = tasks.filter(task => task.status === Number(status));

        return filteredTasks.sort((taskA, taskB) => {
            if(taskA.priority > taskB.priority) {
                return -1;
            } else if (taskA.priority < taskB.priority) {
                return 1;
            } else {
                return 0;
            }
        });
    },
    getTaskById: ({ tasks }) => (taskId) => {
        return tasks.find(task => task.id === Number(taskId));
    },
    getTaskEntryMaxId({ tasks }) {
        let maxValue = 0;
        tasks.map((el) => {
            const valueFromObject = el.id;
            maxValue = Math.max(maxValue, valueFromObject);
        });
        return maxValue;
    },
    getTaskCommentMaxId({ tasks }) {
        let maxValue = 0;
        tasks.map((task) => {
            task.comments.map((el) => {
                const valueFromObject = el.id;
                maxValue = Math.max(maxValue, valueFromObject);
            }) ;
        });
        return maxValue;
    }
}