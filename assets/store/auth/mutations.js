export const mutations = {
    /**
     * Sets the API token in the given state object.
     *
     * @param {Object} state - The state object where the API token will be set.
     * @param {string} userId - The API token to set in the state object.
     * @returns {void}
     */
    setUserId(state, userId) {
        state.userId = userId;
    },
    /**
     * Sets the authentication state.
     *
     * @param {Object} state - The current state object.
     * @param {boolean} isAuthenticated - The new authentication state.
     * @return {void}
     */
    setAuthenticated(state, isAuthenticated) {
        state.isAuthenticated = isAuthenticated;
    },
    setUserIdentifier(state, userIdentifier) {
        state.userIdentifier = userIdentifier;
    }
};