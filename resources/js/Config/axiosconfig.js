import axios from "axios"
import axiosCancel from 'axios-cancel';
/* const CancelToken = axios.CancelToken;
let cancel;
axios.interceptors.request.use((config) => {
    if (cancel) {
        cancel();
    }
    config.cancelToken = new CancelToken(function executor(c) {
        cancel = c;
    })
    return config;
}) */
axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error) {
        console.log(error.response.data.message)
    }
    return Promise.reject(error)
})
export default axios
