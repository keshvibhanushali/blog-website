<x-admin.master>

    <div class="card">
        <div class="card-header">
            <button id="add_user" class="btn btn-primary">Add user</button>
            <div>
                <button class="mt-2 btn btn-danger removeAll " disabled>Delete Selected Data</button>
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

            $(document).on("click", "#add_user", function() {
                $.ajax({
                    type: "GET",
                    url: "{{route('user-create')}}",
                    success: function(response) {
                        $('#modal').modal("show");
                        $('.modal-title').text("Add User");
                        $(".modal-body").html(response);
                    }
                });
            });

            $(document).on('click', '.delete-handler', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                let url = '{{route("delete-user","/id")}}';
                url = url.replace('/id', id);
                // console.log(url);
                // retur
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


            //Create user
            $(document).on("submit", "#create-user-form", function(e) {
                e.preventDefault();
                let data = {
                    "name": $('#name').val(),
                    "email": $('#email').val(),
                    "dob": $('#dob').val(),
                };

                if (data.name == '') {
                    $('#create-user-form #name-err').text(
                        "Name filed is required"
                    )
                }

                if (data.email == '') {
                    $('#create-user-form #email-err').text(
                        "Email filed is required"
                    )
                } else {
                    let emailFormat = $('#email').val();
                    let reg = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
                    if (!reg.test(emailFormat)) {
                        $('#create-user-form #email-err').text(
                            "Email format is invalid")
                    }

                }

                if (data.dob == "") {
                    $('#create-user-form #dob-err').text(
                        "dob format is invalid")
                }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{route('add-user')}}",
                    data: data,
                    success: function(data) {
                        $('#modal').modal('hide');
                        $('#data-table').DataTable().ajax.reload();
                    },
                    error: function() {}
                });
            });

            //Update user

            $(document).on("click", "#edit-btn", function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                let url = '{{route("edit-user","/id")}}';
                url = url.replace('/id', id);
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        $('#modal').modal("show");
                        $('.modal-title').text("Edit User");
                        $(".modal-body").html(response);
                    }
                });
            });


            $(document).on("submit", "#edit-user-form", function(e) {
                e.preventDefault();
                let data = {
                    "name": $('#name').val(),
                    "email": $('#email').val(),
                    "dob": $('#dob').val(),
                };

                if (data.name == '') {
                    $('#edit-user-form #name-err').text(
                        "Name filed is required"
                    )
                }

                if (data.email == '') {
                    $('#edit-user-form #email-err').text(
                        "Email filed is required"
                    )
                } else {
                    let emailFormat = $('#email').val();
                    let reg = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
                    if (!reg.test(emailFormat)) {
                        $('#edit-user-form #email-err').text(
                            "Email format is invalid")
                    }

                }

                if (data.dob == "") {
                    $('#edit-user-form #dob-err').text(
                        "dob format is invalid")
                }

                let id = $('#user_id').val();
                let url = '{{route("update-user","/id")}}';
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

            $(document).on('change', '.mainCheckbox', function() {
                // console.log('object');
                let ids = [];
                $('.checkbox').each(function(i) {
                    if ($(this).is(":checked")) {
                        ids[i] = $(this).val();
                    }
                });
                // console.log(ids);
                if(ids.length<=0){
                    toastr.error('error');
                }

                if ($(this).is(':checked', true)) {
                    $('.removeAll').removeAttr('disabled');
                    $('.checkbox').prop('checked', true);
                } else {
                    $('.removeAll').prop('disabled',true);
                    $('.checkbox').prop('checked', false);
                }
            });

            $(document).on('change','.checkbox',function(){
                
                let ids = [];
                $('.checkbox:checked').each(function(i) {
                    ids[i] = $(this).val();
                });
                if(ids.length<=0){
                    $('.removeAll').prop('disabled',true);
                }
                else{
                    $('.removeAll').removeAttr('disabled');
                }
            })

            //bulk delete
            $(document).on('click', '.removeAll', function() {
                let ids = [];
                $('.checkbox:checked').each(function(i) {
                    ids[i] = $('.checkbox').val();
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
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: "DELETE",
                                url: "{{route('user-bulkDelete')}}",
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
        });
    </script>
    @endpush

</x-admin.master>