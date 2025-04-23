import {getData, postData} from "../../mixins/ajaxRequests/tools";

const routeSave = '/api/taskEntry/save';
const routeLoad = '/api/taskEntry/load';

// TODO Save für einzelne Task

export const actions = {
    loadTasksFromDB(context) {
        return getData(routeLoad, {
            headers: {
                //'X-AUTH-TOKEN': store.getters.getApiKey,
                'X-Requested-With': 'XMLHttpRequest'
            },
        }).then((response) => {
            const tasks = response.data;

            tasks.forEach((task) => {
                context.commit('updateTasks', task);
            });
        });
    },
    saveTaskToDB(context, payload) {
        let task = payload;

        postData(routeSave, task)
            .then(response => {
                task.synchron = true;
                context.commit('updateTasks', task);
            });
    },
    saveTasksToDB(context) {
        let tasks = context.state.tasks;

        postData(routeSave, tasks)
            .then(response => {
                for(let i = 0; i < tasks.length; i++) {
                    let task = tasks[i];
                    task.synchron = true;
                    context.commit('updateTasks', task);
                }
            });
    },
    addTaskEntry(context, payload) {
        context.commit('addTask', payload);

        // API-Aufruf Save
        context.dispatch('saveTasksToDB')
            .then(response => {

            });
    },
    addCommentToTask(context, payload) {
        context.commit('addCommentToTask', payload);

        // API-Aufruf
        context.dispatch('saveTasksToDB')
            .then(response => {

            });
    }
}