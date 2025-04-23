export const getters = {
    /**
     * Returns the user object based on the given user ID.
     *
     * @param {Array} users - The array of user objects.
     * @returns {function} - A callback function to find a user by ID.
     */
    getUserById: ({users}) => (id) => {
        return users.find(user => user.userId === Number(id));
    }
};