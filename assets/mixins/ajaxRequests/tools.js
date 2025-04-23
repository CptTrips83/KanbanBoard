import axios from "axios";

/**
 * Retrieves data from the specified route using GET method.
 *
 * @param {string} route - The URL route to send the GET request to.
 * @param {object} params - Optional query parameters to be included in the request.
 *
 * @return {Promise} A promise that resolves with the response data if the request is successful, or rejects with an error if the request fails.
 */
export const getData = function getData(route, params) {
    return axios.get(route, {
        headers: {
            //'X-AUTH-TOKEN': store.getters.getApiKey,
            'X-Requested-With': 'XMLHttpRequest'
        },
        params: params
    }).then((response) => {
        return response;
    }).catch((error) => {
        return error;
    })
}
/**
 * Makes a POST request to the specified route with the given data.
 *
 * @param {string} route - The URL route to send the request to.
 * @param {Object} data - The data to send with the request.
 * @return {Promise} A Promise that resolves with the response object if the request is successful,
 *                   or rejects with an error object if the request fails.
 */
export const postData = function postData(route, data) {
    return axios.post(route, data, {
        headers: {
            //'X-AUTH-TOKEN': store.getters.getApiKey,
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then((response) => {
        return response;
    }).catch((error) => {
        return error;
    })
}
/**
 * Update data using PUT method.
 *
 * @param {string} route - The route to send the PUT request to.
 * @param {Object} data - The data to be sent in the request body.
 * @return {Promise} - A Promise that resolves to the response object if the request is successful, otherwise rejects with an error object.
 */
export const putData = function putData(route, data) {
    return axios.put(route, data, {
        headers: {
            //'X-AUTH-TOKEN': store.getters.getApiKey,
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then((response) => {
        return response;
    }).catch((error) => {
        return error;
    })
}
/**
 * Make a PATCH request to the specified route with the given data.
 * @param {string} route - The route to make the PATCH request to.
 * @param {object} data - The data to send in the request body.
 * @return {Promise} - A promise that resolves with the response from the request.
 */
export const patchData = function patchData(route, data) {
    return axios.patch(route, data, {
        headers: {
            //'X-AUTH-TOKEN': store.getters.getApiKey,
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then((response) => {
        return response;
    }).catch((error) => {
        return error;
    })
}
/**
 * Deletes data using Axios DELETE request.
 *
 * @param {string} route - The route to send the DELETE request to.
 * @param {object} params - The parameters to send with the DELETE request (if any).
 * @return {Promise} A Promise that resolves to the response from the DELETE request.
 */
export const deleteData = function deleteData(route, params) {
    return axios.delete(route, {
        headers: {
            //'X-AUTH-TOKEN': store.getters.getApiKey,
            'X-Requested-With': 'XMLHttpRequest'
        },
        params: params
    }).then((response) => {
        return response;
    }).catch((error) => {
        return error;
    })
}