$(function() {
    $('.delete-user').on('click', function (e) {
        e.preventDefault();
        Pantono.modal.confirmModal($(this).attr('href'), 'Sure?', true);
    });
    $('.add-user').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Pantono.modal.showAjaxModal(url, 'Add New User', '<button class="btn btn-success" id="performUserAdd" aria-hidden="true">Add</button>', function () {
            $('#performUserAdd').off('click').on('click', function (e) {
                var form = $('#add_user_form');
                $.post(url, form.serialize(), function (data) {
                    if (data.success) {
                        Pantono.modal.closeModal();
                        document.location.reload();
                    } else {
                        if (data.message) {
                            Pantono.forms.displayFormErrors('admin_user', data.errors);
                        } else {
                            alert('There was an error in saving your request');
                        }
                    }
                });
            });
        });
    });
});