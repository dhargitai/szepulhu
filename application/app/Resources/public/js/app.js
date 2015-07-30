var Application = (function() {
    return {
        init: function() {
            $(document).foundation();
        },

        geolocateClosestFeaturedProfessionals: function() {
            if (!Cookies.get('location') && geoPosition.init()) {
                geoPosition.getCurrentPosition(
                    function(location) {
                        if (location.coords.latitude && location.coords.longitude) {
                            $.ajax({
                                url : Routing.generate('get_closest_location'),
                                type: 'post',
                                data: {
                                    latitude: location.coords.latitude,
                                    longitude: location.coords.longitude
                                },
                                success: function(response) {
                                    Cookies.set('location', response.location);
                                    var $locationSelector = $('#locationSelector');
                                    if ($locationSelector.val() != response.location.name) {
                                        $locationSelector.val(response.location.name).trigger('change');
                                    }
                                }
                            });
                        }
                    },
                    function(error) {},
                    {enableHighAccuracy: true}
                );
            }
        }
    };
})();

Application.init();
