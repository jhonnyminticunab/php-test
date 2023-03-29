// general
$("#provider_shopping").select2({
    ajax: {
        url: url+"ajax/shopping.ajax.php",
        dataType: "json"
    },
    theme:"bootstrap4",
    placeholder: "Seleccionar distribuidor para comprar...",
    language: {
        errorLoading: function() { return "Realice busqueda del distribuidor..."; },
        noResults: function() { return "No hay resultados..."; },
        searching: function() { return "Buscando.."; }
    }
});
var tbl_ref_shopping = $("#table_products").DataTable();
$("#form_provider input[name='phone']").inputmask();
$("#form_provider input[name='other']").inputmask();

// click
$(document).on("click", ".add_product_shopping", function () {

    tbl_ref_shopping.row( $(this).parents("tr") ).remove().draw();

    var prod =
        "<tr>" +
        "<td hidden>"+ $(this).attr("idr") +"</td>" +
        "<td>"+ $(this).attr("ref") +"</td>" +
        "<td>"+ $(this).attr("pro") +" #"+ $(this).attr("sto") +"</td>" +
        "<td class='properties'><input class='lot' /></td>" +
        "<td class='properties'><input class='ven' type='date' /></td>" +
        "<td class='product_shopp'><input class='cant_shop' value='1' idr='"+$(this).attr("idr")+"' ref='"+$(this).attr("ref")+"' pro='"+$(this).attr("pro")+"' cos='"+$(this).attr("cos")+"' sto='"+$(this).attr("sto")+"' lot='' ven=''></td>" +
        "<td class='text-right sub"+$(this).attr("idr")+"'>"+format_number( $(this).attr("cos") )+"</td>" +
        "<td class='point' hidden><div class='spinner-grow text-danger'></div></td>" +
        "<td><i class='far fa-trash-alt text-danger selector btnDelProdShopp' idr='"+$(this).attr("idr")+"' ref='"+$(this).attr("ref")+"' pro='"+$(this).attr("pro")+"' cos='"+$(this).attr("cos")+"' sto='"+$(this).attr("sto")+"' ></i></td>" +
        "<tr>";

    $("#tblSelectProducts").append(prod);
    product_compilation_shoping();

});
$(document).on("click", "#shopping_btn_select_ref", function () {

    if(  $("#shopping_select_products").val() != "" ){

        var idr = $("#shopping_select_products option:selected").attr("idr");
        var ref = $("#shopping_select_products option:selected").attr("ref");
        var pro = $("#shopping_select_products option:selected").attr("pro");
        var sto = $("#shopping_select_products option:selected").attr("sto");
        var cos = $("#shopping_select_products option:selected").attr("cos");

        var prod =
            "<tr>" +
            "<td hidden>"+ idr +"</td>" +
            "<td>"+ ref +"</td>" +
            "<td>"+ pro +" #"+ sto +"</td>" +
            "<td class='properties'><input class='lot' /></td>" +
            "<td class='properties'><input class='ven' type='date' /></td>" +
            "<td class='product_shopp'><input class='cant_shop' value='1' idr='"+idr+"' ref='"+ref+"' pro='"+pro+"' cos='"+cos+"' sto='"+sto+"' lot='' ven=''></td>" +
            "<td class='text-right sub"+idr+"'>"+format_number( cos )+"</td>" +
            "<td class='point' hidden><div class='spinner-grow text-danger'></div></td>" +
            "<td><i class='far fa-trash-alt text-danger selector btnDelProdShopp' idr='"+idr+"' ref='"+ref+"' pro='"+pro+"' cos='"+cos+"' sto='"+sto+"' ></i></td>" +
            "<tr>";

        $("#tblSelectProducts").append(prod);

        $("#shopping_select_products option:selected").remove();

        product_compilation_shoping();

    }else { toastr.warning("No ha elegido producto para seleccionar, realicelo para continuar..."); }


});
$(document).on("click", ".btnDelProdShopp", function () {

    $(this).parent().parent().remove();

    var idr = $(this).attr("idr");
    var ref = $(this).attr("ref");
    var pro = $(this).attr("pro");
    var sto = $(this).attr("sto");
    var cos = $(this).attr("cos");
    var btn = '<button class="btn btn-outline-success btn-xs add_product_shopping" idr="'+idr+'" ref="'+ref+'" pro="'+pro+'" cos="'+cos+'" sto="'+sto+'" > <i class="fas fa-check-square"></i> </button> ';

    tbl_ref_shopping.row.add([ btn, ref, pro, cos, sto ]).draw( false );

    var select = '<option ref="'+ref+'" pro="'+pro+'" cos="'+cos+'" sto="'+sto+'">'+ref+'_'+pro+'_*'+sto+'</option>';
    $("#shopping_select_products").append( select );

    $("#dto_shopping").val(0);
    $("#cash_shopping").val(0);
    $("#card_shopping").val(0);

    product_compilation_shoping();

});
$(document).on("click", "#btn_save_shopping", function () {

    if( $("#shopping_products").val() != "" && $("#shopping_products").val() != "[]" ){

        switch ( required('required','Campo obligatorio') ) {
            case "ok":
                if( $("#validation_shopping").val() > 0 ){
                    Swal.fire({
                        title: "¿Esta compra es un CREDITO?",
                        text: "Si es un CREDITO de click en Continuar!, en caso contrario de click en Regresar y coloque el valor que hace falta para cancelar la compra...",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Si, Continuar!",
                        cancelButtonText: "No, Regresar!",
                        confirmButtonColor: "#f0ad4e",
                        cancelButtonColor: "#d33"

                    }).then((result) => {
                        if (result.value) {
                            $("#form_shopping").submit();
                        }
                    });
                }else{
                    Swal.fire({
                        title: "¿Esta compra es de CONTADO?",
                        text: 'Si es de "CONTADO" de clic en Continuar!, en caso contrario de clic en Regresar y modifique el valor pagado para que quede como CREDITO...',
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonText: "Si, Continuar!",
                        cancelButtonText: "No, Regresar!",
                        confirmButtonColor: "#5bc0de",
                        cancelButtonColor: "#d9534f"

                    }).then((result) => {
                        if (result.value) {
                            $("#form_shopping").submit();
                        }
                    });
                }
            break;
        }

    }else{
        toastr.warning("No ha elegido ningún producto para vender, seleccione alguno para guardar la venta...");
    }

});
$(document).on("click", "#show_new_provider", function () {

    $("#form_provider")[0].reset();

    if( $("#val_customer").val() != 1 ){
        $("#blq_customer").slideToggle();
    }

    if( $("#val_btn").val() != 1 ){
        $("#btn_update_new_provider, #btn_save_new_provider").slideToggle();
    }

    if( $("#val_blq").val() != 0 ){
        $("#blq_references, #blq_products").slideToggle();
    }

    $("#val_customer").val(1);
    $("#val_btn").val(1);
    $("#val_blq").val(0);

});
$(document).on("click", "#btn_save_new_provider", function () {

    if(
        $("#form_provider input[name='company']").val() != "" &&
        $("#form_provider input[name='vendor']").val() != "" &&
        $("#form_provider input[name='nit']").val() != "" &&
        $("#form_provider input[name='phone']").val() != "" &&
        $("#form_provider input[name='mail']").val() != "" /*&&
        $("#form_provider input[name='address']").val() != ""*/
    ){

        if( $("#form_provider input[name='mail']").val() != "" && !validate_mail( $("#form_provider input[name='mail']").val() ) ) {
            toastr.info('El correo electrónico que ingreso tiene un error, por favor corríjalo para continuar'); return;
        }

        if( $("#form_provider input[name='phone']").val() != "" && $("#form_provider input[name='phone']").val().indexOf("_") > -1 ){
            toastr.error('Numero de celular incompleto, ingreselo de forma correcta para continuar...'); return;
        }

        $("#form_provider").submit();

    }else{
        toastr.warning("Todos los datos con (*) son obligatorios, por favor ingreselos para crear el nuevo proveedor...");
    }

});
$(document).on("click", "#btn_update_new_provider", function () {

    if(
        $("#form_provider input[name='company']").val() != "" &&
        $("#form_provider input[name='vendor']").val() != "" &&
        $("#form_provider input[name='nit']").val() != "" &&
        $("#form_provider input[name='phone']").val() != "" &&
        $("#form_provider input[name='mail']").val() != "" /*&&
        $("#form_provider input[name='address']").val() != ""*/
    ){

        if( $("#form_provider input[name='mail']").val() != "" && !validate_mail( $("#form_provider input[name='mail']").val() ) ) {
            toastr.info('El correo electrónico que ingreso tiene un error, por favor corríjalo para continuar'); return;
        }

        if( $("#form_provider input[name='phone']").val() != "" && $("#form_provider input[name='phone']").val().indexOf("_") > -1 ){
            toastr.error('Numero de celular incompleto, ingreselo de forma correcta para continuar...'); return;
        }

        $("#form_provider").submit();

    }else{
        toastr.warning("Todos los datos con (*) son obligatorios, por favor ingreselos para crear el nuevo proveedor...");
    }

});


//change
$(document).on("change", "#provider_shopping", function () {

    $(".blocking, .spiner").fadeIn();
    var idp = $(this).val();

    setTimeout(function() {
        $.post( url+"ajax/shopping.ajax.php", { products:idp }, function (reply) {

            var tbl = []; var ref = [];
            $.each(reply, function (i, item) {
                ref[i] = '<option idr="'+item.data.id+'" ref="'+item.data.ref+'" pro="'+item.data.name+'" cos="'+item.data.cost+'" sto="'+item.data.sto+'" pvi="'+item.data.provider+'" >'+item.data.ref+'_'+item.data.name+'_*'+item.data.sto+'</option>';
                tbl[i] =
                    "<tr>" +
                    "<td>"+item.btn+"</td>"+
                    "<td>"+item.data.ref+"</td>" +
                    "<td>"+item.data.name+"</td>" +
                    "<td class='text-right'>"+format_number(item.data.cost)+"</td>" +
                    "<td class='text-center'>"+item.data.sto+"</td>" +
                    "</tr>";
            });

            $("#shopping_select_products").html( "<option></option>"+ref ).select2({ theme:"bootstrap4",placeholder: "Seleccione producto..." });

            tbl_ref_shopping.destroy();
            $("#table_products tbody").html( tbl );

            tbl_ref_shopping =$("#table_products").DataTable({
                pageLength: 6,
                info: false,
                lengthChange: false,
                language: {
                    "sSearch":"Buscar:"
                },
                order: [[ 1, "asc" ]]
            });

            $.post( url+"ajax/shopping.ajax.php", { single:idp, name:"providers" }, function (data) {

                $("#form_shopping")[0].reset();

                if( $("#val_customer").val() != 1 ){ $("#blq_customer").slideToggle(); }

                if( $("#val_btn").val() != 0 ){ $("#btn_update_new_cutomer, #btn_save_new_cutomer").slideToggle(); }

                if( $("#val_blq").val() != 1 ){ $("#blq_references, #blq_products").slideToggle(); }

                $("#val_customer").val(1); $("#val_btn").val(0); $("#val_blq").val(1);

                $("#form_provider input[name='id_provider']").val( data['id'] );
                $("#form_provider input[name='company']").val( data['company'] );
                $("#form_provider input[name='vendor']").val( data['vendor'] );
                $("#form_provider input[name='nit']").val( data['nit'] );
                $("#form_provider input[name='phone']").val( data['phone'] );
                $("#form_provider input[name='other']").val( data['other'] );
                $("#form_provider input[name='mail']").val( data['mail'] );
                $("#form_provider input[name='address']").val( data['address'] );

                $("#form_shopping input[name='shopping_provider_id']").val( data['id'] );
                $("#form_shopping input[name='shopping_provider_name']").val( data['company'] );

                $("#txt_name").text( reply['name'] );

                $("#blq_provider_data").addClass("collapsed-card");
                $("#btn_pro").removeClass("fa-angle-up").addClass("fa-angle-down");
                $("#name_provider").text( data['company'] + " / " + data['vendor'] );

            },"json");

            $(".blocking, .spiner").fadeOut();

        },"json");
    }, 1000);

});
$(document).on("change", ".cant_shop", function () {

    /*if( $(this).val() > parseInt( $(this).attr("sto") ) ){
        toastr.error("No hay tantas unidades, solo tiene disponible: <b>"+$(this).attr("sto")+"</b>");
        $(this).val( $(this).attr("sto") );
    }*/
    if( $(this).val() != 0 ) {
        $(".sub"+$(this).attr("idr")).text( format_number( parseInt( $(this).attr("cos") ) * $(this).val() ) );
        $("#dto_shopping").val(0);
        $("#cash_shopping").val(0);
        $("#card_shopping").val(0);
        product_compilation_shoping();
    }else{ toastr.warning('Cantidad en cero ("0") no es posible, sino necesita este producto <b>elimínelo</b>'); $(this).val( 1 );}

});
$(document).on("change", ".lot", function () {
    $(this).closest("tr").find("td").eq(5).children().attr("lot",$(this).val() );
    product_compilation_shoping()
});
$(document).on("change", ".ven", function () {
    $(this).closest("tr").find("td").eq(5).children().attr("ven",$(this).val() );
    product_compilation_shoping()
});
$(document).on("change", "#dto_shopping", function () {
    product_compilation_shoping();
});
$(document).on("change", "#cash_shopping", function () {
    product_compilation_shoping();
});
$(document).on("change", "#card_shopping", function () {
    product_compilation_shoping();
});
$(document).on("change", "#other_shopping", function () {
    product_compilation_shoping();
});

//function
function product_compilation_shoping() {
    var selected_prod = [];
    var subtot = 0;
    $("#tblSelectProducts .product_shopp input").each(function () {
        subtot+= $(this).attr("cos") * parseInt( $(this).val() );
        selected_prod.push({
            idr: $(this).attr("idr"),
            ref: $(this).attr("ref"),
            pro: $(this).attr("pro"),
            cos: $(this).attr("cos"),
            sto: $(this).attr("sto"),
            lot: $(this).attr("lot"),
            ven: $(this).attr("ven"),
            can: $(this).val(),
            sub: parseInt( $(this).val() ) * parseFloat( $(this).attr("cos") ),
        });
    });
    var result = JSON.stringify(selected_prod);
    $("#shopping_products").empty().val(result);

    var total = subtot -  remP( $("#dto_shopping").val() );
    var validation =  total - remP( $("#cash_shopping").val() ) - remP( $("#card_shopping").val() ) - remP( $("#other_shopping").val() )  ;

    $("#form_shopping input[name='sub_shopping']").val( format_number(subtot) );
    $("#sub_shopping").val( format_number(subtot) );
    $("#total_shopping").val( format_number( total ) );
    $("#validation_shopping").val( format_number( validation ) );

    switch ( validation ) {
        case 0: $("#validation_shopping").removeClass("text-danger").addClass("text-success"); break;
        default: $("#validation_shopping").removeClass("text-success").addClass("text-danger"); break;
    }

}




