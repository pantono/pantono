$(function () {
    $('.delete-role').on('click', function (e) {
        e.preventDefault();
        Pantono.modal.confirmModal($(this).attr('href'), 'Sure?', true);
    });
    $('.add-role').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Pantono.modal.showAjaxModal(url, 'Add New Role', '<button class="btn btn-success" id="performRoleAdd" aria-hidden="true">Add</button>', function () {
            $('#performRoleAdd').off('click').on('click', function (e) {
                var form = $('#add_role_form');
                console.log(url, 'Here');
                $.post(url, form.serialize(), function (data) {
                    if (data.success) {
                        Pantono.modal.closeModal();
                        document.location.reload();
                    } else {
                        if (data.message) {
                            alert(data.message);
                        } else {
                            alert('There was an error in saving your request');
                        }
                    }
                });
            });
        });
    });
});
