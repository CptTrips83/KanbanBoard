import {createStore} from "vuex";
import authModule from "./auth/index";
import tasksModule from "./tasks";
import userModule from "./user";

const store = createStore({
    modules: {
        auth: authModule,
        tasks: tasksModule,
        user: userModule,
    }
});

export default store;