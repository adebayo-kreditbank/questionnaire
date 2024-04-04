import axios from "axios";
import { initManualClass } from './authUtils'

let baseURL = 'http://127.0.0.1:8000/api/v1/'; //process.env.VUE_APP_API_URL

axios.defaults.baseURL = baseURL
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + initManualClass().getAuthToken()
let instance = axios.create({ withCredentials: true })

instance.interceptors.request.use(request => {
    request.headers.common['Accept'] = 'application/json';
    request.headers.common['Content-Type'] = 'application/json';
    return request;
})

// dont use try catch on these methods so errors are caught where called
const postRequest = async (endpoint, body) => {
    const response = await axios.post(endpoint, body)
    return response
}

const getRequest = async (endpoint, body) => {
    const response = await axios.get(endpoint, body)
    return response
}

const putRequest = async (endpoint, body) => {
    const response = await axios.put(endpoint, body)
    return response
}

const deleteRequest = async (endpoint, param) => {
    // dont use try catch, so errors can enter catch when called
    const response = await axios.delete(`${endpoint}/${param}`)
    return response
}

export {
    axios,
    postRequest,
    getRequest,
    putRequest,
    deleteRequest
}