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

    <section class="vh-100" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-md-9 col-lg-7 col-xl-5">
                    <div class="card" style="border-radius: 15px; background-color: #93e2bb;">
                        <div class="p-4 text-black card-body">

                            <div class="mb-4 d-flex align-items-center">

                                <div class="flex-grow-1 ms-3">
                                    <div class="flex-row mb-2 d-flex align-items-center">
                                        <p class="mb-0 me-2">Name: {{ $user->name }}</p>
                                    </div>

                                    <div class="flex-row mb-2 d-flex align-items-center">
                                        <p class="mb-0 me-2">Email: {{ $user->email }}</p>
                                    </div>

                                    <a href="{{route('profile.posts')}}">
                                        <button class="bg-primary text-white" id="favourites">Liked Posts
                                        </button>
                                    </a>
                                   
                                </div>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-frontend.script>
    @push('scripts')
    <script>
        console.log("helo")
    </script>
    @endpush
    </x-frontend.script>
</body>

</html>