<x-frontend.master>
    <div class="text-center card">
        <div class="card-header">
            <a href="/post/category/{{ $post->category_id }}">
                {{ $post->category->name }}
            </a>
        </div>
        <div class="card-body">
            {{-- <p>hello</p> --}}
            <img src="{{ asset('storage/' . $post->thumbnail) }}" height="100" alt="post image">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->description }}</p>
        </div>
        <div class="card-footer">
            <p><b>Posted by : </b> <a href="/post/user/{{ $post->user_id }}">{{ $post->user?->name }} </a>
                <b>at</b>
                {{ $post->created_at->diffForHumans() }}
            </p>
        </div>
    </div>
</x-frontend.master>
