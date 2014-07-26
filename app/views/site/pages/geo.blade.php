@extends('site.layouts.default')

{{-- Content --}}
@section('content')
<div style='height:30px'></div>
<div class="col-xs-12 col-sm-offset-3 col-sm-6" style='height: 500px;' id="map_canvas"></div>
<div class="col-xs-12 col-sm-offset-3 col-sm-6">
	<a href="" class="btn btn-block btn-primary btn-lg">搜尋店家</a>
</div>
@stop

@section('scripts')
<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&dummy=.js'></script>
<script>
	var map;
    var polygon;
    var bounds = new google.maps.LatLngBounds();
    var i;
    var myLatLng = new google.maps.LatLng(25.058843, 121.563292);
    var myOptions = {
        zoom: 13,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.TERRAIN
    };
    map = new google.maps.Map(document.getElementById("map_canvas"),
    myOptions);

    var polygonCoords = [
    new google.maps.LatLng(25.082089, 121.566468),
    new google.maps.LatLng(25.058843, 121.563292),
    new google.maps.LatLng(25.041270, 121.564923)
    ];

    polygon = new google.maps.Polygon({
        paths: polygonCoords,
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 3,
        fillColor: "#FF0000",
        fillOpacity: 0.05
    });
    polygon.setMap(map);

    for (i = 0; i < polygonCoords.length; i++) {
        bounds.extend(polygonCoords[i]);
    }

    // The Center of the polygon
    var latlng = bounds.getCenter();


    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: latlng.toString()
    });
   
</script>
@stop