import L from 'leaflet';

var map,marker ;
window.addEventListener('load',function () {

    const lat = parseFloat(document.querySelector('#maplat').value);
    const lng = parseFloat(document.querySelector('#maplng').value);
    const zoom = parseInt(document.querySelector('#mapzoom').value);
    map = L.map(document.querySelector('#mapContainer')).setView([lat,lng], zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; openstreetmap',
        attributionControl: false,
    }).addTo(map);

    map.attributionControl.setPrefix('xShop');

    if (this.marker) {
        map.removeLayer(marker);
    }

    marker = L.marker({lat: lat, lng: lng}).addTo(map);
});
