// Custom Script
// Developed by: Samson.Onna
var customScripts = {
    profile: function () {
        // portfolio
        if ($('.isotopeWrapper').length) {
            var $container = $('.isotopeWrapper');
            var $resize = $('.isotopeWrapper').attr('id');
            // initialize isotope
            $container.isotope({
                itemSelector: '.isotopeItem',
                resizable: false, // disable normal resizing
                masonry: {
                    columnWidth: $container.width() / $resize
                }
            });
            $("a[href='#top']").click(function () {
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            });
            $('.navbar-inverse').on('click', 'li a', function () {
                $('.navbar-inverse .in').addClass('collapse').removeClass('in').css('height', '1px');
            });
            $('#filter a').click(function () {
                $('#filter a').removeClass('current');
                $(this).addClass('current');
                var selector = $(this).attr('data-filter');
                $container.isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 1000,
                        easing: 'easeOutQuart',
                        queue: false
                    }
                });
                return false;
            });
            $(window).smartresize(function () {
                $container.isotope({
                    // update columnWidth to a percentage of container width
                    masonry: {
                        columnWidth: $container.width() / $resize
                    }
                });
            });
        }
    },
    fancybox: function () {
        // fancybox
        $(".fancybox").fancybox();
    },
    onePageNav: function () {

        $('#mainNav').onePageNav({
            currentClass: 'active',
            changeHash: false,
            scrollSpeed: 950,
            scrollThreshold: 0.2,
            filter: '',
            easing: 'swing',
            begin: function () {
                //I get fired when the animation is starting
            },
            end: function () {
                //I get fired when the animation is ending
            },
            scrollChange: function ($currentListItem) {
                //I get fired when you enter a section and I pass the list item of the section
            }
        });
    },
//    slider: function () {
//        $('#da-slider').cslider({
//            autoplay: true,
//            bgincrement: 0,
//            autoplayTimeout: 10000
//        });
//    },
//    owlSlider: function () {
//        var owl = $("#owl-demo");
//        owl.owlCarousel();
//        // Custom Navigation Events
//        $(".next").click(function () {
//            owl.trigger('owl.next');
//        })
//        $(".prev").click(function () {
//            owl.trigger('owl.prev');
//        })
//    },
    bannerHeight: function () {
        var bHeight = $(".banner-container").height();
        $('#da-slider').height(bHeight);
        $(window).resize(function () {
            var bHeight = $(".banner-container").height();
            $('#da-slider').height(bHeight);
        });
    },
    goolemap: function () {

        var lat = 6.92708;
        var lng = 79.8612;
        $('#latitude').val(lat);
        $('#longitude').val(lng);
        codeLatLng(lat, lng);
        latlng = new google.maps.LatLng(lat, lng),
                image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png';
        var mapOptions = {
            center: new google.maps.LatLng(lat, lng),
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: true,
            panControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.TOP_left
            }
        },
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions),
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    icon: image,
                    draggable: true
                });

        var input = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(input, {
            types: ["geocode"],
            componentRestrictions: {country: "lk"}
        });

        autocomplete.bindTo('bounds', map);
        var infowindow = new google.maps.InfoWindow();

        google.maps.event.addListener(autocomplete, 'place_changed', function (event) {
            infowindow.close();
            var place = autocomplete.getPlace();
            if (place.geometry) {
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
            }

            moveMarker(place.name, place.geometry.location);
            $('.MapLat').val(place.geometry.location.lat());
            $('.MapLon').val(place.geometry.location.lng());
            $('#latitude').val(place.geometry.location.lat());
            $('#longitude').val(place.geometry.location.lng());

        });

        google.maps.event.addListener(marker, 'dragend', function (event) {
            $('.MapLat').val(event.latLng.lat());
            $('.MapLon').val(event.latLng.lng());
            infowindow.close();
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                "latLng": event.latLng
            }, function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    var lat = results[0].geometry.location.lat(),
                            lng = results[0].geometry.location.lng(),
                            placeName = results[0].address_components[0].long_name,
                            latlng = new google.maps.LatLng(lat, lng);
                    $('#latitude').val(lat);
                    $('#longitude').val(lng);


                    moveMarker(placeName, latlng);
                    $("#address").val(results[0].formatted_address);
                }

            });
        });
                google.maps.event.addListener(marker, 'click', function (event) {
            $('.MapLat').val(event.latLng.lat());
            $('.MapLon').val(event.latLng.lng());
            infowindow.close();
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                "latLng": event.latLng
            }, function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    var lat = results[0].geometry.location.lat(),
                            lng = results[0].geometry.location.lng(),
                            placeName = results[0].address_components[0].long_name,
                            latlng = new google.maps.LatLng(lat, lng);
                    $('#latitude').val(lat);
                    $('#longitude').val(lng);


                    moveMarker(placeName, latlng);
                    $("#address").val(results[0].formatted_address);
                }

            });
        });

        function moveMarker(placeName, latlng) {
            marker.setIcon(image);
            marker.setPosition(latlng);
            infowindow.setContent(placeName);
            //infowindow.open(map, marker);
        }
        function codeLatLng(lat, lng) {
            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(lat, lng);
            geocoder.geocode({'latLng': latlng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {

                    if (results[1]) {
                        //formatted address
                        $("#address").val(results[0].formatted_address);
                        //find country name
                        for (var i = 0; i < results[0].address_components.length; i++) {
                            for (var b = 0; b < results[0].address_components[i].types.length; b++) {

                                //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                                if (results[0].address_components[i].types[b] == "administrative_area_level_1") {
                                    //this is the object you are looking for
                                    city = results[0].address_components[i];
                                    break;
                                }
                            }
                        }
                        //city data
//        $("#searchTextField").val(city.short_name + " " + city.long_name)


                    } else {
                        alert("No results found");
                    }
                } else {
                    alert("Geocoder failed due to: " + status);
                }
            });
        }
        function showPosition(position) {
            var latlon = position.coords.latitude + "," + position.coords.longitude;

        }
        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    x.innerHTML = "User denied the request for Geolocation."
                    break;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML = "The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML = "An unknown error occurred."
                    break;
            }
        }


    },
    init: function () {
        customScripts.onePageNav();
        customScripts.profile();
        customScripts.fancybox();
        customScripts.goolemap();
//        customScripts.owlSlider();
        customScripts.bannerHeight();
    }
}
$('document').ready(function () {
    $(document).on("click", "#btn-service-navigation", function () {
        $('html, body').animate({
            scrollTop: $("#skills").offset().top
        }, 2000);
    });

    // This will NOT work because there is no '#test-element' ... yet
    function toggleIcon(e) {
        $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);

    $('.accordion2').on('hidden.bs.collapse', toggleIcon);
    $('.accordion2').on('shown.bs.collapse', toggleIcon);
    customScripts.init();
});