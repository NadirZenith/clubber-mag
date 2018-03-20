var nzwpsocials = (function () {
    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        }
        else {
            return uri + separator + key + "=" + value;
        }
    }

    function getParams(context) {
        var loc = window.location;
        var url = loc.href + "?nzwpsocials=" + context + '_login';

        var url = updateQueryStringParameter(window.location.href, 'nzwpsocials', context + '_login');
        console.log(url);
        var height = 500;
        var width = 650;

        return {
            height: height,
            width: width,
            left: Number((screen.width / 2) - (width / 2) + 10),
            top: Number((screen.height / 2) - (height / 2) + 50),
            url: url
        };
    }
    ;
    function openNewWindow(params) {
        /*var openedwin = window.open(params.url, '', 'scrollbars=no, menubar=no, height=' + params.height + ', width=' + params.width + ', top=' + params.top + ', left=' + params.left + ', resizable=yes, toolbar=no, status=no');*/
        var openedwin = window.open(params.url + '&display=popup', '', 'scrollbars=no, menubar=no, height=' + params.height + ', width=' + params.width + ', top=' + params.top + ', left=' + params.left + ', resizable=yes, toolbar=no, status=no');

        if (window.focus) {
            openedwin.focus();
        }
    }

    var facebookLogin = function () {

        var params = getParams('facebook');

        openNewWindow(params);

    };

    var twitterLogin = function () {
        var params = getParams('twitter');

        openNewWindow(params);

    };

    return {
        twitterLogin: twitterLogin,
        facebookLogin: facebookLogin
    };
})();