import axios from "axios"
axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error) {
        console.log(error.response.data.message)
    }
    return Promise.reject(error)
})
export default axios;