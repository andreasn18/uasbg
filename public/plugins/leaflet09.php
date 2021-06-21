<!DOCTYPE html>
<html>

<head>
	<title>Leaflet 09</title>
	<link rel="stylesheet" href="assets_leaflet/leaflet.css" type="text/css">
	<script src="assets_leaflet/leaflet.js" type="text/javascript"></script>
	<script type="text/javascript" src="plugins/wicket/wicket.js"></script>
	<script type="text/javascript" src="plugins/wicket/wicket-leaflet.js"></script>
</head>

<body>
	BG - Leaflet
	<div id="rumahpeta" style="background-color: red; height: 550px;">
		ini adalah rumahnya peta
	</div>
	<script type="text/javascript">
		var map = L.map('rumahpeta').setView([-7.320402, 112.767327], 17);
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
		var point = 'POINT (112.752087 -7.25745)';
		var wkt = new Wkt.Wkt();
		wkt.read(point);
		var feature = wkt.toObject();
		feature.addTo(map);


		var baseMap = {
			'OSM': osm,
			'Google Street': googleStreets,
			'Google Satellite': googleSat,
			'Google Hybrid': googleHybrid,
		};
		L.control.layers(baseMap).addTo(map);
	</script>
</body>

</html>