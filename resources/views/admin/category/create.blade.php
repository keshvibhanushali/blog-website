<form id="create-cat-form">
    <div class="modal-body">
        <div class="form-group">
            <label for="title">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name">
            <div id="title-err" class="text-danger"></div>
            <div id="name-err" class="text-danger"></div>
        </div>

        <label for="status">Status</label>
        <select id="status" class="form-control form-control">
            <option value="Active">Active</option>
            <option value="Inactive">InActive</option>
        </select>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>