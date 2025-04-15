<x-frontend.master>
    @foreach ($postCategory as $post)
        <div class="text-center card">
            <div class="card-header">
                {{ $post->category->name }}
            </div>
            <div class="card-body">
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
    @endforeach
</x-frontend.master>
