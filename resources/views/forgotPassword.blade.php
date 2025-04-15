<x-admin.master>

    <form action="{{route('password.email')}}" method="post">
        @csrf
       
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
                
            </div>
        </div>

        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
        </div>
    </form>

   @push('scripts')
   <script>
     
    </script>
   @endpush
</x-admin.master>