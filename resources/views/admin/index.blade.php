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
    <div class="row">
        <div class="col-md-12">
            <div id="rumahpeta" style="height: 600px"></div>
        </div>
        <div class="col-md-12">
            <label for="staticEmail" class="col-sm-12 col-form-label">Tambahkan Data Pasien</label>
            {{-- <div class="col-sm-10">
				<input required="required" type="text" class="form-control " name="ket" id="ket">
			</div> --}}
        </div>
        <div class="col-md-6">
            <form class="form" method="post" action="#" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input required="required" type="text" class="form-control " name="nama" id="nama">
                    </div>
                </div>
                <div class="form-group">
                    <label for="staticEmail" class="col-sm-4 col-form-label">No KTP</label>
                    <div class="col-sm-10">
                        <input required="required" type="number" class="form-control " name="noKtp" id="noKtp">
                    </div>
                </div>
                <div class="form-group">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input required="required" type="text" class="form-control " name="alamat" id="alamat">
                    </div>
                </div>
                <div class="form-group">
                    <label for="staticEmail" class="col-sm-8 col-form-label">Lokasi Karantina</label>
                    <div class="col-sm-10">
                        <label class="col-sm-4 col-form-label">Provinsi</label>
                        <select class="form-control" name="provinsi" id="provinsi" onchange="KabOpt()">
                            @foreach ($provinsi as $data)
                                <option value="{{ $data->kode_prop }}">{{ $data->nama_prop }}</option>
                            @endforeach
                        </select>
                        <label class="col-sm-4 col-form-label">Kabupaten</label>
                        <select class="form-control" name="kabupaten" id="kabupaten">
                            @foreach ($kabupaten as $data)
                                <option value="{{ $data->kode_kab }}">{{ $data->nama_kab }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="staticEmail" class="col-sm-12 col-form-label">Geom(Gunakan marker di map untuk menandai
                        lokasi rumah)</label>
                    <div class="col-sm-10">
                        <textarea required="required" class="form-control " name="geom" id="geom" readonly></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="staticEmail" class="col-sm-2 col-form-label"> </label>
                    <div class="col-sm-10">
                        <button type="button" onclick="simpan_geom()" class="btn btn-success" id="simpan" name="simpan" style="visibility: visible;">
                            Simpan
                        </button>
						<button type="button" onclick="edit_geom()" class="btn btn-success" style="visibility: hidden;" id="ubah" name="ubah">
                            Edit
                        </button>
						<button type="button" onclick="delete_geom()" class="btn btn-success" style="visibility: hidden;" id="hapus" name="hapus">
                            Delete
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="staticEmail" class="col-sm-8 col-form-label">Keluhan sakit</label>
                <div class="col-sm-10">
                    <input required="required" type="text" class="form-control " name="keluhan" id="keluhan">
                </div>
            </div>
            <div class="form-group">
                <label for="staticEmail" class="col-sm-8 col-form-label">Riwayat Perjalanan</label>
                <div class="col-sm-10">
                    <input required="required" type="text" class="form-control " name="riwayat" id="riwayat">
                </div>
            </div>
            <div class="form-group">
                <label for="staticEmail" class="col-sm-2 col-form-label">Jenis</label>
                <div class="col-sm-10">
                    <select class="form-control" name="jenis" id="jenis">
                        <option value="penderita">Penderita</option>
                        <option value="suspect">Suspect</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="staticEmail" class="col-sm-8 col-form-label">Foto Pasien</label>
                <div class="col-sm-10">
                    <input required="required" type="file" name="foto" id="foto" accept="image/jpg, image/jpeg, image/png"
                        onchange="LoadFile(event)">
                </div>
                <p name="fotoUrl" id="fotoUrl"></p>
            </div>
        </div>
    </div>
    {{-- <div id="rumahpeta" style="background-color: red; height: 550px;">
	ini adalah rumahnya peta
</div> --}}
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
        });

        function KabOpt() {
            var prov = $('#provinsi').val();
            $.post('KabOpt.php', {
                    prov: prov
                },
                function(data) {
                    if (data[0] != "Gagal") {
                        document.getElementById("kabupaten").innerHTML = "";
                        const kabs = JSON.parse(data);
                        for (let index = 0; index < kabs.length; index++) {
                            var kab = kabs[index];
                            var nama = kab['nama_kab'];
                            var kode = kab['kode_kab'];
                            document.getElementById("kabupaten").innerHTML += "<option value='" + kode + "'>" + nama +
                                "</option>";
                        }
                    } else {
                        alert('Gagal memuat kabupaten')
                    }
                });
        }

        function LoadFile(event) {
            const reader = new FileReader();
            reader.addEventListener("load", () => {
                // document.getElementById('fotoUrl').innerText = URL.createObjectURL(event.target.files[0]);
                document.getElementById('fotoUrl').innerText = reader.result;
            });
            reader.readAsDataURL(event.target.files[0]);
        }

        function simpan_geom() {
            var nama = $('#nama').val();
            var noKtp = $('#noKtp').val();
            var alamat = $('#alamat').val();
            var provinsi = $('#provinsi').val();
            var kabupaten = $('#kabupaten').val();
            var geom = $('#geom').val();
            var keluhan = $('#keluhan').val();
            var riwayat = $('#riwayat').val();
            var jenis = $('#jenis').val();
            var foto = document.getElementById('fotoUrl').innerHTML;
            var ext = $('#foto').val().split('.')[1];
            console.log(foto);

            $.post('simpan_geom.php', {
                    nama: nama,
                    noKtp: noKtp,
                    foto: foto,
                    alamat: alamat,
                    provinsi: provinsi,
                    kabupaten: kabupaten,
                    geom: geom,
                    keluhan: keluhan,
                    riwayat: riwayat,
                    jenis: jenis,
                    ext: ext
                },
                function(data) {
                    if (data == 'success') {
                        alert('Data Berhasil Disimpan');
                        location.reload();
                    } else {
                        alert(data);
                    }
                });
        }
		function EditVisible(){
			var ubah = document.getElementById('ubah');
			var hapus = document.getElementById('hapus');
			var simpan = document.getElementById('simpan');
			ubah.style.visibility = "visible";
			ubah.style.display = "block";
			hapus.style.visibility = "hidden";
			simpan.style.display = "none";
		}
		function DeleteVisible(){
			var ubah = document.getElementById('ubah');
			var hapus = document.getElementById('hapus');
			var simpan = document.getElementById('simpan');
			ubah.style.display = "none";
			hapus.style.visibility = "visible";
			simpan.style.display = "none";
		}

		function edit_geom(){

		}
		function delete_geom(){
			
		}
        var iconPenderita = L.icon({
            iconUrl: 'icons/health-medical.png',
            iconSize: [30, 40],
            iconAnchor: [15, 40],
        });
        var iconSuspect = L.icon({
            iconUrl: 'icons/medical.png',
            iconSize: [30, 40],
            iconAnchor: [15, 40],
        });
        var wkt = new Wkt.Wkt();
        <?php
            $sql = 'SELECT * from data_pasien';
            $result = $conn->query($sql);
            while ($r = $result->fetch_assoc()) { ?>
        var geom = "<?php echo $r['geom']; ?>";
        wkt.read(geom);
        if ('<?php echo $r['jenis']; ?>' == "Penderita") {
            var feature_point_<?php echo $r['id']; ?> = wkt.toObject({
                icon: iconPenderita
            });
        } else if ('<?php echo $r['jenis']; ?>' == "Suspect") {
            var feature_point_<?php echo $r['id']; ?> = wkt.toObject({
                icon: iconSuspect
            });
        }
        feature_point_<?php echo $r['id']; ?>.addTo(map);
        feature_point_<?php echo $r['id']; ?>.on('click', function(e) {
            var pop = L.popup();
            pop.setLatLng(e.latlng);
            pop.setContent(
                "Nama = <?php echo $r['nama']; ?> <br> Alamat = <?php echo $r['alamat']; ?> <br>Jenis = <?php echo $r['jenis']; ?> <br>Keluhan = <?php echo $r['keluhan']; ?> <br>Riwayat = <?php echo $r['riwayat_perjalanan']; ?><br>" + "<a href = '#' onclick='EditVisible()'>Edit</a>" + "&nbsp <a href = '#' onclick='DeleteVisible()'>Delete</a>"
            );
            map.openPopup(pop);
        });
        <?php }
            ?>
    </script>
@endsection