@extends('layouts.frontend')

@section('content')
    <?php
    $servername = 'localhost';
    $username = 'root';
    $password = 'mysql';
    $dbname = 'bguas';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    ?>
    BG - Leaflet
    <div id="rumahpeta" style="background-color: red; height: 550px;">
        ini adalah rumahnya peta
    </div>
    <input type="text" id="geom" name="geom" hidden required>
    <label>Pilih point diatas untuk membuat buffer</label><br>
    {{-- <input type="button" class="btn btn-success" onclick="buatBuffer()" value="Buat Area dalam radius 2km"> --}}
    <script type="text/javascript">
        var map = L.map('rumahpeta').setView([-0.789275, 117.921327], 5);
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {});
        var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        osm.addTo(map);

        var baseMap = {
            'OSM': osm,
            'Google Street': googleStreets,
            'Google Satellite': googleSat,
            'Google Hybrid': googleHybrid,
        };
        L.control.layers(baseMap).addTo(map);

        function style_kabupaten(feature) {
            var results = {!! json_encode($results) !!};
            // console.log(feature.properties.KODE_KAB);
            for (let index = 0; index < results.length; index++) {
                if (results[index]['kode_kabupaten'] == feature.properties.KODE_KAB) {
                    var jumlah = results[index]['penderita'] + results[index]['suspect'];
                    if (jumlah >= 30) {
                        return {
                            fillColor: 'black',
                            fillOpacity: 0.5,
                            weight: 1
                        }
                    } else if (jumlah >= 20) {
                        return {
                            fillColor: 'red',
                            fillOpacity: 0.5,
                            weight: 1
                        }
                    } else if (jumlah >= 10) {
                        return {
                            fillColor: 'orange',
                            fillOpacity: 0.5,
                            weight: 1
                        }
                    } else if (jumlah > 0) {
                        return {
                            fillColor: 'yellow',
                            fillOpacity: 0.5,
                            weight: 1
                        }
                    }
                }
            }
            return {
                fillColor: 'green',
                fillOpacity: 0.5,
                weight: 1
            };
        }

        function fungsi_membaca_per_data(feature, layer) {
            if (feature.properties && feature.properties.NAMA_KAB) {
                var results = {!! json_encode($results) !!};
                for (let index = 0; index < results.length; index++) {
                    if (results[index]['kode_kabupaten'] == feature.properties.KODE_KAB) {
                        layer.bindPopup(feature.properties.NAMA_KAB + " <br> Suspect: " + results[index]['suspect'] +
                            "<br> Penderita: " + results[index]['penderita']);
                    }
                }
            }
        }
        var kabupaten = L.geoJson.ajax('{{ asset('geojson/indonesia_kab.geojson') }}', {
            style: style_kabupaten,
            onEachFeature: fungsi_membaca_per_data
        }).addTo(map);
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        map.addControl(new L.Control.Draw({
            edit: {
                featureGroup: drawnItems,
                poly: {
                    allowIntersection: false
                }
            },
            draw: {
                polygon: {
                    allowIntersection: false,
                    showArea: true
                }
            }
        }));
        map.on(L.Draw.Event.CREATED, function(e) {
            drawnItems.eachLayer(function(layer) {
                map.removeLayer(layer);
            });
            var type = e.layerType;
            var layer = e.layer;

            var shape = layer.toGeoJSON();

            var shape_for_db = JSON.stringify(shape);
            var x = JSON.parse(shape_for_db);

            var res = "";
            if (x['geometry']['type'] == "Point") {
                $('#tipe').val('point');
                res = "POINT(";
                res += x['geometry']['coordinates'][0] + " " + x['geometry']['coordinates'][1];
                res += ")";
            }

            document.getElementById("geom").value = res;
            drawnItems.addLayer(layer);
            var bufferLokasi = turf.buffer(shape, 2, {
                units: 'kilometers'
            });
            var i = 0;
            var unionLokasi;
            turf.featureEach(bufferLokasi, function(currentFeature, featureIndex) {
                i++
                if (i == 1) {
                    unionLokasi = currentFeature;
                } else {
                    unionLokasi = turf.union(unionLokasi, currentFeature);
                }
            });
            var layerBufferLokasi = L.geoJson(unionLokasi, {
                style: style_lokasi
            }).addTo(map);
            // buatBuffer(layer);
        });

        function style_lokasi() {
            return {
                fillColor: "blue",
                weight: 0,
                fillOpacity: 0.7
            };
        }

        function buatBuffer(shape) {

            shape.on('data:loaded', function() {
                console.log('masuk shape');
                var bufferLokasi = turf.buffer(shape, 2, {
                    units: 'kilometers'
                });
                var i = 0;
                var unionLokasi;
                turf.featureEach(bufferLokasi, function(currentFeature, featureIndex) {
                    i++
                    if (i == 1) {
                        unionLokasi = currentFeature;
                    } else {
                        unionLokasi = turf.union(unionLokasi, currentFeature);
                    }
                });
                var layerBufferLokasi = L.geoJson(unionLokasi, {
                    style: style_lokasi
                }).addTo(map);
            });
        }
    </script>
@endsection
