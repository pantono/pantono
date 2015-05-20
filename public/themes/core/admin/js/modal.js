var PantonoModal = {
    modalTemplate : '<div class="modal fade" id="{{id}}" tabindex="-1" role="dialog" aria-labelledby="{{id}}Label" aria-hidden="true">'+
        '<div class="modal-dialog">' +
        '<div class="modal-content">' +
        '<div class="modal-header">{{close_button}}' +
        '<h4 class="modal-title" id="myModalLabel">{{title}}</h4>' +
        '</div>' +
        '<div class="modal-body">{{{content}}}' +
        '</div>' +
        '<div class="modal-footer">{{{buttons}}}' +
        '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>',
    currentModal: null,
    closeButton : '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
    compiledTemplate : null,
    init: function()
    {
        this.compiledTemplate = Handlebars.compile(this.modalTemplate);
        return this;
    },
    confirmModal : function (url, header, pageReload) {
        $.get(url, function (data) {
            Pantono.modal.showModal(data, header, true, '<button class="btn btn-success" id="performModalDelete" aria-hidden="true">Yes</button>');
            $('#performModalDelete').off('click').on('click', function(e) {
                $.post(url, function (data) {
                    if (data.success) {
                        Pantono.modal.closeModal();
                        if (pageReload) {
                            document.location.reload();
                        }
                    } else {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            alert('There was an error in saving your request');
                        }
                    }
                });
            });
        })
    },
    showAjaxModal : function(url, header, buttons, callback) {
        $.get(url, function (data) {
            Pantono.modal.showModal(data, header, true, buttons);
            if (callback) {
                callback();
            }
        });
    },
    showModal : function(content, header, showCloseButton, actionButtons) {
        var id = 'modal' + Math.random().toString(36).slice(2);
        var data = {
            id: id,
            title: header,
            content: content
        };
        if (actionButtons) {
            data.buttons = actionButtons;//'<button class="btn" data-dismiss="modal" aria-hidden="true">{{close_text}}</button>'
        }
        if (showCloseButton === true) {
            data.closeButton = this.closeButton;
        }
        var modalContent = this.compiledTemplate(data);
        $('body').append(modalContent);
        var modal = $('#' + id).modal();
        self.currentModal = modal;
        return modal;
    },
    closeModal : function() {
        self.currentModal.modal('hide');
    }
};
