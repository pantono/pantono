if (typeof Pantono === 'undefined') {
    console.log('Cannot find master Pantono object');
} else {
    Pantono.forms = {
        init: function () {
            return this;
        },
        displayFormErrors: function (form_id, errors) {
            var form = $('form[name=' + form_id + ']');
            form.prepend('<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Please fix the highlighted fields</div>');
            if (!form.length) {
                console.log("Unable to find form " + form_id + " to display errors");
                return null;
            }
            for (field in errors) {
                var error = errors[field];
                var field_id = form_id + '_' + field;
                form.find('#' + field_id).addClass('input-error');
            }
        }
    };
}