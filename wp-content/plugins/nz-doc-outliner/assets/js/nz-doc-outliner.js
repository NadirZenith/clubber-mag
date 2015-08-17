/**
 * https://github.com/h5o/h5o-js
 */

$(function () {
    $('.nz-doc-outliner').on('click', function (e) {
        e.stopPropagation();
        var $c = getContainer();
        var outline = HTML5Outline(document.body);

        $c.html(outline.asHTML(false));

        $c.show();







    });

    function getContainer() {

        var $body = $(document.body);
        var $container = $body.find('#nz-doc-outliner');

        if (!$container.length) {

            var $container = $('<div id="nz-doc-outliner"></div>');
            $body.append($container);
        }

        $body.one('click', function () {
            $container.hide();
        });

        return $container;
    }

    function tryValidator2() {

        var data = new Blob(['<h1>test</h1>'], {type: 'text/plain'});
        var textFile = window.URL.createObjectURL(data);
        $.ajax({
            url: "https://validator.w3.org/nu/?out=json",
            dataType: 'jsonp',
            data: {
                'content': textFile
            }
        }, function () {

        });
    }

    function tryValidator() {
        var textFile = null,
                makeTextFile = function (text) {
                    var data = new Blob([text], {type: 'text/plain'});

                    // If we are replacing a previously generated file we need to
                    // manually revoke the object URL to avoid memory leaks.
                    if (textFile !== null) {
                        window.URL.revokeObjectURL(textFile);
                    }

                    textFile = window.URL.createObjectURL(data);

                    return textFile;
                };


        var create = document.getElementById('create'),
                textbox = document.getElementById('textbox');

        create.addEventListener('click', function () {
            var link = document.getElementById('downloadlink');
            link.href = makeTextFile(textbox.value);
            link.style.display = 'block';
        }, false);
    }

});