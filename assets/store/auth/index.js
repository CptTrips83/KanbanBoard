import {state} from "./state";
import {mutations} from "./mutations";
import {actions} from "./actions";
import {getters} from "./getters";



const authModule = {
    state,
    mutations,
    actions,
    getters: getters
};

export default authModule;