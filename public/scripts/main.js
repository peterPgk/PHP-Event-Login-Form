;(function($) {

    //Wrapper
    var $content = $('#content');

    //handle when form is submitted
    $content.on( 'submit', 'form', function(e) {
        var $form = $(this),
            //$content = $('#content'),
            $curr_container = $content.find('.container');

        $.ajax( this.action, {
            "type" : "post",
            "data" : {
                "is_ajax" : 'true',
                "form_data" : $form.serialize()
            }
        })
            .done(function (response) {
                s_animate( $content, $curr_container, response );
            })
            .fail(function (error) {
                console.log( error, 'error' );
            });

        return false;
    });

    //When we click over link
    $content.on('click', '.follow', function (e) {
        var $curr_container = $content.find('.container');
        $.ajax( this.href, {
            'type' : "post",
            'data' : {
                'is_ajax' : 'true'
            }
        })
            .done(function (response) {
                s_animate( $content, $curr_container, response );
            });

        return false;
    });

    //Animate content
    function s_animate( $wrapper, $container, append ) {
        var $curr_h = $container.height();
        //fix for jump when animate
        $container.css({marginBottom: '20px'});

        $wrapper
            .css({maxHeight: $curr_h, overflow: 'hidden'})
            .append(append);

        var $new_content = $wrapper.find('.container').not($container);

        $container.animate({'marginTop': -($curr_h + 20) + 'px'}, 1500, function () {
            $container.remove();
        });

        $wrapper.css({maxHeight: $new_content.height()});
    }

}(jQuery));