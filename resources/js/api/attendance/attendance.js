import axios from 'axios';

export default {

    getAttendance(params) {
        return axios.get(`/attendance/get-attendance?date=${params.date}&page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeAttendance(data) {
        return axios.post('/attendance/store-attendance', data)
    },
    updateAttendance(id, data) {
        return axios.post(`/attendance/update-attendance/${id}`, data)
    }

}
