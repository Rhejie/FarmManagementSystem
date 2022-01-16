<template>
    <div v-loading="loadingByButton">
        <div class="container-fluid">
            <ImageBarcodeReader
                @decode="onDecode"
                @error="onError">
            </ImageBarcodeReader>
        </div>


            <StreamBarcodeReader
                @decode="onDecode"
                @loaded="onLoaded"
            ></StreamBarcodeReader>

    </div>
</template>
<script>
import { StreamBarcodeReader } from "vue-barcode-reader";

import { ImageBarcodeReader } from "vue-barcode-reader";
export default {
    name: 'QrCodeScanner',
    components: {
        ImageBarcodeReader,
        StreamBarcodeReader
    },
    data() {
        return {
            loadingByButton: false,
        }
    },
    created() {
        this.hasUserMedia()
    },
    methods: {
        hasUserMedia() {
        //check if the browser supports the WebRTC
        return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia);
        } ,
        onDecode (decodedString) {
            console.log(decodedString);
            this.timeIn(decodedString)
        },
        onError() {

        },

        onLoaded() {

        },

        async timeIn(decodedString) {

            try {
                this.loadingByButton = true
                const res = await this.$API.Attendance.qrCode(decodedString);
                if(res.data == 'success_in') {
                    this.$message({
                        message: 'Successfully Time In.',
                        type: 'success'
                    });
                }
                if(res.data == 'success_out') {
                    this.$message({
                        message: 'Successfully Time Out.',
                        type: 'success'
                    });
                }

                if(res.data == 'success_ot_in') {
                    this.$message({
                        message: 'Successfully Overtime in.',
                        type: 'success'
                    });
                }

                if(res.data == 'success_ot_out') {
                    this.$message({
                        message: 'Successfully Overtime Out.',
                        type: 'success'
                    });
                }

                if(res.data == 'already_time_in_out') {
                    this.$message.error('Oops. Already Time in and out');
                }
                this.loadingByButton = false
            } catch (error) {
                console.log(error);
            }

        }
    },
}
</script>
