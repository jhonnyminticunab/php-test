var name = "productos";

$(document).on("click",".btn_status_product",function () {
    var btn = $(this), sta = $(this).attr("sta");
    $.post( url+"ajax/general.ajax.php", { status:$(this).attr("idr"), value:sta, position:"`references`" }, function (reply) {
        if( reply == 'ok'){ switch_btn( btn, sta ); }else{ error_msg(); }
    });
});
$(document).on("click",".btn_edit_product",function () {
    $.post( url+"ajax/general.ajax.php", { detailed:$(this).attr("idr"), position:"`references`" }, function (reply) {
        $("#form_products input[name='id']").val( reply['id'] );
        $("#form_products input[name='ref']").val( reply['ref'] );
        $("#form_products input[name='cod']").val( reply['cod'] );
        $("#form_products textarea[name='product']").val( reply['product'] );
        $("#form_products input[name='size']").val( reply['size'] );
        $("#form_products input[name='price1']").val( format_number( reply['price1'] ) );
        $("#form_products input[name='price2']").val( format_number( reply['price2'] ) );
        $("#form_products input[name='price3']").val( format_number( reply['price3'] ) );
        $("#form_products input[name='tax']").val( reply['tax'] * 100 );
        $("#modal_product").modal("show");
    },"json");
});
$(document).on("click","#btn_update_product",function () {
    switch ( required( "required" ) ) { case 'ok': $("#form_products").submit();; break; }
});
$(document).on("click","#btn_new_product",function () {

    if( $("#form_new_product input[name='new_ref']").val() != "" && $("#form_new_product input[name='new_name']").val() != "" ) {

        $("#form_new_product").submit();

    }else{
        toastr.error("Todos los campos son obligatorios, por favor verifíque y llene los faltantes para continuar...");
    }

});


