export const getters = {
    /**
     * Determines whether the user is authenticated or not based on the provided state.
     *
     * @param {object} state - The state object containing authentication information.
     * @return {boolean} - Returns true if the user is authenticated, otherwise false.
     */
    isAuthenticated(state) {
        return state.isAuthenticated;
    },
    getCurrentUser(state, _, __, rootGetters) {
        return rootGetters.getUserById(state.userId);
    },
    getUserId(state) {
        return state.userId;
    },
    getUserIdentifier(state) {
        return state.userIdentifier;
    },
};