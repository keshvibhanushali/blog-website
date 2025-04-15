<form id="edit-cat-form">
    <div class="modal-body">
        <div class="form-group">
            <input type="hidden" value="{{$category->id}}" id="cat_id">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" value="{{$category->name}}">
            <div id="name-err" class="text-danger"></div>
        </div>

        <label for="status">Status</label>
        <select id="status" class="form-control form-control">
        <option value="">Select status</option>
            <option value="Active" {{$category->status == "Active" ? "selected" : ""}}>Active</option>
            <option value="Inactive" {{$category->status == "Inactive" ? "selected" : ""}}>InActive</option>
        </select>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>