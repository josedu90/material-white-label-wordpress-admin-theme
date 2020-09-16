/*global reduk_change, reduk*/

(function( $ ) {
    "use strict";

    reduk.field_objects = reduk.field_objects || {};
    reduk.field_objects.multi_text = reduk.field_objects.multi_text || {};

    $( document ).ready(
        function() {
            //reduk.field_objects.multi_text.init();
        }
    );

    reduk.field_objects.multi_text.init = function( selector ) {

        if ( !selector ) {
            selector = $( document ).find( '.reduk-container-multi_text:visible' );
        }

        $( selector ).each(
            function() {
                var el = $( this );
                var parent = el;
                if ( !el.hasClass( 'reduk-field-container' ) ) {
                    parent = el.parents( '.reduk-field-container:first' );
                }
                if ( parent.is( ":hidden" ) ) { // Skip hidden fields
                    return;
                }
                if ( parent.hasClass( 'reduk-field-init' ) ) {
                    parent.removeClass( 'reduk-field-init' );
                } else {
                    return;
                }
                el.find( '.reduk-multi-text-remove' ).live(
                    'click', function() {
                        reduk_change( $( this ) );
                        $( this ).prev( 'input[type="text"]' ).val( '' );
                        $( this ).parent().slideUp(
                            'medium', function() {
                                $( this ).remove();
                            }
                        );
                    }
                );

                el.find( '.reduk-multi-text-add' ).click(
                    function() {
                        var number = parseInt( $( this ).attr( 'data-add_number' ) );
                        var id = $( this ).attr( 'data-id' );
                        var name = $( this ).attr( 'data-name' );
                        for ( var i = 0; i < number; i++ ) {
                            var new_input = $( '#' + id + ' li:last-child' ).clone();
                            el.find( '#' + id ).append( new_input );
                            el.find( '#' + id + ' li:last-child' ).removeAttr( 'style' );
                            el.find( '#' + id + ' li:last-child input[type="text"]' ).val( '' );
                            el.find( '#' + id + ' li:last-child input[type="text"]' ).attr( 'name', name );
                        }
                    }
                );
            }
        );
    };
})( jQuery );