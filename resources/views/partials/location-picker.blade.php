{{-- Reusable interactive map pin picker (Leaflet + OpenStreetMap, free / no API key).
Usage:
    @include('partials.location-picker', [
        'prefix'     => 'reg',                      // unique per page usage
        'initialLat' => $pro->latitude ?? null,
        'initialLng' => $pro->longitude ?? null,
        'height'     => '260px',                    // optional
    ])
Behavior: click map or drag pin to choose location, "Use My Current Location" button,
auto-fills the sibling input[name="location"] via reverse geocoding (Nominatim),
and writes hidden latitude/longitude inputs into the surrounding form.
Exposes window.lp_{prefix}_refresh() to fix rendering after the container is shown.
--}}
@once
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endonce

<div id="lp-{{ $prefix }}" class="location-picker" style="margin-top:8px;">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:8px;flex-wrap:wrap;">
        <span style="font-size:0.78rem;color:#6b7280;">Click the map or drag the pin to set your exact location</span>
        <button type="button" onclick="lp_{{ $prefix }}_locate()"
                style="background:#16302A;color:#fff;border:none;padding:7px 14px;border-radius:8px;font-size:0.75rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Use My Current Location
        </button>
    </div>
    <div id="lp-map-{{ $prefix }}" style="height:{{ $height ?? '260px' }};width:100%;border-radius:12px;border:1px solid #e5e7eb;z-index:0;"></div>
    <p id="lp-status-{{ $prefix }}" style="font-size:0.72rem;color:#9ca3af;margin-top:6px;">No pin dropped yet.</p>
    <input type="hidden" name="latitude"  id="lp-lat-{{ $prefix }}" value="{{ $initialLat ?? '' }}">
    <input type="hidden" name="longitude" id="lp-lng-{{ $prefix }}" value="{{ $initialLng ?? '' }}">
</div>

<script>
(function () {
    var prefix   = @json($prefix);
    var elId     = 'lp-map-' + prefix;

    // Fallback view: Gilgit, Pakistan (the app's primary market)
    var FALLBACK = [35.9208, 74.3144];

    var initialLat = document.getElementById('lp-lat-' + prefix).value;
    var initialLng = document.getElementById('lp-lng-' + prefix).value;

    L.Icon.Default.mergeOptions({
        iconUrl:       'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
        shadowUrl:     'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
    });

    var start = (initialLat !== '' && initialLng !== '')
        ? [parseFloat(initialLat), parseFloat(initialLng)]
        : FALLBACK;

    var map = L.map(elId, { scrollWheelZoom: true }).setView(start, initialLat !== '' ? 15 : 12);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    var marker = null;

    function statusEl()      { return document.getElementById('lp-status-' + prefix); }
    function latEl()         { return document.getElementById('lp-lat-' + prefix); }
    function lngEl()         { return document.getElementById('lp-lng-' + prefix); }

    function linkedLocationInput() {
        var host = document.getElementById('lp-' + prefix);
        var form = host ? host.closest('form') : null;
        return form ? form.querySelector('input[name="location"]') : null;
    }

    function reverseGeocode(lat, lng) {
        var input = linkedLocationInput();
        if (!input) return;
        fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lng)
            .then(function (r) { return r.json(); })
            .then(function (d) {
                if (!d || d.error) return;
                var a = d.address || {};
                var area = a.suburb || a.neighbourhood || a.quarter || a.hamlet || a.village;
                var city = a.city || a.town || a.municipality || a.county;
                var parts = [];
                if (area) parts.push(area);
                if (city && city !== area) parts.push(city);
                if (!parts.length && d.display_name) {
                    var segs = String(d.display_name).split(',');
                    parts = segs.slice(0, Math.min(2, segs.length));
                }
                var label = parts.join(', ').trim();
                if (label) input.value = label;
            })
            .catch(function () {});
    }

    function setPin(lat, lng, opts) {
        opts = opts || {};
        lat = parseFloat(lat); lng = parseFloat(lng);
        if (isNaN(lat) || isNaN(lng)) return;

        latEl().value = lat.toFixed(7);
        lngEl().value = lng.toFixed(7);

        if (!marker) {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function () {
                var p = marker.getLatLng();
                setPin(p.lat, p.lng, { skipPan: true });
            });
        } else {
            marker.setLatLng([lat, lng]);
        }

        if (!opts.skipPan) map.panTo([lat, lng]);

        statusEl().textContent = '\u2705 Pinned at ' + lat.toFixed(5) + ', ' + lng.toFixed(5);
        statusEl().style.color = '#15803d';

        if (!opts.skipGeocode) reverseGeocode(lat, lng);
    }

    map.on('click', function (e) { setPin(e.latlng.lat, e.latlng.lng); });

    window['lp_' + prefix + '_locate'] = function () {
        if (!navigator.geolocation) {
            statusEl().textContent = 'Geolocation is not supported by this browser.';
            statusEl().style.color = '#b91c1c';
            return;
        }
        statusEl().textContent = 'Locating\u2026';
        navigator.geolocation.getCurrentPosition(
            function (pos) {
                map.setView([pos.coords.latitude, pos.coords.longitude], 16);
                setPin(pos.coords.latitude, pos.coords.longitude);
            },
            function () {
                statusEl().textContent = 'Could not get your location \u2014 click the map instead.';
                statusEl().style.color = '#b91c1c';
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    };

    window['lp_' + prefix + '_refresh'] = function () {
        setTimeout(function () { map.invalidateSize(); }, 150);
    };

    if (initialLat !== '' && initialLng !== '') setPin(initialLat, initialLng, { skipPan: true, skipGeocode: true });
})();
</script>
