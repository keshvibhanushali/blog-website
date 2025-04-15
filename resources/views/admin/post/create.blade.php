<x-admin.master>
    <form action="postcreate" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp"
                placeholder="Enter Title">
        </div>
        <div class="form-group">
            <label for="excerpt">Excerpt</label>
            <input type="text" class="form-control" id="excerpt" name="excerpt" placeholder="Enter excerpt">
        </div>
        <div class="form-group">
            <label for="excerpt">Description</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div class="form-group">
            <label for="thumbnail">Image</label>
            <input type="file" class="form-control dropify" id="thumbnail" name="thumbnail">
        </div>

        <div class="mb-2 row">
            <div class="col">
                <label for="category_id" class="font-extrabold">Category:</label>
                <select id="category_id" name="category_id" class="form-control form-control-lg ">
                    @foreach ($category as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#description').summernote({
                    placeholder: 'Enter Description',
                    tabsize: 2,
                    height: 100
                });

                $('.dropify').dropify({
                    messages: {
                        'default': 'Drag and drop a file here or click',
                        'replace': 'Drag and drop or click to replace',
                        'remove': 'Remove',
                        'error': 'Ooops, something wrong happended.'
                    }
                })
            });
        </script>
    @endpush
</x-admin.master>
