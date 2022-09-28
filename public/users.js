$(document).ready(function() {

    let table = $('#dataTable');

    table.DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: table.data('table-href'),
        columns: [{
                data: 'data_entry',
                name: 'data_entry',
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'photo',
                name: 'photo',
                "render": function(data, type, row, meta) {
                    return '<img src="' + row.photo + '" width="50">';
                }
            },
            {
                data: 'id',
                name: 'id',
                searchable: false,
                class: 'edit-list',
                "render": function(data, type, row, meta) {
                    return '<a href="javascript:void(0)" class="btn btn-primary mb-5 w-20 open-form" data-id="' +
                        row.id +
                        '">Edit</a>&nbsp;<a href="javascript:void(0)" class="btn btn-danger mb-5 w-20 delete" data-id="' +
                        row.id + '">Delete</a>';
                }
            },
        ]
    });

    jQuery('body').on('click', '.open-form', function() {
        if (($(this).data('id'))) {
            var link = table.data('edit-href') + '/' + $(this).data('id');
        } else {
            var link = $(this).data('create-href');
        }
        $.ajax({
            url: link,
            success: function(response) {
                if ((response.error)) {
                    errorFun(response.error);
                } else {
                    $('#content-form, #content-table').toggle();
                    $('#content-form').html(response);
                    /* JQuery Validations */
                    $("#submit-form").validate();
                }
            },
            error: function(error) {
                warningFun();
            }
        });
    });

    jQuery('body').on('click', '.goBack', function() {
        $('#content-form, #content-table').toggle();
    });

    /* Submit Form Using Ajax */
    $(document).on('submit', '#submit-form', function(e) {
        e.preventDefault();

        $.ajax({
            type: $(this).prop('method'),
            url: $(this).prop('action'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                if ((response.error)) {
                    errorFun(response.error);
                } else {
                    $('#content-form, #content-table').toggle();
                    table.DataTable().ajax.reload();
                    $.toast({
                        heading: 'Success',
                        text: response.success,
                        showHideTransition: 'slide',
                        icon: 'success',
                        loaderBg: '#f96868',
                        position: 'top-center'
                    });
                }
            },
            error: function(error) {
                warningFun();
            }
        });
    });

    /* Delete Record */
    jQuery('body').on('click', '.delete', function() {
        var $this = $(this);
        var action = table.data('delete-href');
        var id = $this.data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this records!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: action + '/' + id,
                    success: function(response) {
                        $this.parents('tr').remove();
                        Swal.fire("Deleted!", "Data Deleted successfully",
                            "success");
                    },
                    error: function(response) {
                        Swal.fire("Oops!", "something went wrong!", "warning");
                    }
                });
            } else if (result.dismiss === "cancel") {
                Swal.fire("Cancelled", "Your records is safe :)", "error");
            }
        });
    });
    // Warning Function
    function warningFun() {
        $.toast({
            heading: 'Warning',
            text: 'Something went wrong! Please try again!',
            showHideTransition: 'slide',
            icon: 'warning',
            loaderBg: '#57c7d4',
            position: 'top-center'
        });
    }

    // Error Function
    function errorFun(error) {
        $.toast({
            heading: 'Error',
            text: error,
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-center'
        });
    }
});