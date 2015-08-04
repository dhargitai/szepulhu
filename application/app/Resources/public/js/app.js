/**
 * This is the application namespace.
 */
var Application = (function() {
    var currentOptions;

    return {

        /**
         * Initialize application
         *
         * @param options Parameters object
         */
        init: function(options) {
            $(document).foundation();

            currentOptions = $.extend({
                geolocationAdapter: new Application.Geolocation.BrowserAdapter()
            }, options || {});
        },

        /**
         * Update featured professionals section via AJAX method
         *
         * The location of professionals is stored in a cookie, but at first time the method tries to find out the
         * position based on the geolocation provider.
         */
        geolocateClosestFeaturedProfessionals: function() {
            if (!Cookies.get('location') && currentOptions.geolocationAdapter.isSupported()) {
                currentOptions.geolocationAdapter.getCurrentPosition(
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

/**
 * This object is a namespace for geolocation classes
 */
Application.Geolocation = {

    /**
     * This adapter utilizes the web browsers's HTML5 Javascript capabilities to retrieve information about
     * the actual location of the user.
     *
     * @returns {{isSupported: Function, getCurrentPosition: Function}}
     * @constructor
     */
    BrowserAdapter: function() {
        return {

            /**
             * Tells whether the browser is capable of looking up geo coordinates.
             *
             * @returns boolean
             */
            isSupported: function() {
                return Modernizr.geolocation;
            },

            /**
             * Tries to look up the geo coordinates and execute callback.
             *
             * @param resultCallback Function to be called with the retrieved coordinates. It has a location argument.
             */
            getCurrentPosition: function(resultCallback) {
                if (geoPosition.init()) {
                    geoPosition.getCurrentPosition(resultCallback);
                }
            }
        }
    },

    /**
     * This adapter simply returns the coordinates given as constructor arguments.
     * It can be used mainly for testing purposes.
     *
     * @param latitude Latitude coordinate of current location.
     * @param longitude Longitude coordinate of current location.
     * @returns {{isSupported: Function, getCurrentPosition: Function}}
     * @constructor
     */
    DummyAdapter: function(latitude, longitude) {
        var resultLocation = {
            coords: {
                latitude: latitude,
                longitude: longitude
            }
        };

        return {
            isSupported: function() {
                return true;
            },
            getCurrentPosition: function (resultCallback) {
                resultCallback.call(this, resultLocation);
            }
        }
    }
};

Application.init();
