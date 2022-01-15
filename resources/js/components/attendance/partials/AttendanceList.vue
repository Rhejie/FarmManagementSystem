<template>
    <el-card class="box-card">
        <div  class="text item">
            <el-input
                size="mini"
                placeholder="Search here....."
                clearable
                style="width:300px; float:right; margin-right: 10px"
                @keyup.enter.native="applySearch"
                v-model="search">
            </el-input>
            <el-date-picker
                v-model="date"
                @change="changeDate"
                type="date"
                :clearable="false"
                placeholder="Pick a day">
            </el-date-picker>
            <el-table
                :data="attendance"
                v-loading="loading"
                style="width: 100%">
                    <el-table-column
                        width="70"
                        label="No."
                        :sortable="true">
                            <template slot-scope="scope">
                                {{scope.$index + 1}}
                            </template>
                    </el-table-column>
                    <el-table-column
                        prop="employee"
                        label="NAME"
                        :sortable="true">
                            <template slot-scope="scope">
                                {{scope.row.employee.lastname}}, {{scope.row.employee.firstname}} {{scope.row.employee.middlename}}
                            </template>
                    </el-table-column>
                    <el-table-column
                        prop="date"
                        label="DATE"
                        :sortable="true">
                    </el-table-column>
                    <el-table-column
                        prop="time_in"
                        label="IN"
                        :sortable="true">
                            <template slot-scope="scope">
                                {{scope.row.time_in | timeFormat}}
                            </template>
                    </el-table-column>
                    <el-table-column
                        prop="time_out"
                        label="OUT"
                        :sortable="true">
                            <template slot-scope="scope">
                                {{scope.row.time_out | timeFormat}}
                            </template>
                    </el-table-column>
                    <el-table-column
                        fixed="right"
                        width="110"
                        label="ACTION">
                        <template slot-scope="scope">
                            <button @click="handleOut(scope.row)" v-if="!scope.row.time_out" class="btn btn-danger btn-sm"><i class="fas fa-power-off"></i> out</button>
                            <!--button @click="askToDelete(scope.$index, scope.row)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></!--button -->
                        </template>
                    </el-table-column>
            </el-table>
            <global-pagination
                :current_page="current_page"
                :current_size="current_size"
                :pagination="attendancePagination"
                :total="filters.total"
                @handleSizeChange="handleSizeChange"
                @handleCurrentChange="handleCurrentChange">
            </global-pagination>
        </div>
        <el-dialog :title="name" width="30%" :visible.sync="dialogTableVisible" :before-close="handleClose">
            <attendance-out-form :model="model"></attendance-out-form>
        </el-dialog>
    </el-card>
</template>
<script>
import paginate from '../../../mixin/pagination'
import moment from 'moment'
export default {
    name: 'AttendanceList',
    mixins: [paginate],
    data() {
        return {
            attendance: [],
            attendancePagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            mode: '',
            model: {},
            dialogTableVisible: false,
            date: null,
            name: ''
        }
    },
    created() {
        this.date = new Date();
        this.getAttendance()

        this.$EventDispatcher.listen('NEW_DATA', data => {
            this.attendance.unshift(data)
            this.dialogTableVisible = false
            this.mode = ''
        })

        this.$EventDispatcher.listen('UPDATE_DATA', data => {
            this.attendance.forEach(cat => {
                if(cat.id == data.id) {
                    for(let key in data) {
                        cat[key] = data[key]
                    }
                }
            })

            this.dialogTableVisible = false
            this.mode = ''
        })
    },
    filters: {
        timeFormat(value) {
            if(value) {
                return moment(value, 'HH:mm:ss').format('h:mm a')
            }
            return '-'
        }
    },
    methods: {
        async getAttendance() {
            try {
                this.date = this.$df.formatDate(this.date, "YYYY-MM-DD")

                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                    date: this.date,
                };

                this.loading = true;
                const res = await this.$API.Attendance.getAttendance(params);
                this.attendance = res.data.data;
                this.attendancePagination = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        addAttendance() {
            this.dialogTableVisible = true;
            this.model = {}
            this.mode = 'create';
        },
        handleOut(data) {
            this.$confirm('Are yous sure you want to time out?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                    }).then(() => {
                        this.timeOut(data)
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: 'Time out canceled'
                        });
                    });
        },
        async timeOut(data) {
            let form = {
                time_out: ''
            }
            const res = await this.$API.Attendance.updateAttendance(data.id, form);
            this.$EventDispatcher.fire('UPDATE_DATA', res.data);
            this.$notify({
                title: 'Success',
                message: 'Successfully Time Out',
                type: 'success'
            });
        },
        handleEdit(data) {
            this.model = {...data};
            this.dialogTableVisible = true;
            this.mode = 'update'
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.delete(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async delete(index, data) {
            try {
                await this.$API.Attendance.deleteArea(data.id)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.attendance.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        changeDate(value) {
            this.date = value
            this.getAttendance();
        },
        handleClose(done) {
            this.$EventDispatcher.fire('CLOSE_MODAL')
            done();
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getAttendance();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getAttendance();
        },
        applySearch() {
            this.getAttendance();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getAttendance();
            }
        }
    }
}
</script>
