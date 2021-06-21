# @turf/area

<!-- Generated by documentation.js. Update this documentation by updating the source code. -->

## area

Takes one or more features and returns their area in square meters.

**Parameters**

-   `geojson` **[GeoJSON][1]** input GeoJSON feature(s)

**Examples**

```javascript
var polygon = turf.polygon([[[125, -15], [113, -22], [154, -27], [144, -15], [125, -15]]]);

var area = turf.area(polygon);

//addToMap
var addToMap = [polygon]
polygon.properties.area = area
```

Returns **[number][2]** area in square meters

[1]: https://tools.ietf.org/html/rfc7946#section-3

[2]: https://developer.mozilla.org/docs/Web/JavaScript/Reference/Global_Objects/Number

<!-- This file is automatically generated. Please don't edit it directly:
if you find an error, edit the source file (likely index.js), and re-run
./scripts/generate-readmes in the turf project. -->

---

This module is part of the [Turfjs project](http://turfjs.org/), an open source
module collection dedicated to geographic algorithms. It is maintained in the
[Turfjs/turf](https://github.com/Turfjs/turf) repository, where you can create
PRs and issues.

### Installation

Install this module individually:

```sh
$ npm install @turf/area
```

Or install the Turf module that includes it as a function:

```sh
$ npm install @turf/turf
```