<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Profile</title>
    <x-frontend.css />
</head>
<x-frontend.header />

<body>
    @foreach ($posts as $post)
    <div class="d-flex justify-content-center mt-4">
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $post->title }}
                </h5>
                <p class="card-text">{{ $post->description }}</p>
            </div>
            <div class="card-footer">
                <p><b>Posted by : </b> <a href="/post/user/{{ $post->user_id }}">{{ $post->user?->name }} </a>
                    <b>at</b>
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>
    @endforeach

</body>

</html>