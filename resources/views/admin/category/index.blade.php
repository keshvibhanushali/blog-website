<x-admin.master>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <button id="add_cat" class="btn btn-primary">Add category</button>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <select id="bulkEdit" name="category_id" class="form-control" disabled>
                        <option value=""> - -Select- - </option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-danger removeAll" disabled>Delete Selected Rows</button>
                </div>
            </div>

            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

        <script>
            $(document).ready(function() {


                $(document).on("click", "#add_cat", function() {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('cat-create') }}",
                        success: function(response) {
                            $('#modal').modal("show");
                            $('.modal-title').text("Add Category");
                            $(".modal-body").html(response);
                        }
                    });
                });



                //create category
                $(document).on('submit', '#create-cat-form', function(e) {
                    e.preventDefault();
                    let data = {
                        "name": $('#name').val(),
                        "status": $('#status option:selected').val(),
                    }

                    if (data.name == '') {
                        $('#create-cat-form #name-err').text(
                            "Name filed is required"
                        )
                    }


                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: "{{ route('add-cat') }}",
                        data: data,
                        success: function(data) {
                            $('#modal').modal('hide');
                            $('#data-table').DataTable().ajax.reload();
                        },
                        error: function() {}
                    })
                })

                //update category
                $(document).on("click", "#edit-btn", function(e) {
                    e.preventDefault();
                    let id = $(this).attr("data-id");
                    url = '{{ route('edit-cat', '/id') }}';
                    url = url.replace("/id", id);
                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function(response) {
                            $('#modal').modal("show");
                            $('.modal-title').text("Edit Category");
                            $(".modal-body").html(response);
                        }
                    })
                })

                $(document).on("submit", "#edit-cat-form", function(e) {
                    e.preventDefault();
                    let data = {
                        "name": $('#edit-cat-form #name').val(),
                        "status": $('#edit-cat-form #status').val(),
                    };
                    if (data.name == '') {
                        $('#edit-cat-form #name-err').text(
                            "Name filed is required"
                        )
                    }

                    let id = $('#edit-cat-form #cat_id').val();
                    let url = '{{ route('update-cat', '/id') }}';
                    url = url.replace('/id', id);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "PUT",
                        url: url,
                        data: data,
                        success: function() {
                            $('#modal').modal('hide');
                            $('#data-table').DataTable().ajax.reload();
                        },
                        error: function() {}
                    });
                });

                //delete
                $(document).on("click", "#delete-btn", function(e) {
                    e.preventDefault();
                    let id = $(this).attr('data-id');
                    let url = '{{ route('delete-cat', '/id') }}';
                    url = url.replace('/id', id);
                    //   console.log(url);
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: "DELETE",
                                url: url,
                                success: function() {
                                    $('#data-table').DataTable().ajax.reload();
                                },
                                error: function() {}
                            });

                        }
                    });
                });


                $(document).on('click', '.checkboxMain', function() {
                    let ids = [];
                    $('.checkbox').each(function(i) {
                        if ($(this).attr("checked", true)) {
                            ids[i] = $(this).val();
                        }
                    });
                    if (ids.length <= 0) {
                        toastr.error('error');
                    }
                    if ($(this).is(':checked', true)) {
                        // console.log(true);
                        // console.log(ids.length);
                        $('.removeAll').removeAttr('disabled');
                        $('.editAll').removeAttr('disabled');
                        $('#bulkEdit').removeAttr('disabled');
                        $('.checkbox').prop('checked', true);
                    } else {
                        // console.log(false);
                        // console.log(ids.length);
                        $('.removeAll').prop('disabled', true);
                        $('.editAll').prop('disabled', true);
                        $('#bulkEdit').prop('disabled', true);
                        $('.checkbox').prop('checked', false);
                    }
                });

                $(document).on('click', '.checkbox', function() {

                    let ids = [];
                    $('.checkbox:checked').each(function(i) {
                        ids[i] = $(this).val();
                    });
                    // console.log(ids);
                    // console.log(ids.length);
                    if (ids.length < 1) {
                        $('.removeAll').prop('disabled', true);
                        $('.editAll').prop('disabled', true);
                        $('#bulkEdit').prop('disabled', true);
                    } else {
                        $('.removeAll').removeAttr('disabled');
                        $('.editAll').removeAttr('disabled');
                        $('#bulkEdit').removeAttr('disabled');

                    }
                });

                $(document).on('change', '#bulkEdit', function() {
                    if ($('#bulkEdit').val() == '') {
                        $('.editAll').text('Delete').attr('class', 'btn btn-danger removeAll');
                    } else {
                        $('.removeAll').text('Edit').attr('class', 'btn btn-primary editAll');
                    }
                });

                //bulk delete
                $(document).on('click', '.removeAll', function() {
                    let ids = [];
                    $('.checkbox:checked').each(function() {
                        ids.push($(this).val());
                    });
                    if (ids.length <= 0) {
                        $('.removeAll').attr('disabled', true);
                        $('.editAll').attr('disabled', true);
                    }
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: "POST",
                                url: "{{ route('bulkDelete') }}",
                                data: {
                                    'ids': ids,
                                },
                                success: function(data) {
                                    $('#data-table').DataTable().ajax.reload();
                                },
                                error: function(data) {}
                            });
                        }
                    });
                });

                //bulk edit

                $(document).on('click', '.editAll', function() {
                    let ids = [];
                    let status = $('#bulkEdit').val();
                    $('.checkbox:checked').each(function() {
                        ids.push($(this).val());
                    });

                    if (ids.length <= 0) {
                        $('.removeAll').prop('disabled', true);
                    }

                    if ($('.removeAll').prop('disabled') == false || $('.editAll').prop('disabled') == false) {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, update it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // console.log(ids);
                                // console.log(status);
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    type: "PUT",
                                    url: "{{ route('bulkUpdate') }}",
                                    data: {
                                        'ids': ids,
                                        'status': status,
                                    },
                                    success: function(data) {
                                        $('#data-table').DataTable().ajax.reload();
                                    },
                                    error: function(data) {

                                    }
                                });
                            }
                        });
                    }
                });



            });
        </script>
    @endpush
</x-admin.master>
