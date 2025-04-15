<form id="edit-user-form">
    <div class="modal-body">
        <div class="form-group">
            <input type="hidden" value="{{$user->id}}" id="user_id">
            <label for="name">Name</label>
            <input type="name" class="form-control" id="name" placeholder="Enter name" value="{{$user->name}}">
            <div id="name-err" class="text-danger"></div>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" value="{{$user->email}}">
            <div id="email-err" class="text-danger"></div>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" class="form-control" id="dob" value="{{$user->dob}}">
            <div id="dob-err" class="text-danger"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
</div>
</div>