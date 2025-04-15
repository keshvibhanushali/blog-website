<x-admin.master>
  <form action="{{url('/postupdate/update/'.$post->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="title">Title</label>
      <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" placeholder="Enter Title" value="{{$post->title}}">
    </div>
    <div class="form-group">
      <label for="excerpt">Excerpt</label>
      <input type="text" class="form-control" id="excerpt" name="excerpt" placeholder="Enter excerpt" value="{{$post->excerpt}}">
    </div>
    <div class="form-group">
      <div class="form-group">
        <label for="excerpt">Description</label>
        <textarea name="description" id="description">{{$post->description}}</textarea>
      </div>
    </div>
    <!-- Current Image:
  <img src="{{ asset('storage/'.$post->thumbnail) }}" class="card" alt="No image" width="80" height="60"> -->
    <div class="form-group">
      <label for="thumbnail">Image</label>
      <input type="hidden" name="old_thumbnail" value="{{$post->thumbnail}}">
      <input type="file" class="form-control dropify" id="thumbnail" name="thumbnail" data-default-file="{{ asset('storage/'.$post->thumbnail) }}">
    </div>
    <div class="row mb-2">
            <div class="col">
                <label for="category_id" class="font-extrabold">Category:</label>
                <select id="category_id" name="category_id" class="form-control form-control-lg " >
                    @foreach ($category as $cat)
                        <option value="{{$cat->id}}" {{$cat->id == $post->category_id ? "selected" : ""}}>{{$cat->name}}</option>
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
    })

    $('.dropify').dropify({
      messages: {
        'default': 'Drag and drop a file here or click',
        'replace': 'Drag and drop or click to replace',
        'remove': 'Remove',
        'error': 'Ooops, something wrong happended.'
      }
    });
  </script>
  @endpush
</x-admin.master>