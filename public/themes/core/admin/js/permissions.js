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

    $('.form-filters #find').on('keyup', function (e) {
        var search = $(this).val().toLowerCase();
        $('.privilege-table tbody tr').each(function(e) {
            var name = $(this).children('td:eq(0)').text();
            if (name.toLowerCase().indexOf(search) !== -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
