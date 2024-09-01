<template>
    <div id="address-input">

        <ul class="list-group mb-2">
            <li class="list-group-item" v-for="ad in addresses">
                <div class="btn btn-outline-danger btn-sm float-end mx-2" @click="removing(ad.id)">
                    <i class="ri-close-line"></i>
                </div>
                <div class="btn btn-outline-primary btn-sm float-end" @click="editing(ad)">
                    <i class="ri-edit-2-line"></i>
                </div>
                <div class="p-2">
                    {{ ad.address }}
                </div>
            </li>
        </ul>
        <button type="button" class="btn btn-primary" @click="adding">
            <i class="ri-add-line"></i>
        </button>

        <div id="address-modal" v-if="modal" @click.self="modal = false">
            <div class="card">
                <div class="card-header">
                    {{ translate['addr-editor'] }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="st">
                                {{ translate['state'] }} :
                            </label>
                            <select @change="updateState" class="form-control" v-model="state_id" id="st">
                                <option :data-lat="s.lat" :data-lng="s.lng" :value="s.id" v-for="s in states">
                                    {{ s.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="st">
                                {{ translate['city'] }}:
                            </label>
                            <select @change="updateCity" class="form-control" v-model="city_id" id="st">
                                <option :value="c.id" v-for="c in cities"> {{ c.name }}</option>
                            </select>
                        </div>
                        <div class="col-12 my-3">
                            <div ref="mapContainer" :style="'height: 300px;'+mapStyle"></div>
                        </div>
                        <div class="col-12">
                            <textarea rows="2" class="form-control" :placeholder="translate['address']"
                                      v-model="address"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="zip">
                                {{ translate['post-code'] }}:
                            </label>
                            <input type="text" class="form-control" v-model="zip">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary w-100" type="button" @click="save">
                        <i class="ri-save-2-line"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import {useToast} from 'vue-toast-notification';
import axios from "axios";


const $toast = useToast();

export default {
    name: "address-input",
    components: {},
    data: () => {
        return {
            id: null,
            action: 'add',
            modal: false,
            addresses: [],
            states: [],
            cities: [],
            state_id: null,
            city_id: null,
            map: null,
            marker: null,
            zoom: 10,
            address: '',
            zip: '',
            lat: null,
            lng: null,
        }
    },
    props: {
        listLink: {
            type: String,
            required: true,
        },
        addLink: {
            type: String,
            required: true,
        },
        updateLink: {
            type: String,
            required: true,
        },
        remLink: {
            type: String,
            required: true,
        },
        stateLink: {
            type: String,
            required: true,
        },
        citiesLink: {
            type: String,
            required: true,
        },
        darkMode: {
            type: Boolean,
            default: false,
        },
        translate: {
            default: {},
        }
    },
    async mounted() {
        try {
            let res = await axios.get(this.stateLink);
            this.states = res.data.data;
            // console.log(res.data);
        } catch (e) {
            $toast.error(e.message);
        }
        await this.updateList();
        // await this.initMap();
        // if (this.states[0].lat != null && this.states[0].lng != null){
        //     this.changeMapCenter(this.states[0].lat,this.states[0].lng)
        // }
    },
    computed: {
        mapStyle() {
            if (this.darkMode) {
                return 'filter: invert(100%) hue-rotate(120deg) brightness(95%) contrast(90%);';
            }
            return '';
        }
    },
    methods: {
        async save() {
            let canSave = true;
            if (this.state_id == null) {
                $toast.error("State is required"); // WIP translate
                canSave = false;
            }
            if (this.city_id == null) {
                $toast.error("City is required"); // WIP translate
                canSave = false;
            }
            if (this.address.length < 10) {
                $toast.error("Address is required"); // WIP translate
                canSave = false;
            }
            if (this.zip.length < 5) {
                $toast.error("Post code is required"); // WIP translate
                canSave = false;
            }
            if (!canSave) {
                return false;
            }

            if (this.action == 'add') {

                let data = {
                    address: this.address,
                    state_id: this.state_id,
                    city_id: this.city_id,
                    zip: this.zip,
                    lat: this.lat,
                    lng: this.lng
                };
                try {
                    let r = await axios.post(this.addLink, data);
                    if (r.data.OK) {
                        this.addresses = r.data.list;
                        $toast.success(r.data.message);
                        this.modal = false;
                    }
                } catch (e) {
                    $toast.error('err!' + e.message);
                }


            } else {
                let data = {
                    address: this.address,
                    state_id: this.state_id,
                    city_id: this.city_id,
                    zip: this.zip,
                    lat: this.lat,
                    lng: this.lng
                };
                try {
                    const url = this.updateLink + '/' + this.id;
                    let r = await axios.post(url, data);
                    if (r.data.OK) {
                        $toast.success(r.data.message);
                        await this.updateList();
                        this.modal = false;
                    }
                } catch (e) {
                    $toast.error('err!' + e.message);
                }
            }
        },
        showModal() {

            this.modal = true;
            setTimeout(() => {
                this.initMap();
            }, 50);
        },
        async removing(id) {
            if (!confirm('Sure?')) { //WIP: translate
                return;
            }

            const url = this.remLink + '/' + id;
            try {
                let r = await axios.get(url);
                if (r.data.OK) {
                    $toast.success(r.data.message);
                    this.updateList();
                }
            } catch (e) {
                $toast.error('err!' + e.message);
            }
        },
        async editing(dt) {
            this.showModal();
            this.action = 'edit';
            this.id = dt.id;
            this.lat = dt.lat;
            this.lng = dt.lng;
            this.zip = dt.zip;
            this.address = dt.address;
            this.state_id = dt.state_id;
            await this.updateState();
            this.city_id = dt.city_id;
            if (this.lng != null && this.lat != null) {
                this.zoom = 16;
                setTimeout(() => {
                    this.changeMapCenter(this.lat, this.lng);
                    this.marker = L.marker({lat: this.lat, lng: this.lng}).addTo(this.map);
                }, 100);
            }

        },
        adding() {
            this.action = 'add';
            this.address = '';
            this.zip = '';
            this.state_id = null;
            this.showModal();

        },
        initMap() {
            if (!import.meta.env.DEV){
                L.Icon.Default.mergeOptions({
                    iconRetinaUrl: "/assets/vendor/leaflet/marker-icon-2x.png",
                    iconUrl: "/assets/vendor/leaflet/marker-icon.png",
                    shadowUrl: "/assets/vendor/leaflet/marker-shadow.png"
                });
            }

            this.map = L.map(this.$refs.mapContainer).setView([35.83266000, 50.99155000], 10);


            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; openstreetmap',
                attributionControl: false,
            }).addTo(this.map);

            this.map.on('click', this.onMapClick);
            this.map.attributionControl.setPrefix('xShop');

        },
        onMapClick(e) {
            if (this.marker) {
                this.map.removeLayer(this.marker);
            }

            this.marker = L.marker(e.latlng).addTo(this.map);
            // You can emit the selected location or perform any other desired action here
            // console.log('Selected location:', e.latlng);
            this.getAddress(e.latlng);
            this.lat = e.latlng.lat;
            this.lng = e.latlng.lng;
        },
        changeMapCenter(lat, lng) {
            try {

                this.map.setView([lat, lng], this.zoom);
            } catch (e) {
                // console.log(e.message);
                setTimeout(() => {
                    console.log('repeat');
                    this.changeMapCenter(lat, lng);
                }, 10);
            }

            // Change the map center to [40.7128, -74.0059] (New York City) with zoom level 12

        },
        async updateList() {
            try {
                let res = await axios.get(this.listLink);
                this.addresses = res.data;
            } catch (e) {
                $toast.error('err!' + e.message);
            }
        },
        async updateState() {
            for (const st of this.states) {
                if (st.id == this.state_id) {
                    // console.log(st);
                    if (st.lat != null && st.lng != null) {
                        this.zoom = 10;
                        this.changeMapCenter(st.lat, st.lng)
                    }
                    break;
                }
            }

            try {
                let res = await axios.get(this.citiesLink + '/' + this.state_id);
                this.cities = res.data.data;
            } catch (e) {
                $toast.error('err!' + e.message);
            }
        },
        async updateCity() {
            for (const c of this.cities) {
                if (c.id == this.city_id) {
                    if (c.lat != null && c.lng != null) {
                        this.zoom = 12;
                        this.changeMapCenter(c.lat, c.lng)
                    }
                    break;
                }
            }
        },
        getAddress(latlng) {
            const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}&addressdetails=1&accept-language=en`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const address = this.formatAddress(data.address);
                    this.address = address;
                })
                .catch(error => {
                    $toast.error('err!' + error.message);
                });

        },
        formatAddress(addressData) {

            let formattedAddress = '';

            if (addressData.road) {
                formattedAddress += addressData.road;
            }
            if (addressData.neighbourhood) {
                formattedAddress += addressData.neighbourhood;
            }
            //
            // if (addressData.house_number) {
            //     formattedAddress += ` ${addressData.house_number}`;
            // }
            //
            if (addressData.postcode) {
                // formattedAddress += `, ${addressData.postcode}`;
                let x = addressData.postcode.split('-');
                this.zip = x.join('');
            }

            if (addressData.city) {
                formattedAddress += `, ${addressData.city}`;
            }
            //
            // if (addressData.country) {
            //     formattedAddress += `, ${addressData.country}`;
            // }

            return formattedAddress;
        },
    }
}
</script>

<style scoped>
#address-input {
    padding: 0 .75rem 1rem;
}

#address-modal {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
    backdrop-filter: blur(4px);
    background: #ffffff33;
    z-index: 9;
    display: flex;
    align-items: center;
    justify-content: center;
}

#address-modal .card {
    max-width: 900px;
    width: 100%;
}


</style>
