// click
$(document).on("click", "#btn_search_day",function () {
   window.location =  url+"close-day/" + $("#date_close_day").val() +"/"+ $("#sel_users").val();
});

$(document).on("click", ".detailed", function () {
    var idr = $(this).parent().attr("idr"), typ = $(this).parent().attr("typ");
    $.post( url+"ajax/general.ajax.php", { detailed:idr, position:typ }, function (data) {

        switch ( typ ) {
            case "exchanges":
                $prod = JSON.parse( data.in_products, true); head =
                    '<th>Producto</th>'+
                    '<th>Precio</th>'+
                    '<th>Cant</th>'+
                    '<th>Subtotal</th>';
                $("#tbl_detailed_prod thead").html(head);
                tbl = [];
                $.each( $prod, function (i,item) {
                    tbl[i] =
                        '<tr>' +
                        '<td class="text-left">'+item.product+'</td>' +
                        '<td class="text-right">'+format_number(item.price)+'</td>' +
                        '<td class="text-center">'+item.cant+'</td>' +
                        '<td class="text-right">'+format_number(item.cant*item.price)+'</td>' +
                        '</tr>';
                });
                $("#tbl_detailed_prod tbody").html(tbl); $("#txt_in").text("Entradas");

                $prod = JSON.parse( data.out_products, true); head =
                '<th>Producto</th>'+
                '<th>Precio</th>'+
                '<th>Cant</th>'+
                '<th>Subtotal</th>';
                $("#tbl_detailed_out thead").html(head);
                tbl = [];
                $.each( $prod, function (i,item) {
                    tbl[i] =
                        '<tr>' +
                        '<td class="text-left">'+item.product+'</td>' +
                        '<td class="text-right">'+format_number(item.price)+'</td>' +
                        '<td class="text-center">'+item.cant+'</td>' +
                        '<td class="text-right">'+format_number(item.cant*item.price)+'</td>' +
                        '</tr>';
                });
                $("#tbl_detailed_out tbody").html(tbl); $("#txt_out").text("Salidas");
                text = "Detalle Cambio y/o devolución"; break;
            default:
                $prod = JSON.parse( data.products, true); head =
                    '<th>Producto</th>'+
                    '<th>Precio</th>'+
                    '<th>Iva</th>'+
                    '<th>Cant</th>'+
                    '<th>Subtotal</th>';
                $("#tbl_detailed_prod thead").html(head);
                tbl = [];
                $.each( $prod, function (i,item) {
                    tbl[i] =
                        '<tr>' +
                        '<td class="text-left">'+item.product+'</td>' +
                        '<td class="text-right">'+format_number(item.price)+'</td>' +
                        '<td class="text-center">'+item.tax*100+'%</td>' +
                        '<td class="text-center">'+item.cant+'</td>' +
                        '<td class="text-right">'+format_number(item.cant*item.price)+'</td>' +
                        '</tr>';
                });
                $("#tbl_detailed_prod tbody").html(tbl);
                typ == "sale" ? text = "Detalle factura" : text = "Detalle prospecto" ; break;

        }



        $("#title_detailed").text(text);
        $("#modal_detailed").modal("show");
    },"json");
});

$(document).on("click", ".download",function () {
    var typ = $(this).closest('tr').attr("typ"), idr = $(this).attr("idr"), idc = $(this).attr("idc");
    switch ( typ ) {
        case "exchanges": window.location = url + "exchanges/print/"+idr+"/"+idc+"/none"; break;
        case "payment": window.location = url + "credit/print/"+idr+"/"+idc+"/none"; break;
        default: window.location = url + "sales/print/"+idr+"/"+idc+"/none"; break;
    }
});

$(document).on("click", ".delete",function () {
    var typ = $(this).closest('tr').attr("typ"), idr = $(this).attr("idr");
    typ == "prospectus" ? set = "status_sale" : set = "status";
    switch ( typ ) {
        case "sale":
            Swal.fire({
                title: '¿Quiere eliminar la factura "'+$(this).attr("sal")+'" de "'+$(this).attr("cus")+'" ?',
                html:'Recuerde que al dar click en "Si, Eliminar!" <b>hara una Nota Crédito</b> y no podra reversar dicha Nota, en caso contrario de clic en "No, Regresar!"',
                icon: 'warning', showCancelButton: true, confirmButtonText: 'Si, Eliminar!', confirmButtonColor: '#566573', cancelButtonText: 'No, Regresar!', cancelButtonColor: '#C0392B',
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Va a hacer una nota credito...',
                        html:'<b>¿Esta seguro que debe hacer la nota crédito y asi eliminar la factura?</b> Recuerde que al dar click en "Si, Nota Credito!" no podra reversar dicha Nota, en caso contrario de clic en "No, Regresar!"<hr>' +
                            '<b>Motivo:</b>',
                        input: 'text', inputPlaceholder: '¿Porque debe eliminar esta factura?', icon: 'warning',
                        showCancelButton: true, confirmButtonText: 'Si, Nota Credito!', confirmButtonColor: '#808B96', cancelButtonText: 'No, Regresar!', cancelButtonColor: '#E74C3C',
                    }).then((result) => {
                        if ( result.value ) {
                            $(".loader").fadeIn("slow");
                            $('#form_delete input[name="case"]').val( typ );
                            $('#form_delete input[name="case_id"]').val( idr );
                            $('#form_delete input[name="motive_cn"]').val( result.value );
                            $("#form_delete").submit();
                        }else if ( result.value == '' ){
                            Swal.fire('','Debe ingresar el motivo por el cual va a eliminar esta factura','error');
                        }
                    });
                }
            }); break;
        case "exchanges":
            Swal.fire({
                title: '¿Quiere eliminar el cambio "'+$(this).attr("sal")+'" de "'+$(this).attr("cus")+'" ?',
                html:'Recuerde que al dar click en "Si, Eliminar!" no podra reversar dicha elimincación, en caso contrario de clic en "No, Regresar!"',
                icon: 'warning', showCancelButton: true, confirmButtonText: 'Si, Eliminar!', confirmButtonColor: '#566573', cancelButtonText: 'No, Regresar!', cancelButtonColor: '#C0392B',
            }).then((result) => {
                if (result.value) {
                    $(".loader").fadeIn("slow");
                    $('#form_delete input[name="case"]').val(typ);
                    $('#form_delete input[name="case_id"]').val(idr);
                    $("#form_delete").submit();
                }
            }); break;
        case "prospectus":
            Swal.fire({
                title: '¿Quiere eliminar la remision "'+$(this).attr("sal")+'" de "'+$(this).attr("cus")+'" ?',
                html:'Recuerde que al dar click en "Si, Eliminar!" no podra reversar dicha elimincación, en caso contrario de clic en "No, Regresar!"',
                icon: 'warning', showCancelButton: true, confirmButtonText: 'Si, Eliminar!', confirmButtonColor: '#566573', cancelButtonText: 'No, Regresar!', cancelButtonColor: '#C0392B',
            }).then((result) => {
                if (result.value) {
                    $(".loader").fadeIn("slow");
                    $('#form_delete input[name="case"]').val(typ);
                    $('#form_delete input[name="case_id"]').val(idr);
                    $("#form_delete").submit();
                }
            }); break;
        default:
            Swal.fire({
                title: '¿Quiere eliminar el registro?',
                html:'Recuerde que al dar click en "Si, Eliminar!" no podra recuperarlo, en caso contrario de clic en "No, Regresar!"',
                icon: 'warning', showCancelButton: true, confirmButtonText: 'Si, Eliminar!', confirmButtonColor: '#566573', cancelButtonText: 'No, Regresar!', cancelButtonColor: '#C0392B',
            }).then((result) => { if (result.value) { delete_row(idr,typ, set); } });
    }

});

$(document).on("click", ".resend",function () {
    $("#form_resend input[name='resend']").val( $(this).attr("idr") );
    $("#form_resend").submit();
    setTimeout( function () {
        var site = $(location).attr('href');
        window.location = site;
    },5000)
});



function delete_row( idr, position, set ) {
    $.post( url+"ajax/general.ajax.php", { delete:idr, value:0, position:position, set:set }, function (reply) {
        switch ( reply ) {
            case "ok": location.reload(); break;
            case "error": toastr.error("Ocurrio un error, intente de nuevo o comuníquese con el administrador"); break;
        }
    });
}