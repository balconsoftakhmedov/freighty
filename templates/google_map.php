<?php
/**
 *
 * @author    balconet.co
 * @package   Tigon
 * @version   1.0.0
 * @since     1.0.0
 */
$flcf7gmap_map_api_key = get_option('flcf7gmap_map_api_key');
?>
<div id="map" style="width: 100%;height: 300px;"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc_attr($flcf7gmap_map_api_key); ?>"&amp;language=ru></script>
<script>
  // Define the from and to addresses
  var fromAddress = '<?php echo $map_addresses['from_address']; ?>';
  var toAddress = '<?php echo $map_addresses['to_address']; ?>';

  // Initialize the map
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 20,
	  language: 'ru'
  });

  // Define the geocoder
  var geocoder = new google.maps.Geocoder();

  // Geocode the from and to addresses
  geocoder.geocode({ address: fromAddress }, function(results, status) {
    if (status === 'OK') {
      var fromLocation = results[0].geometry.location;

      geocoder.geocode({ address: toAddress }, function(results, status) {
        if (status === 'OK') {
          var toLocation = results[0].geometry.location;

          // Draw the route on the map
          var directionsService = new google.maps.DirectionsService();
          var directionsDisplay = new google.maps.DirectionsRenderer({
            map: map
          });
          directionsService.route({
            origin: fromLocation,
            destination: toLocation,
            travelMode: 'DRIVING'
          }, function(response, status) {
            if (status === 'OK') {
              directionsDisplay.setDirections(response);
            } else {
              window.alert('Directions request failed due to ' + status);
            }
          });

          // Center the map on the from and to locations
          var bounds = new google.maps.LatLngBounds();
          bounds.extend(fromLocation);
          bounds.extend(toLocation);
          map.fitBounds(bounds);
        } else {
          window.alert('Geocode was not successful for the following reason: ' + status);
        }
      });
    } else {
      window.alert('Geocode was not successful for the following reason: ' + status);
    }
  });
</script>
