import axios from 'axios';

export default {

    getDeploy(params) {
        return axios.get(`/deploy-employee/get-deploy?date=${params.date}&page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeDeploy (data) {
        return axios.post(`/deploy-employee/store-deploy`, data)
    },
    updateDeploy (id, data) {
        return axios.post(`/deploy-employee/update-deploy/${id}`, data)
    },
    deleteDeploy (id) {
        return axios.post(`/deploy-employee/delete-deploy/${id}`)
    }

}
