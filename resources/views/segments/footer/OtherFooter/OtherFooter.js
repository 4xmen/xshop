import L from 'leaflet';

var mapc, markerc;
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
        if (document.querySelectorAll('#mapcContainer').length != 0) {
            const lat = parseFloat(document.querySelector('#mapclat').value);
            const lng = parseFloat(document.querySelector('#mapclng').value);
            const zoom = parseInt(document.querySelector('#mapczoom').value);
            mapc = L.map(document.querySelector('#mapcContainer')).setView([lat, lng], zoom);
            console.log(lat,lng,zoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; openstreetmap',
                attributionControl: false,
            }).addTo(mapc);

            mapc.attributionControl.setPrefix('xShop');

            if (this.markerc) {
                mapc.removeLayer(markerc);
            }

            markerc = L.marker({lat: lat, lng: lng}).addTo(mapc);
        }
    } catch {
    }

});
