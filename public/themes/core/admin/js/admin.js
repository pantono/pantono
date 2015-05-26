var loadedJavascript = [];
function addJavascript(filePath, callback){
    if (typeof loadedJavascript[filePath] === 'undefined') {
        var failAfter = 3000,
            success = function () {
                if (callback) {
                    callback();
                }
                clearTimeout(t);
            },
            error = function () {
                console.log("Unable to load " + script.src);
            },
            t = setTimeout(error, failAfter);

        var script = document.createElement('script');
        script.src = filePath;
        //script.type = 'text/javascript';
        script.onreadystatechange = success;
        script.onload = success;

        var head = document.getElementsByTagName('head')[0];
        head.appendChild(script);
    } else {
        callback();
    }
}

$(function() {
    $('.modal-link').on('click', function(e) {
        e.preventDefault();
        Pantono.modal.showAjaxModal($(this).attr('href'));
    });
});

var PantonoJS = {
    modal: null,
    forms: null,
    init : function() {
        this.modal = PantonoModal.init();
        addJavascript('/themes/core/admin/js/forms.js', function() { Pantono.forms.init(); });
        return this;
    }
};

var Pantono = PantonoJS.init();
