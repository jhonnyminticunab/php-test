$(document).on("click",".dr_ad", function () {
    $("#form_new_item")[0].reset();
});


$(document).on("click", "#btn_new_expense", function () {
    if ( $("#txt_save_exp").val() != "" ) { $("#form_new_item").submit(); }
    else{ toastr.error("Debe ingresar algun nombre del gasto para crearlo ¡Ingreselo para continuar!"); }
});

$(document).on("click", "#btn_expense", function () {
    switch ( required('expense','Campo obligatorio') ) {
        case 'ok': $("#form_expense").submit(); break
    }
});
$(document).on("click", ".del_expense", function () {
    Swal.fire({
        title: "¿Va a eliminar este vale?",
        html: 'Si lo quiere eliminar de click en <b class="text-primary">"Si, Eliminar!"</b>, en caso contrario de click en <b>"No, Cancelar!"</b>',
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Eliminar!",
        cancelButtonText: "No, Cancelar!",
    }).then((result) => {
        if (result.value) {
            $("#delete_expense input[name='delete']").val( $(this).attr("idr") );
            $("#delete_expense").submit();
        }
    });
});

$(document).on("click", ".ch_sta_pro", function () {
    var btn = $(this); var sta = $(this).attr("sta");
    $.post( url+"ajax/general.ajax.php", { status: $(this).attr("idr"), value:sta, position:"tags" }, function (reply) {
        switch( reply ){
            case "ok": switch_btn_txt( btn, sta );
                break;
            default: toastr.error("No se cambio el estado, intente de nuevo o comuíquese con el administrador"); break
        }
    });
});
