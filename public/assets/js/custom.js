function ShowToaster(type,title,body){
    $(document).Toasts('create', {
        title: title,
        body: body,
        // autohide:true,
    });
    console.log(type);
    if(type=='success'){
        $('#toastsContainerTopRight .toast-header,#toastsContainerTopRight .toast-body').removeClass('bg-danger')
        .addClass('bg-success')
    }
    else {
        $('#toastsContainerTopRight .toast-header,#toastsContainerTopRight .toast-body').removeClass('bg-success').addClass('bg-danger')
    }
}