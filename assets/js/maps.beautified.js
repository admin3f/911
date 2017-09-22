function initMap() {
    var inconBase = baseUrl + "/assets/img/";
    var icons = {
        "0": "icon-0",
        "1": "icon-1",
        "2": "icon-2",
        "3": "icon-3",
        "4": "icon-4",
        "5": "icon-5",
        "6": "icon-6"
    };
    var styleArray = [ {
        featureType: "landscape.man_made",
        stylers: [ {
            color: "#dfe6eb"
        } ]
    } ];
    getMarkers("30");
    markers = [];
    map = new google.maps.Map(document.getElementById("TdeFMap"), {
        zoom: 14,
        scrollwheel: false,
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
        maxWidth: 200
    });
    infoBubble = new InfoBubble({
        backgroundColor: "#0080B6",
        borderRadius: 2,
        borderWidth: 0,
        arrowSize: 20,
        maxWidth: 300,
        maxHeight: 350,
        padding: 0,
        hideCloseButton: false,
        backgroundClassName: "panel panel-primary infoBubble",
        arrowStyle: 0,
        ShadowStyle: 0,
        closeSrc: inconBase + "button_close.png"
    });
    markerReport = new google.maps.Marker({
        id: "searchMarker",
        draggable: true,
        icon: inconBase + icons["0"] + "-big.png"
    });
    // Define the LatLng coordinates for the polygon.
    var tresDeFebrero = [ {
        lat: -34.61555,
        lng: -58.53104
    }, {
        lat: -34.5975,
        lng: -58.5228
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
        lat: -34.5496,
        lng: -58.6289
    }, {
        lat: -34.55264,
        lng: -58.6316
    }, {
        lat: -34.55547,
        lng: -58.63772
    }, {
        lat: -34.5619,
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
    } ];
    // Construct the polygon.
    tresDeFebreroPol = new google.maps.Polygon({
        paths: tresDeFebrero,
        strokeColor: "#f4811f",
        strokeOpacity: .8,
        strokeWeight: 2,
        fillColor: "#003366",
        fillOpacity: .1
    });
    tresDeFebreroPol.setMap(map);
    initGeodecoder();
    google.maps.event.addListenerOnce(map, "idle", function() {
        google.maps.event.trigger(map, "resize");
    });
    var lat = document.getElementById("lat").value;
    var lng = document.getElementById("lng").value;
    var idCat = document.getElementById("caregoriasReporte").value;
    if (lat != "" && lng != "") {
        var thePos = {
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        };
        markerReport.setPosition(thePos);
        markerReport.setMap(map);
        map.setCenter(thePos);
        if (idCat != "") {
            window.setTimeout(function() {
                markerReport.setAnimation(google.maps.Animation.DROP), 200;
            });
            iconUrl = inconBase + icons[idCat] + "-big.png";
            markerReport.setIcon(iconUrl);
        }
    }
    var categories = document.querySelectorAll(".btn-categoria");
    for (var i = 0, length = categories.length; i < length; i++) {
        categories[i].onclick = function() {
            var idCategory = this.id.split("-")[1];
            if (idCategory != null && idCategory != undefined) {
                for (var i = markers.length - 1; i >= 0; i--) {
                    if (markers[i].category == idCategory && !((" " + this.className + " ").replace(/[\n\t]/g, " ").indexOf("active") > -1)) {
                        markers[i].setVisible(true);
                    } else if (markers[i].category == idCategory) {
                        markers[i].setVisible(false);
                    }
                }
            }
            if (!((" " + this.className + " ").replace(/[\n\t]/g, " ").indexOf("active") > -1)) {
                this.className = this.className + " active";
            } else {
                this.className = this.className.replace(/\bactive\b/, "");
            }
        };
    }
    var periodo = document.getElementById("periodo").getElementsByTagName("li");
    for (var i = 0, length = periodo.length; i < length; i++) {
        periodo[i].onclick = function(e) {
            e.preventDefault();
            var numDias = this.id.split("-")[1];
            this.className = "";
            if (numDias != null && numDias != undefined) {
                for (var i = markers.length - 1; i >= 0; i--) {
                    markers[i].setMap(null);
                }
                for (var j = 0, length = periodo.length; j < length; j++) {
                    periodo[j].className = "";
                }
                this.className = "active";
                getMarkers(numDias);
                var categories = document.querySelectorAll(".btn-categoria");
                for (var i = 0, length = categories.length; i < length; i++) {
                    categories[i].className = categories[i].className + " active";
                }
                var estados = document.getElementById("status").getElementsByTagName("li");
                for (var i = 0, length = estados.length; i < length; i++) {
                    estados[i].className = "";
                }
            }
        };
    }
    var estados = document.getElementById("status").getElementsByTagName("li");
    for (var i = 0, length = estados.length; i < length; i++) {
        estados[i].onclick = function(e) {
            e.preventDefault();
            var idEstado = this.id.split("-")[1];
            if (idEstado != null && idEstado != undefined && !((" " + this.className + " ").replace(/[\n\t]/g, " ").indexOf("active") > -1)) {
                for (var i = markers.length - 1; i >= 0; i--) {
                    if (markers[i].status == idEstado) {
                        markers[i].setMap(map);
                    } else {
                        markers[i].setMap(null);
                    }
                }
                for (var j = 0, length = estados.length; j < length; j++) {
                    estados[j].className = "";
                }
                this.className = "active";
            } else {
                for (var i = markers.length - 1; i >= 0; i--) {
                    markers[i].setMap(map);
                }
                for (var j = 0, length = estados.length; j < length; j++) {
                    estados[j].className = "";
                }
            }
        };
    }
    function initGeodecoder() {
        geocoder = new google.maps.Geocoder();
        var directionInput = document.getElementById("direccionReporte");
        var timeout = null;
        var inputClass = directionInput.className;
        //Instant search width delay
        directionInput.onkeyup = function(e) {
            directionInput.className = inputClass + " searching";
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                geocodeAddress(geocoder, markerReport);
                directionInput.className = inputClass;
            }, 1e3);
        };
        google.maps.event.addListener(markerReport, "click", function(event) {
            document.getElementById("lat").value = this.getPosition().lat();
            document.getElementById("lng").value = this.getPosition().lng();
            var latlng = {
                lat: parseFloat(this.getPosition().lat()),
                lng: parseFloat(this.getPosition().lng())
            };
            geocodeLatLng(geocoder, latLng);
        });
        google.maps.event.addListener(markerReport, "dragend", function(event) {
            var latlngPos = {
                lat: parseFloat(this.getPosition().lat()),
                lng: parseFloat(this.getPosition().lng())
            };
            if (google.maps.geometry.poly.containsLocation(event.latLng, tresDeFebreroPol)) {
                document.getElementById("lat").value = this.getPosition().lat();
                document.getElementById("lng").value = this.getPosition().lng();
                geocodeLatLng(geocoder, latlngPos);
            } else {
                markerReport.setMap(null);
                document.getElementById("direccionReporte").value = "";
                document.getElementById("lat").value = 0;
                document.getElementById("lng").value = 0;
            }
        });
        var bottonSearch = document.getElementById("verDirecion");
        bottonSearch.onclick = function() {
            geocodeAddress(geocoder, markerReport);
        };
        function geocodeAddress(geocoder, markerReport) {
            if (document.getElementById("direccionReporte").value == "" && markerReport != null) {
                markerReport.setMap(null);
                map.setZoom(14);
                map.setCenter(centerMap);
                document.getElementById("lat").value = "";
                document.getElementById("lng").value = "";
            } else {
                var address = document.getElementById("direccionReporte").value + " ,Tres de Febrero, Buenos Aires, Argentina";
                geocoder.geocode({
                    address: address
                }, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK && google.maps.geometry.poly.containsLocation(results[0].geometry.location, tresDeFebreroPol)) {
                        map.setCenter(results[0].geometry.location);
                        document.getElementById("lat").value = results[0].geometry.location.lat();
                        document.getElementById("lng").value = results[0].geometry.location.lng();
                        document.getElementById("localidadReporte").value = results[0].address_components[2].long_name;
                        var fields = results[0].address_components;
                        for (var index in fields) {
                            console.log(fields[index]);
                        }
                        if (markerReport != null) {
                            markerReport.setMap(null);
                        }
                        markerReport.setPosition(results[0].geometry.location);
                        map.setZoom(16);
                        markerReport.setMap(map);
                    } else {}
                });
            }
        }
        if ($("#form-carga").is(":visible")) {
            clicMapAvailable();
        }
        $("#btn-cargar").click(function(e) {
            history.pushState("", "", "/reportes/cargar");
            e.preventDefault();
            $("#form-portada").hide(500);
            $("#form-carga").show(500, function() {
                $("#TdeFMap").addClass("form-active");
            });
            $(".widged-right").hide();
            markerReport.setVisible(true);
            clicMapAvailable();
            google.maps.event.trigger(map, "resize");
        });
        $("#title, #volverReporte").click(function(e) {
            history.pushState("", "", "/");
            e.preventDefault();
            $("#TdeFMap").removeClass("form-active");
            $("#form-portada").show(500);
            $("#form-carga").hide(500);
            $(".widged-right").show();
            markerReport.setVisible(false);
            clicMapDisavailable();
            google.maps.event.trigger(map, "resize");
        });
    }
    function getMarkers(days) {
        var ajax_url = baseUrl + "listar/" + days;
        var ajax_request = new XMLHttpRequest();
        ajax_request.onreadystatechange = function() {
            if (ajax_request.readyState == 4) {
                var Markers = JSON.parse(ajax_request.responseText);
                for (var i = Markers.length - 1; i >= 0; i--) {
                    DrawMarkers(Markers[i], i);
                }
            }
        };
        ajax_request.open("GET", ajax_url, true);
        ajax_request.send();
    }
    function DrawMarkers(info, position) {
        var markerLatLng = {
            lat: parseFloat(info.lat),
            lng: parseFloat(info.lng)
        };
        var estadosPanel = [ "panel panel-default infoBubble", "panel panel-primary infoBubble", "panel panel-warning infoBubble", "panel panel-success infoBubble" ];
        var markerHtml = '<div class="panel-heading">' + '<h3 class="panel-title">' + info.titulo + "</h3>" + "</div>" + '<div class="panel-body text-center">';
        if (info.imagen != null && info.imagen != "") {
            var img = info.imagen.split(".");
            markerHtml += '<img class="img-responsive" src="' + baseUrl + "assets/subidas/thumbs/" + img[0] + "_thumb." + img[1] + '"><hr>';
        }
        markerHtml += '<p class="text-left">' + info.texto + "</p>" + "</div>" + '<div class="panel-footer"> ' + "<p><b>Direcci&oacute;n: </b>" + info.direccion + "</p>";
        +"</div>";
        var icon = inconBase + icons[info.categoria];
        switch (info.estado) {
          case "2":
            icon += "_proceso";
            break;

          case "3":
            icon += "_resuelto";
            break;
        }
        markers[position] = new google.maps.Marker({
            position: markerLatLng,
            title: info.titulo,
            category: info.categoria,
            status: info.estado,
            icon: icon + ".png"
        });
        google.maps.event.addListener(markers[position], "click", function() {
            // infoBubble.setBackgroundClassName( estadosPanel[ parseInt(info.estado)]);    
            infoBubble.setContent(markerHtml);
            infoBubble.open(map, markers[position]);
        });
        markers[position].setMap(map);
    }
    var categories = document.getElementById("caregoriasReporte");
    categories.onchange = function() {
        var idCategory = this.value;
        var iconUrl = inconBase + icons["0"] + "-big.png";
        if (idCategory != null && idCategory != undefined) {
            iconUrl = inconBase + icons[idCategory] + "-big.png";
        }
        markerReport.setAnimation(google.maps.Animation.BOUNCE);
        markerReport.setIcon(iconUrl);
        setTimeout(function() {
            markerReport.setAnimation(null);
        }, 1e3);
    };
}

function clicMapAvailable() {
    google.maps.event.addListener(tresDeFebreroPol, "click", function(event) {
        infoBubble.close();
        markerReport.setPosition(event.latLng);
        markerReport.setMap(map);
        geocodeLatLng(geocoder, event.latLng);
        document.getElementById("lat").value = markerReport.getPosition().lat();
        document.getElementById("lng").value = markerReport.getPosition().lng();
    });
}

function clicMapDisavailable() {
    google.maps.event.clearListeners(tresDeFebreroPol, "click");
}

function geocodeLatLng(geocoder, latlng) {
    geocoder.geocode({
        location: latlng
    }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                document.getElementById("direccionReporte").value = results[0].formatted_address;
                document.getElementById("localidadReporte").value = results[0].address_components[2].long_name;
            }
        }
    });
}