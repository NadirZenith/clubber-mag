CMP = function (options) {
    var
            $body = $("body"),
            settings = {
                callback: function (now, total) {
                    console.log('now ' + now);
                    console.log('total ' + total);
                    console.log('options ', options);

                },
                total: options.offsetStart - options.offsetEnd
            };

    $.extend(settings, options);

    $(window).scroll(onScroll);

    function onScroll(e) {
        var body_height = $body.outerHeight(true); //2409
        /*console.log('body_height', body_height);*/

        var scrollTop = $(window).scrollTop();// 0 -> ...
        /*console.log('scrollTop', scrollTop);*/

        var window_height = $(window).height();
        /*console.log('window_height', window_height);*/


        var current_position = window_height + scrollTop - 30; // +-600 ++ max 2409
        /*console.log('current_position', current_position);*/

        var px_left = body_height - current_position;// px left to touch bottom

        if (undefined !== settings.offsetStart
                && undefined !== settings.offsetEnd) {


            if (px_left < settings.offsetStart && px_left > settings.offsetEnd) {
                var now = settings.offsetStart - px_left;
            } else if (px_left < settings.offsetStart) {
                var now = settings.total;
            } else if (px_left > settings.offsetEnd) {
                var now = 0;
            }

            if (typeof settings.callback === 'function') {
                settings.callback(now, settings.total);
            }
        } else {
            /*console.log('start end');*/
        }

    }

    return {
        /*                        
         load: load,
         * */
    };
};