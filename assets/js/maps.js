var map;
var inconBase = baseUrl + 'assets/img/';
var camaraMarkers = [];
var zonaPolygons = [];
var zonaLabel = [];
var icons = {
        '0': 'icon-0',
        '1': 'icon-1',
        '2': 'icon-2',
        '3': 'icon-3',
        '4': 'icon-4',
        '5': 'icon-5',
        '6': 'icon-6'
    };

function initMap()
{
    var styleArray = [{
        featureType: "landscape.man_made",
        stylers: [{
            "color": "#dfe6eb"
        }]
    }];

    //getMarkers('30');

    markers = [];
    map = new google.maps.Map(document.getElementById('TdeFMap'), {
        zoom: 14,
        scaleControl: false,
        streetViewControl: false,
        panControl: false,
        mapTypeControl: true,
        mapTypeControlOptions: {
            position: google.maps.ControlPosition.BOTTOM_LEFT
        },
        zoomControl: true,
        styles: styleArray,
        center: centerMap,
        mapTypeId: google.maps.MapTypeId.TERRAIN
    });

    infoWindow = new google.maps.InfoWindow({
        maxWidth: 200,
    });

    infoBubble = new InfoBubble({
        backgroundColor: '#0080B6',
        borderRadius: 2,
        borderWidth: 0,
        arrowSize: 20,
        maxWidth: 300,
        maxHeight: 350,
        padding: 0,
        hideCloseButton: false,
        backgroundClassName: 'panel panel-primary infoBubble',
        arrowStyle: 0,
        ShadowStyle: 0,
        closeSrc: inconBase + 'button_close.png'
    });

    markerReport = new google.maps.Marker({
        id: 'searchMarker',
        draggable: true,
        icon: inconBase + 'icon-star-color.png',
        zIndex: 0
    });

    addPoint($("#lat").val(), $("#lng").val());

    // Define the LatLng coordinates for the polygon.
    var tresDeFebrero = [{
        lat: -34.61555,
        lng: -58.53104
    }, {
        lat: -34.59750,
        lng: -58.52280
    }, {
        lat: -34.59123,
        lng: -58.56254
    }, {
        lat: -34.56949,
        lng: -58.58954
    }, {
        lat: -34.55878,
        lng: -58.60332
    }, {
        lat: -34.55344,
        lng: -58.61034
    }, {
        lat: -34.54742,
        lng: -58.61916
    }, {
        lat: -34.54728,
        lng: -58.62182
    }, {
        lat: -34.54754,
        lng: -58.62409
    }, {
        lat: -34.54960,
        lng: -58.62890
    }, {
        lat: -34.55264,
        lng: -58.63160
    }, {
        lat: -34.55547,
        lng: -58.63772
    }, {
        lat: -34.56190,
        lng: -58.64468
    }, {
        lat: -34.56892,
        lng: -58.63915
    }, {
        lat: -34.57636,
        lng: -58.63035
    }, {
        lat: -34.60791,
        lng: -58.59297
    }, {
        lat: -34.60606,
        lng: -58.58884
    }, {
        lat: -34.62872,
        lng: -58.57232
    }, {
        lat: -34.62595,
        lng: -58.56677
    }, {
        lat: -34.63334,
        lng: -58.55772
    }, {
        lat: -34.63693,
        lng: -58.55328
    }, {
        lat: -34.64059,
        lng: -58.54832
    }, {
        lat: -34.65439,
        lng: -58.52902
    }];

    // Construct the polygon.
    tresDeFebreroPol = new google.maps.Polygon({
        paths: tresDeFebrero,
        strokeColor: '#f4811f',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#003366',
        fillOpacity: 0.1
    });
    tresDeFebreroPol.setMap(map);

    drawCamaras();

    var timerMapLabel = setInterval(function(){ checkMapLabel() }, 500);

    function checkMapLabel()
    {
        if(typeof window.MapLabel !== "undefined")
        {
            runMapLabel();
        }
    }

    function runMapLabel()
    {
        clearInterval(timerMapLabel);

        drawZonas();
    }

    google.maps.event.addListenerOnce(map, 'idle', function()
    {
        google.maps.event.trigger(map, 'resize');
    });

    google.maps.event.addListenerOnce(map, 'tilesloaded', function()
    {
        google.maps.event.trigger(map, 'resize');
    });

    if(!google.maps.Polygon.prototype.getBounds)
    {
        google.maps.Polygon.prototype.getBounds=function()
        {
            var bounds = new google.maps.LatLngBounds()
            this.getPath().forEach(function(element,index){bounds.extend(element)})
            return bounds
        }
    }

    initGeodecoder();

    var lat = document.getElementById('lat').value;
    var lng = document.getElementById('lng').value;

    function initGeodecoder()
    {
        geocoder = new google.maps.Geocoder();

        var directionInput = document.getElementById('direccion');
        var intersectionInput = document.getElementById('interseccion');

        var timeout = null;

        var inputClass = directionInput.className;

        var options = {
            types: ['address'],
            componentRestrictions: {country: 'ar'}
        };

        autocomplete1 = new google.maps.places.Autocomplete(directionInput, options);
        autocomplete1.setBounds(tresDeFebreroPol.getBounds());
        autocomplete1.bindTo('bounds', map);

        google.maps.event.addListener(autocomplete1, 'place_changed', function()
        {
            place = autocomplete1.getPlace();

            if(google.maps.geometry.poly.containsLocation(place.geometry.location, tresDeFebreroPol))
            {
                map.setCenter(place.geometry.location);
                markerReport.setPosition(place.geometry.location);
                map.setZoom(16);
                markerReport.setMap(map);

                var selection = "";
                if (!isNaN(parseFloat(place.address_components[0].long_name)) && isFinite(place.address_components[0].long_name))
                {
                    selection = place.address_components[1].long_name + ' ' + place.address_components[0].long_name;
                }
                else
                {
                    selection = place.address_components[0].long_name;
                }

                $(directionInput).val(selection).focus();
            }
            else
            {
                $(directionInput).val("");
            }
        });

        autocomplete2 = new google.maps.places.Autocomplete(intersectionInput, options);
        autocomplete2.setBounds(tresDeFebreroPol.getBounds());
        autocomplete2.bindTo('bounds', map);

        google.maps.event.addListener(autocomplete2, 'place_changed', function()
        {
            place = autocomplete2.getPlace();

            if(google.maps.geometry.poly.containsLocation(place.geometry.location, tresDeFebreroPol))
            {
                map.setCenter(place.geometry.location);
                markerReport.setPosition(place.geometry.location);
                map.setZoom(16);
                markerReport.setMap(map);

                console.log(place.address_components);

                $(intersectionInput).val(place.address_components[0].long_name).focus();
            }
            else
            {
                $(intersectionInput).val("");
            }
        });

        //Instant search width delay
        directionInput.onkeyup = function(e)
        {
            //$(intersectionInput).val("");

            if ($(directionInput).val() == "") return;

            directionInput.className = inputClass + " searching";

            clearTimeout(timeout);

            timeout = setTimeout(function()
            {
                geocodeAddress(geocoder, markerReport, 'direccion');
                directionInput.className = inputClass;
            }, 1000);
        };

        intersectionInput.onkeyup = function(e)
        {
            //$(directionInput).val("");

            if ($(intersectionInput).val() == "") return;

            intersectionInput.className = inputClass + " searching";

            clearTimeout(timeout);

            timeout = setTimeout(function()
            {
                geocodeAddress(geocoder, markerReport, 'interseccion');
                intersectionInput.className = inputClass;
            }, 1000);
        };

        google.maps.event.addListener(markerReport, 'click', function(event)
        {
            document.getElementById("lat").value = this.getPosition().lat();
            document.getElementById("lng").value = this.getPosition().lng();

            var latlng = {
                lat: parseFloat(this.getPosition().lat()),
                lng: parseFloat(this.getPosition().lng())
            };

            geocodeLatLng(geocoder, latLng);
        });

        google.maps.event.addListener(markerReport, 'dragend', function(event)
        {
            var latlngPos = {
                lat: parseFloat(this.getPosition().lat()),
                lng: parseFloat(this.getPosition().lng())
            };

            if(google.maps.geometry.poly.containsLocation(event.latLng, tresDeFebreroPol))
            {
                document.getElementById("lat").value = this.getPosition().lat();
                document.getElementById("lng").value = this.getPosition().lng();
                geocodeLatLng(geocoder, latlngPos);
            }
            else
            {
                markerReport.setMap(null);
                document.getElementById('direccion').value = '';
                document.getElementById("lat").value = 0;
                document.getElementById("lng").value = 0;
            }
        });

        function geocodeAddress(geocoder, markerReport, input)
        {
            if(document.getElementById('direccion').value == '' && document.getElementById('interseccion').value == '' && markerReport != null)
            {
                markerReport.setMap(null);
                map.setZoom(14);
                map.setCenter(centerMap);
                document.getElementById('lat').value = '';
                document.getElementById('lng').value = '';
            }
            else
            {
                var address = document.getElementById(input).value + ', Tres de Febrero, Buenos Aires, Argentina';

                geocoder.geocode({
                    'address': address
                },
                function(results, status)
                {
                    //console.log(status);
                    //console.log(results);
                    if(status === google.maps.GeocoderStatus.OK && google.maps.geometry.poly.containsLocation(results[0].geometry.location, tresDeFebreroPol))
                    {
                        map.setCenter(results[0].geometry.location);

                        var fields = results[0].address_components;
                        var street_number, route, locality;

                        for(var index in fields)
                        {
                            if(fields[index].types.indexOf('street_number') > -1 )
                            {
                                street_number = fields[index].long_name;
                            };

                            if(fields[index].types.indexOf('route') > -1 )
                            {
                                route = fields[index].long_name;
                            };

                            if(fields[index].types.indexOf('locality') > -1 )
                            {
                                locality = fields[index].long_name;
                            };
                        }

                        if(street_number == undefined && input == 'direccion') return;

                        //console.log(street_number);
                        document.getElementById('lat').value = results[0].geometry.location.lat()
                        document.getElementById('lng').value = results[0].geometry.location.lng()

                        if(markerReport != null)
                        {
                            markerReport.setMap(null);
                        }

                        markerReport.setPosition(results[0].geometry.location);
                        map.setZoom(16);
                        markerReport.setMap(map);
                    }
                });
            }
        }

        if($('#form-carga').is(':visible'))
        {
            clicMapAvailable();
        }

        $('#btn-cargar').click(function(e)
        {
            history.pushState('', '', '/reportes/cargar');

            e.preventDefault();

            $('#form-portada').hide(500);
            $('#form-carga').show(500, function()
            {
                $('#TdeFMap').addClass('form-active');
            });

            $('.widged-right').hide();
            markerReport.setVisible(true)
            clicMapAvailable();
            google.maps.event.trigger(map, 'resize');
        });

        $('#title, #volverReporte').click(function(e)
        {
            history.pushState('', '', '/');

            e.preventDefault();

            $('#TdeFMap').removeClass('form-active');
            $('#form-portada').show(500);
            $('#form-carga').hide(500)

            $('.widged-right').show();
            markerReport.setVisible(false);
            clicMapDisavailable();
            google.maps.event.trigger(map, 'resize');
        });
    }

    function getMarkers(days)
    {
        var ajax_url = baseUrl + "listar/" + days;

        var ajax_request = new XMLHttpRequest();

        ajax_request.onreadystatechange = function()
        {
            if (ajax_request.readyState == 4)
            {
                var Markers = JSON.parse(ajax_request.responseText);

                for (var i = Markers.length - 1; i >= 0; i--)
                {
                    DrawMarkers(Markers[i], i);
                }
            }
        }

        ajax_request.open("GET", ajax_url, true);

        ajax_request.send();
    }

    function DrawMarkers(info, position) {
        var markerLatLng = {
            lat: parseFloat(info.lat),
            lng: parseFloat(info.lng)
        };

        var estadosPanel = ['panel panel-default infoBubble',
            'panel panel-primary infoBubble',
            'panel panel-warning infoBubble',
            'panel panel-success infoBubble'
        ]

        var markerHtml = '<div class="panel-heading">' +
            '<h3 class="panel-title">' + info.titulo + '</h3>' +
            '</div>' +
            '<div class="panel-body text-center">';
        if (info.imagen != null && info.imagen != '') {
            var img = info.imagen.split(".");
            markerHtml += '<img class="img-responsive" src="' + baseUrl + "assets/subidas/thumbs/" + img[0] + '_thumb.' + img[1] + '"><hr>';
        }

        markerHtml += '<p class="text-left">' + info.texto + "</p>" +
            '</div>' +
            '<div class="panel-footer"> ' +
            "<p><b>Direcci&oacute;n: </b>" + info.direccion + "</p>"; +
        '</div>';


        var custom_icon = inconBase + icons[info.categoria];
        switch (info.estado) {
            case '2':
                icon += '_proceso';
                break;
            case '3':
                icon += '_resuelto';
                break;
        }

        markers[position] = new google.maps.Marker({
            position: markerLatLng,
            title: info.titulo,
            category: info.categoria,
            status: info.estado,
            //icon: custom_icon + '.png'
        });



        google.maps.event.addListener(markers[position], 'click', function() {

            // infoBubble.setBackgroundClassName( estadosPanel[ parseInt(info.estado)]);
            infoBubble.setContent(markerHtml);
            infoBubble.open(map, markers[position]);
            //infoWindow.open(map, markers[position]);
        });



        markers[position].setMap(map);

    };


//    var categories = document.getElementById('caregorias');



//    categories.onchange = function() {
//
//        var idCategory = this.value;
//        var iconUrl = inconBase + icons['0'] + '-big.png';
//        if (idCategory != null && idCategory != undefined) {
//            iconUrl = inconBase + icons[idCategory] + '-big.png';
//        }
//
//        markerReport.setAnimation(google.maps.Animation.BOUNCE)
//
//        markerReport.setIcon(iconUrl);
//        setTimeout(function() {
//            markerReport.setAnimation(null);
//        }, 1000);
//    }


    function drawCamaras()
    {
        for(var i in mapa_camaras)
        {
            var camaraLatlng = new google.maps.LatLng(parseFloat(mapa_camaras[i].lat), parseFloat(mapa_camaras[i].lng));

            camaraMarkers[i] = new google.maps.Marker({
                position: camaraLatlng,
                icon: inconBase + 'icon-camera.png',
            });

            var camaraHtml = '';
            camaraHtml += '<div class="panel-heading">';
            camaraHtml += '<h3 class="panel-title">Tipo: ' + mapa_camaras[i].tipo + '</h3>';
            camaraHtml += '</div>';
            camaraHtml += '<div class="panel-body text-center">';
            camaraHtml += '<p class="text-left">Ubicación: ' + mapa_camaras[i].ubicacion + "</p>";
            camaraHtml += '</div>';
            camaraHtml += '<div class="panel-footer">';
            camaraHtml += '</div>';

            google.maps.event.addListener(camaraMarkers[i], 'click', function(contenido)
            {
                return function()
                {
                    infoBubble.setContent(contenido);
                    infoBubble.open(map,this);
                }
            }(camaraHtml));
        }
    }

    function drawZonas()
    {
        for(var i in mapa_zonas)
        {
            var bounds = new google.maps.LatLngBounds();
            var polygon_coords = [];

            for(var p in mapa_zonas[i].poligono)
            {
                polygon_coords.push(new google.maps.LatLng(parseFloat(mapa_zonas[i].poligono[p].lat), parseFloat(mapa_zonas[i].poligono[p].lng)))
            }

            zonaPolygons[i] = new google.maps.Polygon({
                paths: polygon_coords,
                strokeColor: '#8080FF',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#AACAF0',
                fillOpacity: 0.35
            });

            google.maps.event.addListener(zonaPolygons[i], 'click', function(event)
            {
                infoBubble.close();
                markerReport.setPosition(event.latLng);
                markerReport.setMap(map);
                geocodeLatLng(geocoder, event.latLng);
                document.getElementById("lat").value = markerReport.getPosition().lat();
                document.getElementById("lng").value = markerReport.getPosition().lng();
            });

            for (j = 0; j < polygon_coords.length; j++)
            {
                bounds.extend(polygon_coords[j]);
            }

            zonaLabel[i] = new MapLabel({
                text: mapa_zonas[i].nombre,
                position: bounds.getCenter(),
                fontSize: 15,
                align: 'center'
            });
        }
    }
}

function clicMapAvailable()
{
    google.maps.event.addListener(tresDeFebreroPol, 'click', function(event)
    {
        infoBubble.close();
        markerReport.setPosition(event.latLng);
        markerReport.setMap(map);
        geocodeLatLng(geocoder, event.latLng);
        document.getElementById("lat").value = markerReport.getPosition().lat();
        document.getElementById("lng").value = markerReport.getPosition().lng();
    });
}

function clicMapDisavailable()
{
    google.maps.event.clearListeners(tresDeFebreroPol, 'click');
}

function geocodeLatLng(geocoder, latlng)
{
    geocoder.geocode({
        'location': latlng
    },
    function(results, status)
    {
        if(status === google.maps.GeocoderStatus.OK)
        {
            if(results[0])
            {
                var fields = results[0].address_components;
                var street_number, route, locality;

                for(var index in  fields)
                {
                    if(fields[index].types.indexOf('street_number') > -1)
                    {
                        street_number = fields[index].long_name;
                    };

                    if(fields[index].types.indexOf('route') > -1)
                    {
                        route = fields[index].long_name;
                    };

                    if(fields[index].types.indexOf('locality') > -1)
                    {
                        locality = fields[index].long_name;
                    };
                }

                if(street_number != undefined)
                {
                    document.getElementById('altura').value = street_number;
                    document.getElementById('calle').value = route;
                    document.getElementById('localidad').value = locality;
                    document.getElementById('direccion').value = results[0].formatted_address;
                }
            }
        }
    });
}

/*
//set style options for marker clusters (these are the default styles)
clusterStyles = [
    {
        height: 53,
        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m1.png",
        width: 53,
        textColor: 'transparent',
        textSize: 0
    }, {
        height: 56,
        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m2.png",
        width: 56,
        textColor: 'transparent',
        textSize: 0
    }, {
        height: 66,
        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m3.png",
        width: 66,
        textColor: 'transparent',
        textSize: 0
    }, {
        height: 78,
        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m4.png",
        width: 78,
        textColor: 'transparent',
        textSize: 0
    }, {
        height: 90,
        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m5.png",
        width: 90,
        textColor: 'transparent',
        textSize: 0
    }
]

var mcOptions = {
    styles: clusterStyles,
    maxZoom: 15
};

//init clusterer with your options
var mc = new MarkerClusterer(map, markers, mcOptions);

*/


function addPoint(lat, lng)
{
    if(lat == "" && lng == "") return;

    var marker_object = new google.maps.Marker({
        position: {
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        },
        icon: inconBase + 'icon-star-color.png'
    });

    marker_object.setMap(map);
};


function setCamaraOnMap(map)
{
    for(var i = 0; i < camaraMarkers.length; i++)
    {
        camaraMarkers[i].setMap(map);
    }
}

function setZonaOnMap(map)
{
    for(var i = 0; i < zonaPolygons.length; i++)
    {
        zonaPolygons[i].setMap(map);
        zonaLabel[i].setMap(map);
    }
}

$(document).ready(function()
{
    $("#toggle_map_element button").click(function()
    {
        $(this).toggleClass("active");

        var type = $(this).data("type");

        var set_map = null;

        switch(type)
        {
            case "camara":
                set_map = ($(this).hasClass("active")) ? map : null;
                setCamaraOnMap(set_map);
                break;
            case "zona":
                set_map = ($(this).hasClass("active")) ? map : null;
                setZonaOnMap(set_map);
                break;
        }
    });
});
