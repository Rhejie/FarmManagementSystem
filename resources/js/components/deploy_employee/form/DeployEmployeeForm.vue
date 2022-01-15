<template>
    <el-card class="box-card" style="margin-bottom: 10px;">
        <div  class="text item">
            <el-form :inline="true" :model="form" :rules="rules" ref="form" class="demo-form-inline">
                <el-form-item label="Employee" prop="employee_id">
                    <el-select
                        v-model="form.employee_id"
                        filterable
                        remote
                        style="width:340px"
                        reserve-keyword
                        @change="attendanceChange"
                        placeholder="Please enter a keyword to search employee"
                        :remote-method="remoteMethodEmployee"
                        :loading="loading">
                            <el-option
                                v-for="item in employees"
                                :key="item.id"
                                :label="`${item.lastname}, ${item.firstname} ${item.middlename}`"
                                :value="item.id">
                            </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Date" prop="date">
                    <el-date-picker
                        v-model="form.date"
                        type="datetime"
                        style="width:100%"
                        format="yyyy-MM-dd h:mm a"
                        value-format="yyyy-MM-dd h:mm a"
                        placeholder="Select date">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="Area" prop="area_id">
                    <el-select
                        v-model="form.area_id"
                        filterable
                        style="width:100%"
                        remote
                        reserve-keyword
                        @change="changeArea"
                        placeholder="Please enter a keyword to search area"
                        :remote-method="remoteMethodArea"
                        :loading="loadingArea">
                            <el-option
                                v-for="item in areas"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                            </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="submitForm('form')">Deploy</el-button>
                    <el-button @click="resetForm('form')">Reset</el-button>
                </el-form-item>
            </el-form>
        </div>
    </el-card>
</template>
<script>
export default {
    name: 'AttendanceForm',
    data() {
        return {
            form: {
                employee_id: '',
                area_id: '',
                date: '',
            },
            rules : {
                area_id: [
                    { required: true, message: 'Please input area', trigger: 'blur' }
                ],
                date: [
                    { required: true, message: 'Please input date', trigger: 'blur' }
                ],
                employee_id: [
                    { required: true, message: 'Please select employee', trigger: 'blur' }
                ],
            },
            employees: [],
            loading: false,
            areas: [],
            loadingArea: false,
        }
    },
    created() {
        this.form.date = new Date()
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                this.storeAttendance();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async remoteMethodEmployee(query) {
            try {
                if(query !== '') {
                    this.loading = true;
                    const res = await this.$API.Employee.searchEmployee(query);
                    this.employees = res.data;
                    this.loading = false;
                }
            } catch (error) {
                console.log(error);
            }
        },
        attendanceChange() {
            this.employees = []
        },
        async remoteMethodArea(query) {
            try {
                if(query !== '') {
                    this.loadingArea = true;
                    const res = await this.$API.Area.searchArea(query);
                    this.areas = res.data;
                    this.loadingArea = false;
                }
            } catch (error) {
                console.log(error);
            }
        },
        changeArea(value) {
            this.form.area_id_id = null;
            this.form.area_id = value;
        },
        async storeAttendance() {
            try {
                // this.form.time_in = this.$df.formatDate(this.form.time_in, "H:mm:ss")
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD h:mm:ss")
                const res = await this.$API.Deploy.storeDeploy(this.form);

                if(res.data == 'already_deploy') {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Already Deploy'
                    });
                    this.resetForm('form');
                    return
                }
                this.$EventDispatcher.fire('NEW_DATA', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Time In',
                    type: 'success'
                });
                this.resetForm('form');
            } catch (error) {
                console.log(error);
            }
        }
    },
}
</script>
