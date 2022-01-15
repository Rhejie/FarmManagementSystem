<template>
    <el-card class="box-card">
        <div  class="text item">
            <el-button size="mini" type="primary" @click="addQRCode" style="float:right;">Generate QR Code</el-button>
            <el-input
                size="mini"
                placeholder="Search here....."
                style="width:300px; float:right; margin-right: 10px"
                @keyup.enter.native="applySearch"
                v-model="search">
            </el-input>

        </div>
    </el-card>
</template>
<script>
export default {
    name: 'QrcodeList',
    data() {
        return {
            search: '',
        }
    },
    created() {
        search
    },
    methods: {
        async getQRcodes() {

        },
        addQRCode() {

        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getQRcodes();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getQRcodes();
        },
        applySearch() {
            this.getQRcodes();
        },
    },
}
</script>
