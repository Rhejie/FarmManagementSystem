<template>
    <div v-loading="loadingByButton">
        <ImageBarcodeReader
            @decode="onDecode"
            @error="onError">
        </ImageBarcodeReader>
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
    methods: {
        onDecode (decodedString) {
            console.log(decodedString);
            this.timeIn(decodedString)
        },
        onError() {

        },

        async timeIn(decodedString) {

            try {
                this.loadingByButton = true
                const res = await this.$API.Attendance.qrCode(decodedString);
                this.loadingByButton = false
            } catch (error) {
                console.log(error);
            }

        }
    },
}
</script>
