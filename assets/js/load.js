var ref = [ "idr", "ref", "product" ];

switch ( permits ) {
    case "error": $("#msg").remove(); $("#page").remove(); break;
    case "denied": $("#page").remove(); break;
    default: $("#msg").remove(); break;
}

if (!localStorage.getItem("selected")) {
    $.post(url + "ajax/general.ajax.php", {all: "`references`", filter: "status = 1"}, function (data) {
        selector_item("", "sel_selected_ref", ref, "product", "");
        create_tbl( data, "empty" );
        $("#form_load input[name='load']").val(  tbl_selected('tbl_selected_products','sel', ref)  );
        localStorage.setItem("selected", tbl_selected('tbl_selected_products','sel', ref) );
        localStorage.setItem("available", "[]");
    }, "json");
} else {
    selector_item( JSON.parse(localStorage.getItem("available")), "sel_selected_ref", ref, "product", "");
    create_tbl( JSON.parse( localStorage.getItem("selected") ), "full" );
    $("#form_load input[name='load']").val(  tbl_selected('tbl_selected_products','sel', ref)  );
}

$(document).on("click", "#cleanData", function () {
    clear_localstorage();
    $("#tbl_selected_products tbody").empty();
    $("#form_load input[name='load']").val('');
    $.post(url + "ajax/general.ajax.php", {all: "`references`", filter: "status = 1"}, function (data) {
        localStorage.setItem("available",  item_push( data, ref ) );
        selector_item( JSON.parse(localStorage.getItem("available")), "sel_selected_ref", ref, "product", "");
    }, "json");
});

$(document).on("click", ".btn_del_prod", function () {
    $available = JSON.parse( localStorage.getItem("available") );
    ( $available == "" ) ? data = [] : data = $available;
    data.push({
        idr: $(this).attr('idr'),
        ref: $(this).attr('ref'),
        product: $(this).attr('product')
    });
    localStorage.setItem("available", JSON.stringify( data ) );
    $(this).closest('tr').remove();
    $("#form_load input[name='load']").val(  tbl_selected('tbl_selected_products','sel', ref)  );
    localStorage.setItem("selected",  $("#form_load input[name='load']").val( )  );
    selector_item( JSON.parse(localStorage.getItem("available")), "sel_selected_ref", ref, "product", "");
});
$(document).on("change", "#sel_selected_ref", function () {
    idr_sel = $(this).find('option:selected').attr("idr");
    ref_sel = $(this).find('option:selected').attr("ref");
    product_sel = $(this).find('option:selected').attr("product");
    prod=
        '<tr>' +
        '<td>'+product_sel+'</td>' +
        '<td class="sel text-center"> <input class="cant can_load text-center" idr="'+idr_sel+'" ref="'+ref_sel+'" product="'+product_sel+'" value="0" /> </td>' +
        '<td> <i class="far fa-trash-alt text-danger hand btn_del_prod" idr="'+idr_sel+'" ref="'+ref_sel+'" product="'+product_sel+'"></i> </td>' +
        '<tr>'
    ;
    $("#tbl_selected_products tbody").append( prod );
    localStorage.setItem("selected", tbl_selected('tbl_selected_products','sel', ref) );
    localStorage.setItem("available", update_selected( localStorage.getItem("available") , localStorage.getItem("selected") ) );
    selector_item( JSON.parse(localStorage.getItem("available")), "sel_selected_ref", ref, "product", "");
    $("#form_load input[name='load']").val(  tbl_selected('tbl_selected_products','sel', ref)  );

});
$(document).on("change", ".can_load", function () {
    setTimeout( function () {
        localStorage.setItem("selected", tbl_selected('tbl_selected_products','sel', ref) );
        $("#form_load input[name='load']").val(  tbl_selected('tbl_selected_products','sel', ref)  );
    },50)
});
$(document).on("click", "#btn_save_load", function () {

    response = "ok";
    $("#tbl_selected_products .sel input").each(function (r) {
        if( $(this).val() == 0 || $(this).val() == "") { response = "alert"; }
    });

    switch ( response ) {
        case "ok": $("#form_load").submit(); break;
        case "alert": toastr.error('Algun producto esta en "0" o en "blanco", corrijalo para cargar'); break;
    }

});

$(document).on("change", ".can_update", function () {
    idl = $(this).attr("idl");
    loa = tbl_selected('tbl_update_products'+idl,'sel', ref);
    $.post( url+"ajax/general.ajax.php", {id:idl, field:"loads", text:loa, direction:"loads"}, function (reply) {
        switch ( reply) {
            case "ok":break;
            default: toastr.error("Ocurrio un error, intente de nuevo o cominíquese con el administrador ("+reply+")"); break;
        }
    });
});
$(document).on("click", ".btn_del_prod_update", function () {
    idl = $(this).attr("idl");
    $(this).closest('tr').remove();
    loa = tbl_selected('tbl_update_products'+idl,'sel', ref);
    $.post( url+"ajax/general.ajax.php", {id:idl, field:"loads", text:loa, direction:"loads"}, function (reply) {
        switch ( reply) {
            case "ok":break;
            default: toastr.error("Ocurrio un error, intente de nuevo o cominíquese con el administrador ("+reply+")"); break;
        }
    });
});
$(document).on("click", ".delete_load", function () {
    Swal.fire({
        title: "¿Va a eliminar este cargue?",
        html: 'Si esta seguro de eliminar el cargue de click en <b class="text-primary">"Si, Eliminar"</b>, en caso contrario de click en <b class="text-gray">"No, Regresar"</b>...',
        icon: "warning", showCancelButton: true, confirmButtonText: "Si, Eliminar!", cancelButtonText: "No, Regresar!",
    }).then((result) => {
        if (result.value) { $.post( url+"ajax/general.ajax.php", { status:$(this).attr("idl"), value:"0", position:"loads" }, function (reply) {
            switch ( reply ) {
                case "ok": location.reload(); break;
                default: toastr.error("Ocurrio un error, intente de nuevo o comuníquese con el administrador ("+reply+")"); break;
            }
        }); }
    });
});
$(document).on("click", ".activate_load", function () {
    idl = $(this).attr("idl");
    Swal.fire({
        title: "¿Va a activar este cargue para poder vender?",
        html: 'Si esta seguro que el cargue esta correcto de click en <b class="text-primary">"Si, Activar"</b>, en caso contrario de click en <b class="text-gray">"No, Regresar"</b> y ajuste lo que esta mal para poder vender...',
        icon: "warning", showCancelButton: true, confirmButtonText: "Si, Activar!", cancelButtonText: "No, Regresar!",
    }).then((result) => {
        if (result.value) { $.post( url+"ajax/general.ajax.php", { load_active:idl }, function (reply) {
            switch ( reply ) {
                case 'ok': location.reload(); break;
                case 'inventories': toastr("¡No se actualizó el inventario! intente de nuevo o comuníquese con el administrador"); break;
                case 'activate': toastr("¡Se actualizó el inventario pero no se bloqueo el cargue! comuníquese con el administrador"); break;
            }
        }); }
    });
});



function create_tbl( selected, type ) {
    var prod = [];
    $.each( selected, function (i, data) {
        (type == "empty") ? idt = data.id : idt = data.idr;
        (data.cant) ? can = data.cant : can = 0;
        prod [i]=
            '<tr>' +
            '<td>'+data.product+'</td>' +
            '<td class="sel text-center"> <input class="cant can_load text-center" type="number" idr="'+idt+'" ref="'+data.ref+'" product="'+data.product+'" value="'+can+'" /> </td>' +
            '<td> <i class="far fa-trash-alt text-danger hand btn_del_prod" idr="'+idt+'" ref="'+data.ref+'" product="'+data.product+'"></i> </td>' +
            '<tr>'
        ;
    });
    $("#tbl_selected_products tbody").html( prod );
}