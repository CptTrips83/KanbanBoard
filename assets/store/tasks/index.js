import {state} from "./state";
import {mutations} from "./mutations";
import {actions} from "./actions";
import {getters} from "./getters";



const tasksModule = {
    state,
    mutations,
    actions,
    getters: getters
};

export default tasksModule;