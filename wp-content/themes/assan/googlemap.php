<?php
global $ctassan_data;
$zoom = $ctassan_data['map_zoom'] ? $ctassan_data['map_zoom'] : '8';
$map_height = $ctassan_data['map_height'] ? $ctassan_data['map_height'] : '400';
$latitude = $ctassan_data['map_latitude'] ? $ctassan_data['map_latitude'] : '38.8279255';
$longitude = $ctassan_data['map_longitude'] ? $ctassan_data['map_longitude'] : '-104.814836';
$type = $ctassan_data['map_type'] ? $ctassan_data['map_type'] : 'ROADMAP';
$map_popuptext = trim($ctassan_data['map_marker_text']) ? $ctassan_data['map_marker_text'] : 'Crazy-themes CO 80905, USA';
$size = 'style="width: 100%; height: ' . $map_height . 'px;"';
?> 
<div id="googlemapwrap" <?php echo $size; ?>></div>
<script>
    function initialize() {
        var myLatlng = new google.maps.LatLng(<?php echo $latitude ?>, <?php echo $longitude ?>);
        var mapProp = {
            center: myLatlng,
            zoom: <?php echo $zoom ?>,
            scrollwheel: false,
            draggable: false,
            mapTypeId: google.maps.MapTypeId.<?php echo $type ?>
        };
        var map = new google.maps.Map(document.getElementById("googlemapwrap"), mapProp);

        var contentString = '<?php echo $map_popuptext; ?>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: '<?php echo $map_popuptext; ?>'
        });
        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>