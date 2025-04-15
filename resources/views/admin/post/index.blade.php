<x-admin.master>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <a href="/postcreate">
                    <button id="add_post" class="btn btn-primary">Add Post</button>
                </a>
                <div>
                    <button class="mt-2 btn btn-danger removeAll" disabled>Delete Selected Data</button>
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

                $(document).on("click", "#delete-btn", function(e) {
                    e.preventDefault();
                    let id = $(this).attr('data-id');
                    let url = '{{ route('delete-post', '/id') }}';
                    url = url.replace('/id', id);
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
                })

                $(document).on('click', '.mainCheckbox', function() {
                    let ids = [];
                    $('.checkbox').each(function(i) {
                        if ($(this).attr('checked', true)) {
                            ids[i] = $(this).val();
                        }
                    });
                    // console.log(ids);
                    // console.log(ids.length);
                    if (ids.length <= 0) {
                        toastr.error('error');
                    }

                    if ($(this).is(':checked', true)) {
                        // console.log(true);
                        // console.log(ids.length);
                        $('.removeAll').removeAttr('disabled');
                        $('.checkbox').prop('checked', true);
                    } else {
                        // console.log(false);
                        // console.log(ids.length);
                        $('.removeAll').prop('disabled', true);
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
                    if (ids.length <= 0) {
                        $('.removeAll').prop('disabled', true);
                    } else {
                        $('.removeAll').removeAttr('disabled');
                    }
                });

                $(document).on('click', '.removeAll', function() {
                    let ids = [];
                    $('.checkbox:checked').each(function(i) {
                        ids[i] = $(this).val();
                    });
                    if (ids.length <= 0) {
                        $('.removeAll').prop('disabled', true);
                    }
                    if ($('.removeAll').prop('disabled') == false) {
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
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    type: "DELETE",
                                    url: "{{ route('post-bulkDelete') }}",
                                    data: {
                                        ids: ids
                                    },
                                    success: function(data) {
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 500);
                                        // $('#data-table').DataTable().ajax.reload();
                                    },
                                    error: function(data) {

                                    }
                                })
                            }
                        });
                    }

                });

            })
        </script>
    @endpush
</x-admin.master>
