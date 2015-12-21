/**
 * This is the application namespace.
 */
var Application = (function() {
    var currentOptions;

    var application = {

        /**
         * Initialize application
         *
         * @param options Parameters object
         */
        init: function(options) {
            $(document).foundation();

            currentOptions = $.extend({
                geolocationAdapter: new Application.Geolocation.BrowserAdapter(),
                sessionCookieName: 'PHPSESSID'
            }, options || {});

            application.session = new Application.Session(currentOptions);
        },

        /**
         * Update featured professionals section via AJAX method
         *
         * The method tries to find out the position based on the geolocation provider and set the
         * location selector (city, county) based on that.
         *
         * @param locationSelector An HTML Select element representing the location.
         */
        geolocateClosestFeaturedProfessionals: function(locationSelector) {
            if (currentOptions.geolocationAdapter.isSupported()) {
                var session = application.session;
                currentOptions.geolocationAdapter.getCurrentPosition(
                    function(location) {
                        if (location.coords.latitude && location.coords.longitude && !session.has('location')) {
                            var coordinates = {
                                latitude: location.coords.latitude,
                                longitude: location.coords.longitude
                            };

                            $.ajax({
                                url : Routing.generate('update_location'),
                                type: 'post',
                                data: coordinates,
                                success: function(response) {
                                    session.set('location', coordinates);

                                    var $locationSelector = $(locationSelector);
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

    return application;
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
        };
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
        };
    }
};

/**
 * Application session class
 *
 * Use local session storage for keep track of what data have been shared with the backend.
 *
 * @param options Constructor options:
 * - sessionCookieName string: name of the session cookie used by the backend
 * @returns {{has: Function, get: Function, set: Function}}
 * @constructor
 */
Application.Session = function(options) {
    var sessionNamespace = Cookies.get(options.sessionCookieName),
        sessionStorage = window.sessionStorage;

    function getData() {
        return JSON.parse(sessionStorage.getItem(sessionNamespace) || '{}');
    }

    function setData(data) {
        sessionStorage.setItem(sessionNamespace, JSON.stringify(data));
    }

    return {
        has: function (key) {
            var sessionData = getData();
            return sessionData[key] !== undefined;
        },
        get: function (key) {
            var sessionData = getData();
            return sessionData[key];
        },
        set: function (key, value) {
            var sessionData = getData();
            sessionData[key] = value;
            setData(sessionData);
        }
    };
};

Application.init();
