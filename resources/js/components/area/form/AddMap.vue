<template>
    <div>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="page_title">ADD AREA</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item"><a href="/areas#/areas">Areas</a></li>
                            <li class="breadcrumb-item active">Add Area</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <el-card class="box-card">
                        <div  class="text item" style="padding-bottom: 20px">
                            <div class="row">
                                <div class="col-md-12">
                                    <el-form :inline="true" ref="form" :rules="rules" :model="form" class="demo-form-inline">
                                        <el-form-item label="Name" prop="name">
                                            <el-input v-model="form.name" placeholder="Name"></el-input>
                                        </el-form-item>
                                        <el-form-item label="Color" prop="color">
                                            <el-color-picker v-model="form.color" style="width:100%" show-alpha></el-color-picker>
                                        </el-form-item>
                                        <el-form-item>
                                            <el-button type="primary" @click="submitForm('form')">Save</el-button>
                                        </el-form-item>
                                    </el-form>
                                </div>
                            </div>
                            <div style="height: 700px; width: 100%">
                                <l-map data="parent"  :zoom=13 :center="getArea">
                                    <l-control position="topleft">
                                        <button class="btn btn-default btn-sm" style="margin-bottom: 10px" @click="flipActive">
                                        {{ isCreate ? 'Deactivate' : 'Activate' }}
                                        </button> <br>
                                        <button class="btn btn-default btn-sm"  style="margin-bottom: 10px" @click="deleteMap">
                                            Delete
                                        </button>

                                    </l-control>
                                    <l-free-draw v-model="polygons" :mode="mode" :color="form.color"/>
                                    <l-tile-layer :url="url"></l-tile-layer>
                                </l-map>
                            </div>
                        </div>
                    </el-card>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
import { latLng , Icon } from "leaflet";
import { LMap, LTileLayer, LMarker, LPopup, LTooltip , LCircle, LIcon, LPolygon, LControl } from "vue2-leaflet";
import LFreeDraw from 'vue2-leaflet-freedraw';
import { NONE, ALL, DELETE } from 'leaflet-freedraw';
export default {
    name: 'AddMap',
    props: {
        mode: null
    },
    components: {
        LMap,
        LTileLayer,
        LMarker,
        LPopup,
        LTooltip,
        LCircle,
        LIcon,
        LPolygon,
        LFreeDraw,
        LControl
    },
    data() {
        return {
            zoom: 10,
            center: latLng(0, 0),
            url: 'https://tile.thunderforest.com/cycle/{z}/{x}/{y}.png?apikey=cac1c63e746741a79462820881e7f2c6',
            attribution: 'Farm Management',
            mapOptions: {
                zoomSnap: 0.5
            },
            showMap: true,
            coordinates: {},
            isCreate: false,
            polygons: [],
            map: null,
            form: {
                name: '',
                color: ''
            },
            rules : {
                name: [
                    { required: true, message: 'Please input name', trigger: 'blur' }
                ],
                color: [
                    { required: true, message: 'Please input select color', trigger: 'blur' }
                ],
            },
            loadingMap: false
        }
    },
    mounted() {
        this.getLocation()
    },
    created() {

    },
    computed: {
        mode() {
            return this.isCreate ? (ALL ^ DELETE) : NONE
        },
        getArea() {
            return latLng(this.coordinates.lat, this.coordinates.lng)
        }
    },
    methods: {
        async getLocation() {
            try {
                const coordinates = await this.$getLocation({
                    enableHighAccuracy: true
                });
                this.coordinates = coordinates
            } catch (error) {
                console.log(error);
            }
        },
        flipActive() {
            this.isCreate = !this.isCreate;
        },
        deleteMap() {
            this.polygons = []
        },
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
            this.polygons = []
            this.$refs[formName].resetFields();
        },
        async storeArea() {
            try {
                if(this.polygons.length < 0) {
                    this.$notify.error({
                            title: 'Error',
                            message: 'Draw and Area first'
                        });
                    return;
                }
                this.form.coordinates = this.polygons
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
    },
    watch: {
        polygons(val) {
            if(val.length > 1) {
                this.polygons.splice(1, 1)
            }
        }
    }
}
</script>
