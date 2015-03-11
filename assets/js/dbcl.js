/*global dbcl:false, ajaxurl:false */
( function ( $ ) {
    $( document ).on( 'submit', '#dbcl_form', function ( e ) {
        e.preventDefault();
        $( '#dbcl_results' ).empty();
        var dbcl_data = {
            action: 'dbcl',
            dbcl_key: $( '#dbcl_key' ).val(),
            dbcl_group: $( '#dbcl_group' ).val(),
            security: dbcl.security
        };
        $.post( ajaxurl, dbcl_data, function ( res ) {
            if ( true === res.success ) {
                $( '#dbcl_results' ).html( res.data.cache );
            } else {
                $( '#dbcl_results' ).html( 'No cache data found.' );
            }
        } );
    } );
} )( jQuery );