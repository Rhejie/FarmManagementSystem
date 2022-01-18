import axios from 'axios'

export default {

    getBananaReport(area) {
        return axios.get(`/report/banana-report/${area}`);
    }

}
