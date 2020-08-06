import { ACCESS_TOKEN } from "../env"
import axios from "../Config/axiosconfig";
import cookie from 'react-cookies';

export const request = (options) => {
    const CancelToken = axios.CancelToken;
    const source = CancelToken.source();
    options.cancelToken = source.token
    let headers = {}
    if (cookie.load("token")) {
        headers["Authorization"] = 'Bearer ' + cookie.load("token")
    }
    headers = Object.assign(headers, options.headers ? options.headers : {})
    if (options.headers) {
        delete options.headers
    }
    const defaults = { headers: headers }
    options = Object.assign({}, defaults, options)
    return axios(options);
}