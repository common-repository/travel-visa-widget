( function( window, document, undefined ) {

    var strundefined = typeof undefined;

    // Attach an event handler function for one event to the selected element
    function addEventListener( element, eventName, eventHandler, selector ) {
        if ( selector ) {
            var wrappedHandler = function ( event ) {
                if ( event.target && event.target.matches( selector ) ) {
                    eventHandler( event );
                }
            };
            element.addEventListener( eventName, wrappedHandler );
            return wrappedHandler;
        } else {
            element.addEventListener( eventName, eventHandler );
            return eventHandler;
        }
    }

    // Check if an object is empty (contains no enumerable properties)
    function isEmptyObject( obj ) {
        for ( var prop in obj ) {
            if ( Object.prototype.hasOwnProperty.call( obj, prop ) ) {
                return false;
            }
        }
        return JSON.stringify( obj ) === JSON.stringify( { } );
    }

    // Rebuild the URL and append query variables to the URL
    function formatArgs( args ) {
        return "?" + Object
            .keys( args )
            .map( function( key ) {
                return key + "=" + encodeURIComponent( args[key] )
            } )
            .join( "&" );
    }

    // Perform an asynchronous HTTP (Ajax) request
    function request( endpoint, args, success, error ) {
        if ( typeof error === strundefined ) {
            error = function() { return; };
        }

        var url = ( ! isEmptyObject( args ) ) ? endpoint + formatArgs( args ) : endpoint;

        var request = new XMLHttpRequest();
        request.open( 'GET', url, true );

        request.onload = function() {
            if ( this.status >= 200 && this.status < 400 ) {
                success( this.responseText, this.status );
            } else {
                error();
            }
        };

        request.onerror = function() {
            error();
        };

        request.send();
    }

    // Gets the current value of the element
    function val( element ) {
        if ( element.options && element.multiple ) {
            return element.options
                .filter( ( option ) => option.selected )
                .map( ( option ) => option.value );
        } else {
            return element.value;
        }
    }

    // Gets visa requirement result
    function getVisaRequirement( target, nationality, destination, attributs ) {
        request(
            vmtvw_localize.ajax_url,
            {
                'action': 'vmtvw_get_ajax_requirement_result',
                'nationality': nationality,
                'destination': destination,
                'agency_id': attributs['agencyId'],
                'affilae_id': attributs['affilaeId']
            },
            function( data, status ) {
                if( status === 200 ) {
                    target.innerHTML = data;
                }
            }
        );
    }

    // DOM Ready function
    function ready( fn ) {
        if ( document.attachEvent
            ? document.readyState === 'complete'
            : document.readyState !== 'loading'
        ) {
            fn();
        } else {
            document.addEventListener( 'DOMContentLoaded', fn );
        }
    }

    // Start
    ready( function() {
        // Selects and loops through all instances of the widget
        var widgets = document.querySelectorAll( ".vmtvw-wrapper" );
        Array.prototype.forEach.call( widgets, function ( widget, index ) {

            // Finds child elements & widget attributs
            var nationality = widget.querySelector( ".vmtvw-nationality" ),
                destination = widget.querySelector( ".vmtvw-destination" ),
                resultArea = widget.querySelector( ".vmtvw-result" ),
                agencyId = widget.getAttribute('data-agency-id') ?? "",
                affilaeId = widget.getAttribute('data-affilae-id') ?? "";

            // Adds 'change' event on nationality <select> tag
            addEventListener( nationality, 'change', function( event ) {
                event.preventDefault();
                if ( val( this ) !== '' && val( destination ) !== '' ) {
                    getVisaRequirement( resultArea, val( this ), val( destination ), {
                        agencyId: agencyId,
                        affilaeId: affilaeId
                    } );
                }
            } );

            // Adds 'change' event on destination <select> tag
            addEventListener( destination, 'change', function( event ) {
                event.preventDefault();
                if ( val( this ) !== '' && val( nationality ) !== '' ) {
                    getVisaRequirement( resultArea, val( nationality ), val( this ), {
                        agencyId: agencyId,
                        affilaeId: affilaeId
                    } );
                }
            } );

        } );
    } );

} ( this, document ) );
