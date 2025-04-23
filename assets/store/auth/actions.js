import {getData} from "../../mixins/ajaxRequests/tools";

export const actions = {
    /**
     * Checks the authentication status by making a GET request to the '/api/user/checkAuthentication' route.
     *
     * @param {Object} context - The context object that contains the state and mutations for Vuex store.
     * @returns {Promise} - A promise that resolves when the authentication status is checked.
     */
    checkAuthentication(context) {
        const route = '/api/user/checkAuthentication';

        return getData(route, {
            headers: {
                //'X-AUTH-TOKEN': store.getters.getApiKey,
                'X-Requested-With': 'XMLHttpRequest'
            },
        }).then((response) => {
            context.commit('setAuthenticated', (response.status === 200));
            context.commit('setUserId', response.data.userId);
            context.commit('setUserIdentifier', response.data.userIdentifier);
        }).catch((error) => {
            context.commit('setAuthenticated', (error.response.status !== 401));
            context.commit('setUserId', "");
            context.commit('setUserIdentifier', "");
        }).finally(() => {
            if (context.state.isAuthenticated === false) window.location.reload();
        })
    }
};