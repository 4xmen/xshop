<template>
    <div id="latlng">
        <div ref="mapContainer" :style="'height: 300px;'+mapStyle"></div>
        <template v-if="this.xname != 'NOTHING'">
            <input type="hidden" :name="xname" :value="allData">
        </template>
    </div>
</template>

<script>

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

export default {
    name: "latlng",
    components: {},
    data: () => {
        return {
            map: null,
            marker: null,
            zoom: 10,
            address: '',
            zip: '',
            lat: null,
            lng: null,
            firstMove: false,
            currentZoom: 10,
        }
    },
    props: {
        xname: {
            default: 'NOTHING',
            type: String,
        },
        darkMode: {
            type: Boolean,
            default: false,
        },
        ilat: { // init lat
            type: Number,
            default: 35.83266000,
        },
        ilng: { // init lng
            type: Number,
            default: 50.99155000,
        },
        izoom: {
            type: Number,
            default: 10,
        },
    },
    mounted() {
        this.lat = this.ilat;
        this.lng = this.ilng;
        this.zoom = this.izoom;
        this.currentZoom = this.izoom;
        this.initMap();
    },
    computed: {
        mapStyle() {
            if (this.darkMode) {
                return 'filter: invert(100%) hue-rotate(120deg) brightness(95%) contrast(90%);';
            }
            return '';
        },
        allData() {
            return this.lat + ',' + this.lng + ',' + this.currentZoom;
        },
    },
    methods: {
        initMap() {
            if (!import.meta.env.DEV){
                L.Icon.Default.mergeOptions({
                    iconRetinaUrl: "/assets/vendor/leaflet/marker-icon-2x.png",
                    iconUrl: "/assets/vendor/leaflet/marker-icon.png",
                    shadowUrl: "/assets/vendor/leaflet/marker-shadow.png"
                });
            }
            
            this.map = L.map(this.$refs.mapContainer).setView([this.lat, this.lng], this.zoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; openstreetmap',
                attributionControl: false,
            }).addTo(this.map);

            this.map.on('click', this.onMapClick);
            this.map.attributionControl.setPrefix('xShop');

            if (this.marker) {
                this.map.removeLayer(this.marker);
            }

            this.marker = L.marker({lat: this.lat, lng: this.lng}).addTo(this.map);
            // You can emit the selected location or perform any other desired action here
            // console.log('Selected location:', e.latlng);

            this.map.on("moveend", () => {
                if (!this.firstMove) {
                    this.map.invalidateSize();
                    this.firstMove = true;
                }
            });
            this.map.on("zoomend", (e, x) => {
                this.map.invalidateSize();
                this.firstMove = true;
                this.currentZoom = e.target._zoom;
            });
            try {
                document.querySelector('#lat').value = this.lat;
                document.querySelector('#lng').value = this.lng;
            } catch (e) {
                console.log(e.message);
            }


        },
        onMapClick(e) {
            if (this.marker) {
                this.map.removeLayer(this.marker);
            }

            this.marker = L.marker(e.latlng).addTo(this.map);
            // You can emit the selected location or perform any other desired action here
            // console.log('Selected location:', e.latlng);
            this.lat = e.latlng.lat;
            this.lng = e.latlng.lng;

            try {
                document.querySelector('#lat').value = this.lat;
                document.querySelector('#lng').value = this.lng;
            } catch (e) {
                console.log(e.message);
            }

        },
        // changeMapCenter(lat, lng) {
        //     try {
        //
        //         this.map.setView([lat, lng], this.zoom);
        //     } catch (e) {
        //         // console.log(e.message);
        //         setTimeout(() => {
        //             console.log('repeat');
        //             this.changeMapCenter(lat, lng);
        //         }, 10);
        //     }
        //
        //     // Change the map center to [40.7128, -74.0059] (New York City) with zoom level 12
        //
        // },
    }
}
</script>

<style scoped>
#latlng {

}
</style>
