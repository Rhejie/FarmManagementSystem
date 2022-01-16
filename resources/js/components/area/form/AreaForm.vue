<template>
    <el-form :model="form" :rules="rules" ref="form" label-position="top" label-width="120px" class="demo-ruleForm">
        <div class="row">
            <div class="col-md-12">
                <el-form-item label="Name" prop="name">
                    <el-input v-model="form.name" placeholder="Name"></el-input>
                </el-form-item>
            </div>
            <div class="col-md-12">
                <el-form-item style="float:right">
                    <el-button type="primary" @click="submitForm('form')">Submit</el-button>
                    <el-button @click="resetForm('form')">Reset</el-button>
                </el-form-item>
            </div>
        </div>
    </el-form>
</template>
<script>
export default {
    name: 'AreaForm',
    props: {
        model: {},
        mode: null
    },
    data() {
        return {
            form: {
                name: '',
                lat: 0,
                lng: 0,
            },
            rules : {
                name: [
                    { required: true, message: 'Please input category name', trigger: 'blur' }
                ],
            },
            coordinates: {
                lat: 0,
                lng: 0
            }
        }
    },
    created() {

        this.$EventDispatcher.listen('CLOSE_MODAL', () => {
            this.resetForm('form');
        })

        if(this.model && this.model.id) {
            this.form = {
                name: this.model.name
            }
        }

        this.getLocation();
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateArea();
                    return;
                }

                this.storeArea();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async getLocation() {
            try {
                const coordinates = await this.$getLocation({
                    enableHighAccuracy: true
                });
                this.coordinates = coordinates;
                this.noLocation = false;
            } catch (error) {
                console.log(error);
            }
        },
        async storeArea() {
            try {
                this.form.coordinates = this.coordinates
                const res = await this.$API.Area.storeArea(this.form)
                this.$EventDispatcher.fire('NEW_DATA', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully added',
                    type: 'success'
                });
                this.resetForm('form');
            } catch (error) {
                console.log(error);
            }
        },
        async updateArea() {
            try {
                const res = await this.$API.Area.updateArea(this.model.id, this.form)
                this.$EventDispatcher.fire('UPDATE_DATA', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully updated',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal) {
                this.form = {
                    id: newVal.id,
                    name: newVal.name,
                }
            }
        },
        mode(val) {
            if(val && val == 'create') {
                this.form = {
                    name: ''
                }
            }
        }
    }
}
</script>
