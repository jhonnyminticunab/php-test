var name = "clientes";

$(document).on("change", ".updateGroup", function () {
   $.post( url+"ajax/general.ajax.php", { update:$(this).attr("idr"), set:"pri", position:"customer", value:this.value }, function (reply) {
        switch ( reply ) {
            case "ok": toastr.success("Cambio realizado"); break;
            default: toastr.error("Ocurrio un error, intente de nuvo o comuníquese con el administrador"); break;
        }
   })
});
$(document).on("click",".btn_status_customer",function () {
    var btn = $(this), sta = $(this).attr("sta");
    $.post( url+"ajax/general.ajax.php", { status:$(this).attr("idr"), value:sta, position:"customer" }, function (reply) {
        if( reply == 'ok'){ switch_btn( btn, sta ); }else{ error_msg(); }
    });
});