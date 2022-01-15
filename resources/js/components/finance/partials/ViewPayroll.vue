<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <p>Name: <span style="font-weight: 700">{{name}}</span></p>
                    <p>From: <span style="font-weight: 700">{{payroll.from_date | filteDate}}</span></p>
                    <p>To: <span style="font-weight: 700">{{payroll.to_date | filteDate}}</span></p>
                    <p>Rate: <span style="font-weight: 700">P {{payroll.rate}}</span></p>
                </div>
                <div class="col-md-6">
                    <p>Hours : <span style="font-weight: 700">{{totalHours}}</span></p>
                    <p>Salary : <span style="font-weight: 700">P {{totalSalary | addComma}}</span></p>
                    <p>Generate Payroll : <span style="font-weight: 700">P {{payroll.date}}</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <el-table
                height="300"
                :data="payroll.item"
                style="width: 100%">
                    <el-table-column
                        prop="date"
                        label="DATE">
                            <template slot-scope="scope">
                                {{scope.row.date | filteDate}}
                            </template>
                    </el-table-column>
                    <el-table-column
                        prop="status"
                        label="STATUS">
                    </el-table-column>
                    <el-table-column
                        prop="salary"
                        label="RATE">
                    </el-table-column>
            </el-table>
        </div>
    </div>
</template>
<script>
import moment from "moment"
export default {
    name: 'ViewPayroll',
    props: {
        model: {}
    },
    data() {
        return {
            payroll: {}
        }
    },
    created() {
        this.payroll = this.model
    },
    computed: {
        totalSalary() {
            let total = 0
            this.payroll.item.forEach(pay => {
                total += pay.salary
            })

            return total
        },
        totalHours() {
            let total = 0
            this.payroll.item.forEach(pay => {
                total += (pay.hours - 1)
            })

            return total
        },
        name() {
            return this.payroll.employee.lastname + ", " + this.payroll.employee.firstname
        }
    },
    filters: {
        addComma(value) {
            if(value) {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            else {
                return 0;
            }
        },
        filteDate(value) {
            if(value) {
                return moment(value, 'YYYY-MM-DD').format('YYYY-MMM-DD');
            }
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal) {
                this.payroll = newVal
            }
        }
    }
}
</script>
