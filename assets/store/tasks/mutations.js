export const mutations = {
    addTask(state, payload) {
        state.tasks.push(payload.task);
    },
    removeTask(state, task) {
        const index = state.tasks.findIndex(t => t.id === task.id);
        if (index !== -1) {
            state.tasks.splice(index, 1);
        }
    },
    clearTasks(state) {
        state.tasks.splice(0,state.tasks.length);
    },
    updateTasks(state, task) {
        const index = state.tasks.findIndex(t => t.id === task.id);
        if (index !== -1) {
            state.tasks.splice(index, 1);
        }
        state.tasks.push(task);
    },
    addCommentToTask(state, payload){
        const taskId = payload.taskEntryId;
        const newTaskComment = payload.comment;

        const task= state.tasks.find(task => task.id === Number(taskId));

        task.comments.push(newTaskComment);
    }
}