<x-admin.master>
    <div class="container">
        <div class="accordion" id="accordionExample">
            <div class="card">
                @foreach ($roles as $role)
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" id="data_{{$role->id}}" type="button" data-toggle="collapse" data-target="#collapseOne{{$role->id}}" aria-expanded="false" aria-controls="collapseOne" data-id="{{$role->id}}">
                            {{$role->name}}
                        </button>
                    </h2>
                </div>
                <div id="collapseOne{{$role->id}}" class="collapse ml-4" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <input type="checkbox" class="mt-3 checkAll_{{$role->id}} checkAll" name="checkall" id="{{$role->id}}">
                    <label for="checkall">Check All</label>
                    @foreach ($permissions as $key=>$permission)
                    <p>{{$key}}</p>
                    @foreach ($permission as $per)
                    <input type="checkbox" class="checkboxes_{{$role->name}} checkboxes" data-id="{{$role->id}}" name="check" value="{{$per->name}}" id="{{$per->id}}" {{($role->hasPermissionTo($per->name)) ? 'checked' : ''}}>
                    <label for="{{$per->name}}">{{$per->name}}</label>
                    @endforeach
                    @endforeach
                    <div>
                        <button id="{{$role->id}}" class="btn btn-success submit-btn" type="submit">submit</button>
                    </div>
                </div>
                @endforeach
            </div>

        </div>



        @push('scripts')
        <script>
            $(document).ready(function() {

               
                $('.checkAll_1').on('click', function() {

                    if ($(this).is(':checked', true)) {
                        $('.checkboxes_admin').prop('checked', true);
                    } else {
                        $('.checkboxes_admin').prop('checked', false);
                    }
                });

                $('.checkAll_2').on('click', function() {
                    if ($(this).is(':checked', true)) {
                        $('.checkboxes_author').prop('checked', true);
                    } else {
                        $('.checkboxes_author').prop('checked', false);
                    }
                });

                $('.checkAll_3').on('click', function() {
                    if ($(this).is(':checked', true)) {
                        $('.checkboxes_reader').prop('checked', true);
                    } else {
                        $('.checkboxes_reader').prop('checked', false);
                    }
                });

                $('.submit-btn').on('click', function() {
                    let role = $(this).attr('id');
                    let id = [];
                    $(`input:checkbox[data-id=${role}]`).each(function(i) {
                        if ($(this).is(':checked')) {
                            id[i] = $(this).val();
                        }
                    });
                    let url = "{{route('admin.permission.update','/id')}}";
                    url = url.replace('/id', role);

                    // $(`input:checkbox[data-id=${role}]`).each(function() {
                    //     let i;
                    //     if ($(this).is(':checked')) {
                    //        i++; 
                    //     }
                    //     console.log(i);
                    // });

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: url,
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            toastr.success("Data updated successfully");
                            setTimeout(() => {
                                window.location.reload();
                            }, 700);
                        },
                        error: function(data) {

                        }
                    });
                })
            });
        </script>
        @endpush
    </div>
</x-admin.master>