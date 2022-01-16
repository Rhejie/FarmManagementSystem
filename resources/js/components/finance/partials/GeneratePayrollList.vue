<template>
    <div>
        <div class="row">
            <div class="col-md-12" style="padding:10px">
                <el-button @click="generatePayroll" style="float:right; " type="primary" v-if="payroll.length > 0 & rate !== null">Generate Payrolll</el-button>
                <el-input placeholder="Please input rate per day" @change="changeRate" style="width:300px" type="number" v-if="payroll.length > 0" v-model="rate"></el-input>
            </div>
        </div>
        <el-table
            v-loading="loading"
            element-loading-text="Loading..."
            element-loading-spinner="el-icon-loading"
            element-loading-background="rgba(0, 0, 0, 0.8)"
            :data="payroll"
            style="width: 100%">
                <el-table-column label="REGULAR HOURS">
                    <el-table-column
                        prop="date"
                        label="DATE">
                            <template slot-scope="scope">
                                {{scope.row.date | fileDate}}
                            </template>
                    </el-table-column>
                    <el-table-column
                        prop="status"
                        label="STATUS">
                            <template slot-scope="scope">
                                <template v-if="scope.row.status == 'Full'">
                                    <el-tag type="success" effect="dark">{{scope.row.status}}</el-tag>
                                </template>
                                <template v-if="scope.row.status == 'Under Time'">
                                    <el-tag type="primary" effect="dark">{{scope.row.status}}</el-tag>
                                </template>
                                <template v-if="scope.row.status == 'Half Day'">
                                    <el-tag type="warning" effect="dark">{{scope.row.status}}</el-tag>
                                </template>
                            </template>
                    </el-table-column>
                    <el-table-column
                        prop="time_in"
                        label="IN">
                            <template slot-scope="scope">
                                {{scope.row.time_in | timeFormat}}
                            </template>
                    </el-table-column>
                    <el-table-column
                        prop="time_out"
                        label="OUT">
                            <template slot-scope="scope">
                                {{scope.row.time_out | timeFormat}}
                            </template>
                    </el-table-column>
                    <el-table-column
                        prop="rate"
                        label="RATE">

                    </el-table-column>
                </el-table-column>
                    <!--<el-table-column
                        fixed="right"
                        width="110"
                        label="ACTION">
                        <template slot-scope="scope">
                            <button :disabled="scope.row.is_double_pay" @click="handleDoublePay(scope.row)" class="btn btn-success btn-sm">Double Pay</button>
                        </template>
                    </el-table-column> -->
        </el-table>

        <el-input placeholder="Please input rate per hour for overtime" @change="changeRateOT" style="width:300px; margin-top: 20px" type="number" v-if="payroll.length > 0" v-model="rate_ot"></el-input>
        <el-table
            v-loading="loading"
            element-loading-text="Loading..."
            element-loading-spinner="el-icon-loading"
            element-loading-background="rgba(0, 0, 0, 0.8)"
            :data="payroll.filter(pay => pay.ot_in != null && pay.ot_out != null && pay.ot_status == 'Approved')"
            style="width: 100%; margin-top: 20px">
                <el-table-column label="OVERTIME">
                    <el-table-column
                        prop="date"
                        label="DATE">
                            <template slot-scope="scope">
                                {{scope.row.date | fileDate}}
                            </template>
                    </el-table-column>
                    <el-table-column
                        prop="time_in"
                        label="IN">
                            <template slot-scope="scope">
                                {{scope.row.ot_in | timeFormat}}
                            </template>
                    </el-table-column>
                    <el-table-column
                        prop="time_out"
                        label="OUT">
                            <template slot-scope="scope">
                                {{scope.row.ot_out | timeFormat}}
                            </template>
                    </el-table-column>
                    <el-table-column
                        prop="total_hours_ot"
                        label="HOURS">

                    </el-table-column>
                    <el-table-column
                        prop="overtime_rate"
                        label="RATE">

                    </el-table-column>
                </el-table-column>
                    <!--<el-table-column
                        fixed="right"
                        width="110"
                        label="ACTION">
                        <template slot-scope="scope">
                            <button :disabled="scope.row.is_double_pay" @click="handleDoublePay(scope.row)" class="btn btn-success btn-sm">Double Pay</button>
                        </template>
                    </el-table-column> -->
        </el-table>

        <div class="row" style="margin-top: 10px;">
            <div class="col-md-6">
                <table></table>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'GeneratePayrollList',
    data() {
        return {
            payroll: [],
            loading: true,
            employee: {},
            rate: null,
            rate_ot: null
        }
    },
    created() {

        this.$EventDispatcher.listen('RESET_FORM', data => {
            console.log(data)
            this.payroll = []
            this.loading = true
        })
        this.$EventDispatcher.listen('NEW_GENERATE_PAYROLL', data => {

            this.payroll = data.attendance
            this.employee = data.employee
            this.loading = false

        });

    },
    filters: {
        timeFormat(value) {
            if(value) {
                return moment(value, 'HH:mm:ss').format('h:mm a')
            }
            return '-'
        },
        fileDate(value) {
            if(value) {
                return moment(value, 'YYYY-MM-DD').format('YYYY-MMM-DD')
            }
        }
    },
    methods: {
        async generatePayroll() {
            try {
                if(!this.rate || this.rate === 0) {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Please input rate per day'
                    });
                    return;
                }
                if(!this.rate_ot || this.rate_ot === 0) {
                    this.$notify.error({
                        title: 'Error',
                        message: 'Please input rate per hour for overtime'
                    });
                    return;
                }
                this.employee.attendance = this.payroll
                this.employee.rate = this.rate
                const res = await this.$API.Finance.storePayroll(this.employee);
                this.$EventDispatcher.fire('NEW_PAYROLL', res.data)
                this.payroll = []
                this.loading = true
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Generate Payroll',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        changeRate(value) {

            this.payroll = this.payroll.map(pay => {
                let day_total = 0;
                if(pay.total_hours >= 9) {
                    day_total = 9
                }
                else {
                    day_total = pay.total_hours
                }
                let day = parseFloat(day_total) / 9
                pay.rate = day * value;
                pay.rate = pay.rate.toFixed(2)



                return pay
            })
        },
        changeRateOT(value) {
            this.payroll = this.payroll.map(pay => {
                pay.overtime_rate = value * parseFloat(pay.total_hours_ot)
                return pay
            })
        },
        handleDoublePay(data) {
            data.rate = 1
        }
    }
}
</script>
