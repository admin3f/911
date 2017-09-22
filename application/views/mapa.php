    <script>


var map;
var infoWindow;
  var styleArray = [
    {
      featureType: "landscape.man_made",
      stylers: [
        { "color": "#eeebcd"}
      ]
    }
  ];  

function initMap() {
  map = new google.maps.Map(document.getElementById('TdeFMap'), {
    zoom: 14,
    disableDefaultUI: true,
    scrollwheel: false,
    zoomControl: true,
    mapTypeControl: false,
    scaleControl: false,
    streetViewControl: false,
    rotateControl: true,
    styles: styleArray,
    center: {lat: -34.5926653, lng: -58.5808747},
    mapTypeId: google.maps.MapTypeId.TERRAIN
  });

  // Define the LatLng coordinates for the polygon.
var tresDeFebrero = [
    {lat: -34.61555, lng: -58.53104},
    {lat: -34.59750, lng: -58.52280},
    {lat: -34.59123, lng: -58.56254},
    {lat: -34.56949, lng: -58.58954},
    {lat: -34.55878, lng: -58.60332},
    {lat: -34.55344, lng: -58.61034},
    {lat: -34.54742, lng: -58.61916},
    {lat: -34.54728, lng: -58.62182},
    {lat: -34.54754, lng: -58.62409},
    {lat: -34.54960, lng: -58.62890},
    {lat: -34.55264, lng: -58.63160},
    {lat: -34.55547, lng: -58.63772},
    {lat: -34.56190, lng: -58.64468},
    {lat: -34.56892, lng: -58.63915},
    {lat: -34.57636, lng: -58.63035},
    {lat: -34.60791, lng: -58.59297},
    {lat: -34.60606, lng: -58.58884},
    {lat: -34.62872, lng: -58.57232},
    {lat: -34.62595, lng: -58.56677},
    {lat: -34.63334, lng: -58.55772},
    {lat: -34.63693, lng: -58.55328},
    {lat: -34.64059, lng: -58.54832},
    {lat: -34.65439, lng: -58.52902}
  ];


  // Construct the polygon.
  var tresDeFebreroPol = new google.maps.Polygon({
    paths: tresDeFebrero,
    strokeColor: '#ffe279',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#000',
    fillOpacity: 0.1
  });
  tresDeFebreroPol.setMap(map);


}


    </script>
    <script>
      $("#enviarReporte").click(function(event) {
         event.preventDefault();

         var error = false;

         if(!error){
          $.ajax({
            method: "POST",
            url: "reportes/guardar",
            data: $("form").serialize(),
          })
          .done(function( msg ) {
            alert( msg );
          });



         }
      });

    </script>

