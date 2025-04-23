import {deleteData, getData, patchData, postData, putData} from "./tools";

export default {
    methods: {
        getData: getData,
        postData: postData,
        putData: putData,
        patchData: patchData,
        deleteData: deleteData,
    }
}