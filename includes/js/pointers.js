( function($, MAP) {

    $(document).on( 'MyAdminPointers.setup_done', function( e, data ) {
        e.stopImmediatePropagation();
        MAP.setPlugin( data ); 
    } );

    $(document).on( 'MyAdminPointers.current_ready', function( e ) {
        e.stopImmediatePropagation();
        MAP.openPointer(); 
    } );

    MAP.js_pointers = {};        
    MAP.first_pointer = false;   
    MAP.current_pointer = false; 
    MAP.last_pointer = false;    
    MAP.visible_pointers = [];   

    MAP.hasNext = function( data ) { 
        return typeof data.next === 'string'
            && data.next !== ''
            && typeof MAP.js_pointers[data.next].data !== 'undefined'
            && typeof MAP.js_pointers[data.next].data.id === 'string';
    };

    MAP.isVisible = function( data ) { 
        return $.inArray( data.id, MAP.visible_pointers ) !== -1;
    };

    
    MAP.getPointerData = function( data ) {
        var $target = $( data.anchor_id );
        if ( $.inArray(data.id, MAP.visible_pointers) !== -1 ) {
            return { target: $target, data: data };
        }
        $target = false;
        while( MAP.hasNext( data ) && ! MAP.isVisible( data ) ) {
            data = MAP.js_pointers[data.next].data;
            if ( MAP.isVisible( data ) ) {
                $target = $(data.anchor_id);
            }
        }
        return MAP.isVisible( data )
            ? { target: $target, data: data }
            : { target: false, data: false };
    };

    
    MAP.setPlugin = function( data ) {
        jQuery('#overlay').show();

        if ( typeof MAP.last_pointer === 'object') {
            MAP.last_pointer.pointer('destroy');
            MAP.last_pointer = false;
        }
        jQuery(data.anchor_id).css('z-index','2');


        MAP.current_pointer = false;
        var pointer_data = MAP.getPointerData( data );
        if ( ! pointer_data.target || ! pointer_data.data ) {
            return;
        }
        $target = pointer_data.target;
        data = pointer_data.data;
        $pointer = $target.pointer({
            content: data.title + data.content,
            position: { edge: data.edge, align: data.align },
            close: function() {
                jQuery(data.anchor_id).css('z-index','0');
                jQuery('#overlay').hide();
                $.post( ajaxurl, { pointer: data.id, action: 'dismiss-wp-pointer' } );
            }
        });
        MAP.current_pointer = { pointer: $pointer, data: data };
        $(document).trigger( 'MyAdminPointers.current_ready' );
    };

    
    MAP.openPointer = function() {
        var $pointer = MAP.current_pointer.pointer;
        if ( ! typeof $pointer === 'object' ) {
            return;
        }
        $('html, body').animate({ 
            scrollTop: $pointer.offset().top-120
        }, 300, function() { 
            MAP.last_pointer = $pointer;
            var $widget = $pointer.pointer('widget');
            MAP.setNext( $widget, MAP.current_pointer.data );
            $pointer.pointer( 'open' ); 
        });


    };

    
    MAP.setNext = function( $widget, data ) {
        if ( typeof $widget === 'object' ) {
            var $buttons = $widget.find('.wp-pointer-buttons').eq(0);
            var $close = $buttons.find('a.close').eq(0);
            $button = $close.clone(true, true).removeClass('close');
            $close_button = $close.clone(true, true).removeClass('close');
            $buttons.find('a.close').remove();
            $button.addClass('button').addClass('button-primary');
            $close_button.addClass('button').addClass('button-primary');


            has_next = false;
            if ( MAP.hasNext( data ) ) {
                has_next_data = MAP.getPointerData(MAP.js_pointers[data.next].data);
                has_next = has_next_data.target && has_next_data.data;
                $button.html(MAP.next_label).appendTo($buttons);
                $close_button.html(MAP.close_label).appendTo($buttons);
                jQuery($close_button).css('margin-right','10px');
                jQuery($close_button).click(function (e) {
                    jQuery('#overlay').hide();
                    jQuery('#dismiss_pointers').submit();
                });
            }
            else
            {
                var label = has_next ? MAP.next_label : MAP.close_label;
                jQuery($button).css('margin-right','10px');
                $button.html(label).appendTo($buttons);
            }
            jQuery($button).click(function () {
                if(data.isdefault =='yes')
                {
                    switch(data.anchor_id){
                        case '#select_your_idp':
                            document.getElementById('sp-setup-tab').className = 'nav-tab';
                            document.getElementById('sp-meta-tab').className = 'nav-tab nav-tab-active';
                            document.getElementById('save_tab').style.display = 'none';
                            document.getElementById('config_tab').style.display='block';
                            break;
                        case '#metadata_url':
                            document.getElementById('sp-setup-tab').className = 'nav-tab nav-tab-active';
                            document.getElementById('sp-meta-tab').className = 'nav-tab';
                            document.getElementById('save_tab').style.display = 'block';
                            document.getElementById('config_tab').style.display = 'none';
                            break;
                        case '#test_config':
                            document.getElementById('sp-setup-tab').className = 'nav-tab';
                            document.getElementById('attr-role-tab').className = 'nav-tab nav-tab-active';
                            document.getElementById('save_tab').style.display = 'none';
                            document.getElementById('opt_tab').style.display = 'block';
                            break;
                        case '#miniorange-role-mapping':
                            document.getElementById('attr-role-tab').className = 'nav-tab';
                            document.getElementById('redir-sso-tab').className = 'nav-tab nav-tab-active';
                            document.getElementById('opt_tab').style.display = 'none';
                            document.getElementById('redir_sso_tab').style.display = 'block';
                            break;
                        case '#minorange-use-widget':
                            document.getElementById('redir-sso-tab').className = 'nav-tab';
                            document.getElementById('addon-tab').className = 'nav-tab nav-tab-active';
                            document.getElementById('redir_sso_tab').style.display = 'none';
                            document.getElementById('addons_tab').style.display = 'block';
                            document.getElementById('support-form').style.display = 'none';
                            break;      
                        case '#miniorange-addons5':
                            document.getElementById('addon-tab').className = 'nav-tab';
                            document.getElementById('sp-setup-tab').className = 'nav-tab nav-tab-active';
                            document.getElementById('addons_tab').style.display = 'none';
                            document.getElementById('save_tab').style.display = 'block';
                            document.getElementById('support-form').style.display = 'block';
                            break;                                                       
                    }
                }

                if ( MAP.hasNext( data ) ) {
                    MAP.setPlugin( MAP.js_pointers[data.next].data );
                }
            });
        }
    };

    $(MAP.pointers).each(function(index, pointer) { 
        if( ! $().pointer ) return;      
        MAP.js_pointers[pointer.id] = { data: pointer };
        var $target = $(pointer.anchor_id);
        if ( $target.length) { 
            MAP.visible_pointers.push(pointer.id);
            if ( ! MAP.first_pointer ) {
                MAP.first_pointer = pointer;
            }
        }
        if ( index === ( MAP.pointers.length - 1 ) && MAP.first_pointer ) {
            $(document).trigger( 'MyAdminPointers.setup_done', MAP.first_pointer );
        }
    });

} )(jQuery, MyAdminPointers); 