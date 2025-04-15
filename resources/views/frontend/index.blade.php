<x-frontend.master>

    <section id="trending-category" class="trending-category section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-12">
                        @foreach ($posts as $post)
                        {{-- {{ $postid->pivot->post_id }} --}}
                        <div class="mb-3 card text-dark bg-light">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="text-center card-header"> {{ $post->category->name }}
                                </div>
                                <div class="card-body">
                                    <h5 class="text-center card-title title">
                                        {{ $post->title }}
                                    </h5>
                                    <p class="text-center card-text"> {{ $post->excerpt }}</p>
                                </div>
                            </a>
                            <div class="likes">
                              
                            @auth
                                @if($post->favouritedByUser->map(fn($fav) => $fav->pivot->user_id == Auth::id() && $fav->pivot->post_id == $post->id)->first())
                                <button type="submit" data-post-id="{{ $post->id }}" class="like"><i
                                        class="bi bi-heart-fill"></i>
                                </button>
                                @else
                                <button type="submit" data-post-id="{{ $post->id }}" class="like"><i
                                        class="bi bi-heart"></i>
                                </button>
                                @endif
                            @endauth
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{ $posts->links() }}
                <div class="col-lg-2"></div>
            </div>

    </section>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".like", function(e) {

                e.preventDefault();
                $(this).children().toggleClass('bi bi-heart-fill').toggleClass('bi bi-heart');

                let url = "{{ route('post.like')}}";

                let postid = $(this).attr('data-post-id');


                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: url,
                    data: {
                        'postid': postid,
                    },
                    success: function() {},
                    error: function() {}
                });

            });
        });
    </script>
    @endpush
</x-frontend.master>