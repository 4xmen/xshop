import L from 'leaflet';

var map, marker;
window.addEventListener('load', function () {
    try {

        // delete L.icon.default.prototype._getIconUrl ;
        if (!import.meta.env.DEV) {
            L.Icon.Default.mergeOptions({
                iconRetinaUrl: "/assets/vendor/leaflet/marker-icon-2x.png",
                iconUrl: "/assets/vendor/leaflet/marker-icon.png",
                shadowUrl: "/assets/vendor/leaflet/marker-shadow.png"
            });
        }
        if (document.querySelectorAll('#mapContainer').length != 0) {
            const lat = parseFloat(document.querySelector('#maplat').value);
            const lng = parseFloat(document.querySelector('#maplng').value);
            const zoom = parseInt(document.querySelector('#mapzoom').value);
            map = L.map(document.querySelector('#mapContainer')).setView([lat, lng], zoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; openstreetmap',
                attributionControl: false,
            }).addTo(map);

            map.attributionControl.setPrefix('xShop');

            if (this.marker) {
                map.removeLayer(marker);
            }

            marker = L.marker({lat: lat, lng: lng}).addTo(map);
        }
    } catch {
    }

});
