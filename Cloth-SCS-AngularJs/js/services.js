
  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 37.7749, lng: -122.4194},
      zoom: 12
    });
  var geocoder = new google.maps.Geocoder();
    var directionsService = new google.maps.DirectionsService();
    var directionsRenderer = new google.maps.DirectionsRenderer();

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var deliveryLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        directionsRenderer.setMap(map);

        var deliveryForm = document.getElementById('delivery-form');
        var deliveryFormButton = document.getElementById('delivery-form-submit');
        deliveryFormButton.addEventListener('click', function(event) {
          event.preventDefault();
          var address = deliveryForm.elements['address'].value;
          var branch = deliveryForm.elements['branch'].value;

          calculateDistance(branch, address);

          geocoder.geocode({'address': address}, function(results, status) {
            if (status === 'OK') {
              var deliveryLocation = results[0].geometry.location;
              var branchLocation = deliveryForm.elements['branch'].value;

              directionsService.route({
                origin: deliveryLocation,
                destination: branchLocation,
                travelMode: 'DRIVING'
              }, function(result, status) {
                if (status === 'OK') {
                  directionsRenderer.setDirections(result);
                }
              });
            } else {
              console.log('Geocode was not successful for the following reason: ' + status);
            }
          });

          var placesService = new google.maps.places.PlacesService(map);
          placesService.getDetails({ 'placeId': branch }, function(place, status) {
            if (status === 'OK') {
              var branchLocation = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());

              directionsService.route({
                origin: deliveryLocation,
                destination: branchLocation,
                travelMode: 'DRIVING'
              }, function(result, status) {
                if (status === 'OK') {
                  directionsRenderer.setDirections(result);
                }
              });
            } else {
              console.log('Place details request failed for the following reason: ' + status);
            }
          });
        });
      }, function() {
        alert('Unable to retrieve your location');
      });
    } else {
      alert('Your browser does not support Geolocation');
    }
  }

  function calculateDistance(branch, address) {
    // create a new DistanceMatrixService object
    var distanceService = new google.maps.DistanceMatrixService();

    // make a request to calculate the distance between the branch and the address
    distanceService.getDistanceMatrix({
        origins: [branch],
        destinations: [address],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
    }, function(response, status) {
        if (status == google.maps.DistanceMatrixStatus.OK) {
            // get the distance value in meters
            var distance = response.rows[0].elements[0].distance.value;

            // display the distance
            var distanceInKm = distance / 1000;

            var distanceNode = document.getElementById('distance');
            var isFirstTry = distanceNode.innerHTML === "";
            distanceNode.innerHTML = "The total distance is: " + distanceInKm + "km";

            var distanceFieldNode = document.getElementById('distance-field');
            distanceFieldNode.value = `${distanceInKm}`;

            // show invoice summary
            var deliveryForm = document.getElementById('delivery-form');
            var datetimeField = deliveryForm.elements['datetime'].value;
            if (datetimeField) {
                document.getElementById('invoice-sum-redir').setAttribute("style", "display: block");
                if (isFirstTry) window.scrollBy(0, 1000);
            }

            //alert("The distance between the branch and the delivery address is " + distanceInKm + " km.");
        } else {
            alert("Unable to calculate distance: " + status);
        }
    });
}