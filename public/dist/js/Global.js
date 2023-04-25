


function LoadingOverlay(action,divID){

    var loading = $(divID).show();
        addClass = $(loading).append("<i class='fa fa-spinner fa-spin'></i>");
        addStyle = $(loading).attr('style');

        loading = $(addStyle).append('display: none;');

    if (!action) {
        loading = $(divID).hide();
        $('.fa-spin').remove();
    }

    return loading;
}
