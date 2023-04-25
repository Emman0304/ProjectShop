


function LoadingOverlay(action,divID){

    var loading = $(divID).show();
        $(loading).append("<i class='fa fa-spinner fa-spin'></i>");

    if (!action) {
        loading = $(divID).hide();
        $('.fa-spin').remove();
    }

    return loading;
}
