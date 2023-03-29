var ref = [ "idr", "reference", "product", "price", "stock", "dto", "tax" ];
if (localStorage.getItem("customer")) { customer( localStorage.getItem("customer") ); }
$(".phone").inputmask();
$("#from_invoice input[name='postal_code']").inputmask();
$("#customer_sale").select2({
    ajax : {
        url : url+"ajax/general.ajax.php",
        data : function(params) {
            return {
                term : params.term,
                column1:"business_name",
                column2:"document",
                column3:"person_charge",
                direction:"customer",
                filter: ""
            };
        },
        dataType: "json"
    },
    theme:"bootstrap4",
    placeholder: "Buscador de clientes...",
    language: {
        errorLoading: function() { return "Realice busqueda del cliente..."; },
        noResults: function() { return "No hay resultados..."; },
        searching: function() { return "Buscando.."; }
    }
});

$("#segment").select2({ theme:"bootstrap4", placeholder:"Segmento"/*, allowClear: true*/  });
$("#person").select2({ theme:"bootstrap4", placeholder:"Tipo de persona"/*, allowClear: true*/ });
$("#type_id").select2({ theme:"bootstrap4", placeholder:"Tipo de documento"/*, allowClear: true*/ });
$("#regime").select2({ theme:"bootstrap4", placeholder:"Tipo de regimen"/*, allowClear: true*/ });
$("#tax_responsibilities").select2({ theme:"bootstrap4", placeholder:"Responsabilidades tributarias"/*, allowClear: true*/ });
$("#withholding").select2({ theme:"bootstrap4", placeholder:"¿Es autoretenedor?"/*, allowClear: true*/ });

/*$(".city_fe").select2({
    ajax : {
        url : url+"ajax/general.ajax.php",
        data : function(params) {
            return {
                term : params.term,
                column1:"tag",
                column2:"tag",
                column3:"tag",
                direction:"tags",
                filter: "and type=\"location\""
            };
        },
        dataType: "json"
    },
    theme:"bootstrap4",
    placeholder: "Ciudad y/o municipio",
    language: {
        errorLoading: function() { return "Realice busqueda de la ciudad..."; },
        noResults: function() { return "No hay resultados..."; },
        searching: function() { return "Buscando.."; }
    }
});*/
$("#city_fe").select2({
    ajax : {
        url : url+"ajax/general.ajax.php",
        data : function(params) {
            return {
                term : params.term,
                column1:"tag",
                column2:"tag",
                column3:"tag",
                direction:"tags",
                filter: "and type=\"location\""
            };
        },
        dataType: "json"
    },
    theme:"bootstrap4",
    placeholder: "Ciudad y/o municipio",
    language: {
        errorLoading: function() { return "Realice busqueda de la ciudad..."; },
        noResults: function() { return "No hay resultados..."; },
        searching: function() { return "Buscando.."; }
    }
});
$("#city").select2({
    ajax : {
        url : url+"ajax/general.ajax.php",
        data : function(params) {
            return {
                term : params.term,
                column1:"tag",
                column2:"tag",
                column3:"tag",
                direction:"tags",
                filter: "and type=\"location\""
            };
        },
        dataType: "json"
    },
    theme:"bootstrap4",
    placeholder: "Ciudad y/o municipio",
    language: {
        errorLoading: function() { return "Realice busqueda de la ciudad..."; },
        noResults: function() { return "No hay resultados..."; },
        searching: function() { return "Buscando.."; }
    }
});


$(document).on("click", "#btn_new_cus", function () {
    if ( $("#data_customer").hasClass("hide") == true){
        $("#data_customer").slideDown("fast").removeClass("hide");
        $("#blq_sale").slideUp();
    } else {
        $("#data_customer").slideUp("fast").addClass("hide");
    }
});
$(document).on("change", "#segment", function () {
    switch ( $(this).val() ) {
        case "": $("#blq_quote").slideUp(); $("#blq_invoice").slideUp(); break;
        case "1": $("#blq_invoice").slideDown(); $("#blq_quote").slideUp(); $(".form-input").css("width", "100%"); break;
        case "2": $("#blq_quote").slideDown(); $("#blq_invoice").slideUp(); break;
    }
});
$(document).on("change", "#person", function () {
    switch ( $(this).val() ) {
        case "1":
            $("#type_id").val(31).trigger("change").prop("disabled", true);
            $("#regime").val(48).trigger("change").prop("disabled", true);
            $("#withholding").val("").trigger("change").prop("disabled", false);
            $("#blq_business").html('' +
                '<input type="text" class="form-control req_cus_fe " name="business_name" placeholder="Razon social" />' +
                '<i class="fat fas fa-signature" data-toggle="tooltip" data-placement="left" title="Razon social(R-35)"></i>' +
                '');
            break;
        case "2":
            $("#type_id").val("").trigger("change").prop("disabled", false);
            $("#regime").val("").trigger("change").prop("disabled", false);
            $("#withholding").val(0).trigger("change").prop("disabled", true);
            $("#blq_business").html('' +
                '<input type="text" class="form-control req_cus_fe " name="business_name" placeholder="Nombres del cliente" />' +
                '<input type="text" class="form-control req_cus_fe " name="business_surname" placeholder="Apellidos del cliente" />' +
                '<i class="fat fas fa-signature" data-toggle="tooltip" data-placement="left" title="Nombre del cliente(R-31/34)"></i>' +
                '');
            break;
    }
    $("[data-toggle='tooltip']").tooltip({trigger: "hover"});
});
$(document).on("click", "#btn_save_cus", function () {
    switch ( required_select2("req_cus_fe") ) {
        case "ok":
            if(
                ( $("#person").val() == 1 && ( $("#from_invoice input[name='code_document']").val() == "" || $("#from_invoice input[name='code_document']").val() == 0 ) ) ||
                ( $("#type_id").val() == 31 && ( $("#from_invoice input[name='code_document']").val() == "" || $("#from_invoice input[name='code_document']").val() == 0 ) )
            ){
                toastr.warning("Dado que tiene nit debe ingresar el dígito de verificación, ingreselo por favor");
            }else{
                if( !validate_cell_phone( $("#from_invoice input[name='person_phone']").val() ) ){ phone_msg(); return; }
                if( !validate_mail( $("#from_invoice input[name='mail']").val() ) ) { mail_msg(); return; }
                if( $("#from_invoice input[name='postal_code']").val().replace(/\_/g,"") == 0 ) { toastr.warning('¡El código postal está en "0"!, coloque el que corresponde para poder facturar'); return; }
                localStorage.clear(); $("#from_invoice").submit();
            }
            break;
    }
});
$(document).on("click", "#btn_save_other", function () {
    var val = required_msg( "from_quote" );
    switch ( val ) {
        case "":
            if( !validate_cell_phone( $("#from_quote input[name='person_phone']").val() ) ){ phone_msg(); return; }
            if( !validate_mail( $("#from_quote input[name='mail']").val() ) ) { mail_msg(); return; }
            localStorage.clear(); $("#from_quote").submit(); break;
        default: swal.fire("¡Campos vacios!","Debe ingresar la informacion de "+val.slice(0,-2)+" para crear el prospecto...","warning"); break;
    }
});

$(document).on("click", "#btn_edit_cus", function () {
    $.post( url+"ajax/general.ajax.php", { detailed:localStorage.getItem("customer"),position:"customer" }, function (data) {
        switch (data.segment) {
            case "1":
                $("#blq_invoice, #data_customer").slideDown();
                $("#idi").val(data.id);
                $("#from_invoice select[name='person']").val( data.person ).trigger('change');
                $("#from_invoice input[name='document']").val( data.document );
                $("#from_invoice input[name='code_document']").val( data.code_document );
                if( data.person == 2 ){
                    $("#from_invoice select[name='type_id']").val( data.type_id ).trigger('change');
                    $("#from_invoice select[name='regime']").val( data.regime ).trigger('change');
                }
                $("#from_invoice input[name='business_name']").val( data.business_name );
                $("#from_invoice input[name='business_surname']").val( data.business_surname );
                $("#from_invoice input[name='tradename']").val( data.tradename );
                $("#from_invoice select[name='tax_responsibilities']").val( data.tax_responsibilities ).trigger('change');
                $("#from_invoice select[name='withholding']").val( data.withholding ).trigger('change');
                $("#from_invoice input[name='postal_code']").val( data.postal_code );
                $.post( url+"ajax/general.ajax.php", { unique:data.municipal_code, field:"cod", position:"tags" }, function (item) {
                    var city = $('#city_fe');
                    var option = new Option( item.tag, item.id, true, true);
                    city.append(option).trigger('change');
                    city.trigger({ type: 'select2:select', params: { data: data } });
                },"json");
                $("#from_invoice textarea[name='address']").val( data.address );
                $("#from_invoice input[name='person_charge']").val( data.person_charge );
                $("#from_invoice input[name='person_phone']").val( data.person_phone );
                $("#from_invoice input[name='mail']").val( data.mail );
                break;
            case "2":
                $("#blq_quote, #data_customer").slideDown();
                $("#idq").val(data.id);
                $("#from_quote input[name='business_name']").val( data.business_name );
                $.post( url+"ajax/general.ajax.php", { unique:data.municipal_code, field:"cod", position:"tags" }, function (item) {
                    var city = $('#city');
                    var option = new Option( item.tag, item.id, true, true);
                    city.append(option).trigger('change');
                    city.trigger({ type: 'select2:select', params: { data: data } });
                },"json");
                $("#from_quote textarea[name='address']").val( data.address );
                $("#from_quote input[name='person_charge']").val( data.person_charge );
                $("#from_quote input[name='person_phone']").val( data.person_phone );
                $("#from_quote input[name='mail']").val( data.mail );
                break;
        }
        $("#segment").val(data.segment).trigger('change');
        $("#blq_sale").slideUp();
        $("#customer").removeClass("collapsed-card")
    },"json");
});

$(document).on("change", "#customer_sale", function () { customer( this.value ); });

$(document).on("change", "#sel_selected_ref", function () {
    idr = $(this).find('option:selected').attr("idr");
    reference = $(this).find('option:selected').attr("reference");
    product = $(this).find('option:selected').attr("product");
    price = $(this).find('option:selected').attr("price");
    tax = $(this).find('option:selected').attr("tax");
    stock = $(this).find('option:selected').attr("stock");
    dto = $(this).find('option:selected').attr("dto");
    prod=
        '<tr>' +
        '<td>'+product+' #'+stock+'</td>' +
        '<td class="sel text-center"> <input class="cant text-center can_sale" idr="'+idr+'" reference="'+reference+'" product="'+product+'" price="'+price+'" tax="'+tax+'" stock="'+stock+'" dto="'+dto+'" value="0" /> </td>' +
        '<td class="text-right">0</td>' +
        '<td> <i class="far fa-trash-alt text-danger hand btn_del_prod" idr="'+idr+'" reference="'+reference+'" product="'+product+'" price="'+price+'" tax="'+tax+'" stock="'+stock+'" dto="'+dto+'" ></i> </td>' +
        '<tr>'
    ;
    $("#tbl_ref_sale tbody").append( prod );

    localStorage.setItem("selected_sale", tbl_selected('tbl_ref_sale','sel', ref) );
    localStorage.setItem("available_sale", update_selected( localStorage.getItem("available_sale") , localStorage.getItem("selected_sale") ) );
    selector_item( JSON.parse(localStorage.getItem("available_sale")), "sel_selected_ref", ref, "product", "stock");
    $("#form_sold input[name='sold']").val(  tbl_selected('tbl_ref_sale','sel', ref)  );
    totals();
});
$(document).on("click", ".btn_del_prod", function () {
    $available = JSON.parse( localStorage.getItem("available_sale") );
    ( $available == "" ) ? data = [] : data = $available;
    data.push({
        idr : $(this).attr('idr'),
        reference : $(this).attr("reference"),
        product : $(this).attr("product"),
        price : $(this).attr("price"),
        tax : $(this).attr("tax"),
        stock : $(this).attr("stock"),
        dto : $(this).attr("dto")
    });
    localStorage.setItem("available_sale", JSON.stringify( data ) );
    $(this).closest('tr').remove();
    $("#form_sold input[name='sold']").val(  tbl_selected('tbl_ref_sale','sel', ref)  );
    localStorage.setItem("selected_sale",  $("#form_sold input[name='sold']").val( )  );
    selector_item( JSON.parse(localStorage.getItem("available_sale")), "sel_selected_ref", ref, "product", "stock");
    totals();
});
$(document).on("change", ".can_sale", function () {
    sto = $(this).attr("stock");
    parseInt( this.value ) <= sto ? ver = "ok" : ver = "non" ;
    switch ( ver ) {
        case 'non': toastr.info("No tiene unidades disponibles, solo puede vender maximo: "+sto); $(this).val( sto ); break;
        default: if( this.value == 0 || this.value == "" ){ toastr.error("No puede dejarlo en cero ni en blanco, elimínelo sino lo va a vender "); $(this).val(1) } break;
    }
    if( $(this).attr("price") > 0 ){
        $(this).parent().parent().children(":nth-child(3)").text( format_number(this.value * $(this).attr("price"),0) );
        localStorage.setItem("selected_sale", tbl_selected('tbl_ref_sale','sel', ref) );
        $("#form_sold input[name='sold']").val(  tbl_selected('tbl_ref_sale','sel', ref)  );
        totals();
    }
    else { toastr.error('Este producto no tiene precio establecido, debe verificar que tenga el precio correspondiente par incluirlo en esta venta.'); $(this).val(0) };
});
$(document).on("change", "#dto", function () {
    totals();
});

$(document).on("click", "#btn_save_sale", function () {

    $response = "ok"; $("#tbl_ref_sale .sel input").each(function (r) { if( this.value == 0 || this.value == "" ) { $response = "error"; } });

    switch ( $response ) {
        case "ok":
            $cas = parseInt( $("#form_sold input[name='cash']").val().replace(/\./g,"") );
            $tra = parseInt( $("#form_sold input[name='tran']").val().replace(/\./g,"") );
            $oth = parseInt( $("#form_sold input[name='other']").val().replace(/\./g,"") );

            $tot = parseInt( $("#form_sold input[name='total']").val().replace(/\./g,"") );
            $dev = format_number( $cas+$tra+$oth-$tot,0 );

            if( $cas+$tra+$oth == $tot ){
                $type = "de CONTADO"; $ico = "info"; $txt = "CONTADO"; $col = "#5bc0de"; $cla = "text-info"; $sta = "ok";
            }else if ( $cas+$tra+$oth > $tot ) {
                $sta = "dev";
            }else if ( $cas+$tra+$oth < $tot ) {
                $type = "CRÉDITO"; $ico = "warning"; $txt = "CRÉDITO"; $col = "#f0ad4e"; $cla = "text-warning";  $sta = "ok";
            }

            switch ( $sta ) {
                case "ok":
                    Swal.fire({
                        title: "¿Esta venta es "+$type+"?",
                        html: 'Si esta seguro de click en <b class="'+$cla+'">"'+$txt+'"</b>, en caso contrario de click en <b class="text-gray">"No, me equivoque!"</b>',
                        icon: $ico, showCancelButton: true, confirmButtonText: $txt, confirmButtonColor: $col, cancelButtonText: "No, me equivoque!",
                    }).then((result) => { if (result.value) { $("#form_sold").submit(); } }); break;
                case "dev":
                    swal.fire("El valor a devolver es: $ "+$dev ,"El valor del pago debe ser igual al de la venta ¡Ajustelo para continuar!",""); break;
            }
            break;
        default: toastr.info("Algun producto esta en cero o en blanco ¡Modifiquelo o eliminelo para continuar!"); break;
    }

});


function customer( idc ) {
    $.post( url+"ajax/sales.ajax.php", { single:idc, name:"customer", product:"and site="+$("#site").val() }, function (data) {

        data.cust.document == 0 ? nit = "" : nit = data.cust.document;
        $("#blq_data_cus").html( '<li><b>'+data.cust.business_name+'</b> (<small>Nit: </small>'+nit+')<br> <small>Email: </small>'+data.cust.mail+' / <small>Dir.: </small> '+data.cust.address+' / <small>Tel.: </small> '+data.cust.person_phone+'</li>' );
        $("#customer_id").val( data.cust.id );

        switch (data.cust.segment) {
            case "1": $("#alert_fe").slideDown(); break;
            case "2": $("#alert_fe").slideUp(); break;
        }

        val_cus = "ok";
        if( data.cust.person == 1 && data.cust.type_id != 31){ val_cus = "error"; }
        else if ( data.cust.person == 2 && data.cust.business_surname == null ) { val_cus = "error"; }
        else if ( data.cust.type_id == 31 && data.cust.code_document == 0 ) { val_cus = "error"; }
        else { $.each( data.cust, function (k, val) { if( isNaN(k) && val == null && k != "withholding" && k != "business_surname" ){ val_cus = "error";} }) }

        switch ( val_cus ) {
            case "error":
                $.post( url+"ajax/general.ajax.php", { detailed:idc,position:"customer" }, function (data) {
                    switch (data.segment) {
                        case "1":
                            $("#blq_invoice, #data_customer").slideDown();
                            $("#idi").val(data.id);
                            $("#from_invoice select[name='person']").val( data.person ).trigger('change');
                            $("#from_invoice input[name='document']").val( data.document );
                            $("#from_invoice input[name='code_document']").val( data.code_document );
                            if( data.person == 2 ){
                                $("#from_invoice select[name='type_id']").val( data.type_id ).trigger('change');
                                $("#from_invoice select[name='regime']").val( data.regime ).trigger('change');
                            }
                            $("#from_invoice input[name='business_name']").val( data.business_name );
                            $("#from_invoice input[name='business_surname']").val( data.business_surname );
                            $("#from_invoice input[name='tradename']").val( data.tradename );
                            $("#from_invoice select[name='tax_responsibilities']").val( data.tax_responsibilities ).trigger('change');
                            $("#from_invoice select[name='withholding']").val( data.withholding ).trigger('change');
                            $("#from_invoice input[name='postal_code']").val( data.postal_code );
                            $.post( url+"ajax/general.ajax.php", { unique:data.municipal_code, field:"cod", position:"tags" }, function (item) {
                                var city = $('#city_fe');
                                var option = new Option( item.tag, item.id, true, true);
                                city.append(option).trigger('change');
                                city.trigger({ type: 'select2:select', params: { data: data } });
                            },"json");
                            $("#from_invoice textarea[name='address']").val( data.address );
                            $("#from_invoice input[name='person_charge']").val( data.person_charge );
                            $("#from_invoice input[name='person_phone']").val( data.person_phone );
                            $("#from_invoice input[name='mail']").val( data.mail );
                            $("#blq_sale").slideUp();
                            $("#customer").removeClass("collapsed-card");
                            $("#segment").val(data.segment).trigger('change');
                            break;
                    }

                },"json");
                break;
        }

        $sel = []; $card = [];
        $.each( data.sold, function (r,row) {
            $sel[r] = JSON.parse( row.products, true);
            $ref = JSON.parse( row.products, true);
            $tr = []; $.each( $ref, function (i,item) { $tr[i] = '<tr> <td>'+item.product+'</td> <td class="text-center">'+item.cant+'</td> </tr>'; });
            $card[r] =
                '<div class="card collapsed-card">' +
                '<div class="d-flex vertical_center p-0 pl-2 pr-2 ">'+
                '<h6>#'+row['sales']+' - '+row['created']+'</h6>'+
                '<i class="far fa-eye text-sm dr_ad ml-auto hand" data-card-widget="collapse"></i>'+
                '</div>'+
                '<div class="card-body pt-0 pl-3 pr-3 pb-2">' +
                '<table class="table table-borderless text-xs tbl_view">' +
                '<thead class="text-center">' +
                '<th>Producto</th>'+
                '<th>Cant</th>'+
                '</thead>' +
                '<tbody>'+$tr.join("")+'</tbody>' +
                '</table>' +
                '</div>' +
                '</div>';
        });

        if( data.list == "" ){ $select = []; $("#tbl_ref_sale tbody").empty(); $("#sales_cus").slideUp(); }
        else{
            if( data.list == "" ){ $select = JSON.stringify([] ); $("#tbl_ref_sale tbody").empty(); }
            else{
                $select = data.list; create_tbl( $select ,'other') ;} $("#sales_cus").slideDown();
        }

        localStorage.setItem("customer", data.cust.id );
        localStorage.setItem("available_sale", JSON.stringify( data.prod ) );
        localStorage.setItem("selected_sale", JSON.stringify( $select ) );
        $data = update_selected( localStorage.getItem("available_sale"), localStorage.getItem("selected_sale") );
        localStorage.setItem("available_sale",  $data  );
        selector_item( JSON.parse($data), "sel_selected_ref", ref, "product", "stock");

        $("#mov_cus").html($card);
        $("#customer").addClass("collapsed-card");
        $("#blq_sale").slideDown();



    },"json");
}
function create_tbl( selected, type ) {
    var prod = [];
    $.each( selected, function (i, data) {
        (type == "empty") ? idt = data.id : idt = data.idr;
        (data.cant) ? can = data.cant : can = 0;
        prod [i]=
            '<tr>' +
            '<td>'+data.product+' #'+data.stock+' / mov '+data.sold+' </td>' +
            '<td class="sel text-center"> <input class="cant text-center can_sale" idr="'+data.idr+'" reference="'+data.reference+'" product="'+data.product+'" price="'+data.price+'" tax="'+data.tax+'"  stock="'+data.stock+'" dto="0"  value="0" /> </td>' +
            '<td class="text-right">'+0+'</td>' +
            '<td> <i class="far fa-trash-alt text-danger hand btn_del_prod" idr="'+data.idr+'" reference="'+data.reference+'" product="'+data.product+'" price="'+data.price+'" tax="'+data.tax+'"  stock="'+data.stock+'" dto="0" ></i> </td>' +
            '<tr>'
        ;
    });
    $("#tbl_ref_sale tbody").html( prod );
    totals();
}
function totals() {
    tot = 0;
    $("#tbl_ref_sale .sel input").each(function (r) {
        tot += this.value * $(this).attr("price")
    });
    $("#sub").val( format_number( tot, 0) );
    ( $("#dto").val() == "" ) ? dto = 0 : dto = $("#dto").val() / 100;
    $("#form_sold input[name='total']").val( format_number( tot - (tot * dto) ,0 ) );
}