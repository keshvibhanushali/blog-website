
@if (session()->has('success'))
<script>
    ShowToaster('success',"{{ __('Success') }}","{{session()->get('success')}}");
</script> 
@endif

@if (session()->has('error'))
<script>
    ShowToaster('error',"{{ __('Error') }}","{{session()->get('error')}}");
</script> 
@endif
