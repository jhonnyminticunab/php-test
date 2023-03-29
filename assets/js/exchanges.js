var ref = [ "idr", "reference", "product", "price", "stock", "tax" ];

$("#customer_exchange").select2({
    ajax : {
        url : url+"ajax/exchange.ajax.php",
        data : function(params) {
            return {
                term : params.term,
                column1:"business_name",
                column2:"document",
                column3:"person_charge",
                direction:"sale",
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

$(document).on("change", "#customer_exchange", function () {

    $.post( url+"ajax/exchange.ajax.php", { customer:this.value, site:$("#site").val() }, function (data) {

        $("#customer_id").val( data.cust.id );
        data.cust.document == 0 ? nit = "" : nit = data.cust.document;
        $("#blq_data_cus").html( '<li><b>'+data.cust.business_name+'</b> (<small>Nit: </small>'+nit+')<br> <small>Email: </small>'+data.cust.mail+' / <small>Dir.: </small> '+data.cust.address+' / <small>Tel.: </small> '+data.cust.person_phone+'</li>' );
        $("#segment").val( data.cust.segment );
        tbl = [];
        $.each( data.cred, function (i,item) {
            $pay = parseInt(item.cash)+parseInt(item.card)+parseInt(item.other)+parseInt(item.payment);
            tbl[i]=
                '<tr class="sold hand" id="'+item.id+'" typ="'+item.typ+'">' +
                '<td class="text-center">'+item.sales+'</td>' +
                '<td class="text-center">'+item.created.slice(0,10) +'</td>' +
                '<td class="text-right">'+format_number(item.subtotal,0)+'</td>' +
                '<td class="text-right">'+item.dto+'%</td>' +
                '<td class="text-right">'+format_number(item.total,0)+'</td>' +
                '</tr>';
        })
        $("#tbl_credits tbody").html(tbl);

        $("#blq_provider_exchange").addClass("collapsed-card");
        $("#blq_exchange").slideDown();

        localStorage.setItem("in", JSON.stringify(data.ref) );
        localStorage.setItem("out", JSON.stringify(data.inv) );
        selector_item( JSON.parse( localStorage.getItem("in") ),"selected_exchange",ref,'product','');

        $("#blq_sales").addClass("collapsed-card");
        $("#blq_transaction").slideDown();

    },"json");

});
$(document).on("click", ".sold", function () {
    typ = $(this).attr("typ");
    $.post( url+"ajax/exchange.ajax.php", { single:this.id, name:typ, site:$("#site").val() }, function (data) {
        // localStorage.setItem("sold", data.sol.products );
        localStorage.setItem("in", JSON.stringify(data.ref) );
        localStorage.setItem("out", JSON.stringify(data.inv) );
        selector_item( JSON.parse( localStorage.getItem("in") ),"selected_exchange",ref,'product','');
        $("#customer_id").val( data.sol.customer_id );
        $("#blq_sales").addClass("collapsed-card");
        $("#blq_transaction").slideDown();
    },"json");
});
$(document).on("click", ".btn_typ", function () {
    switch ( this.id ) {
        case "in": $("#out").slideDown(); $("#in").slideUp(); $("#selected_exchange").attr("typ","in"); break;
        case "out": $("#in").slideDown(); $("#out").slideUp(); $("#selected_exchange").attr("typ","out"); break;
    }
    selector_item( JSON.parse( localStorage.getItem( this.id ) ),"selected_exchange",ref,'product','')
});
$(document).on("change", "#selected_exchange", function () {
    typ = $(this).attr("typ");
    idr = $(this).find('option:selected').attr("idr");
    reference = $(this).find('option:selected').attr("reference");
    product = $(this).find('option:selected').attr("product");
    price = $(this).find('option:selected').attr("price");
    tax = $(this).find('option:selected').attr("tax");
    stock = $(this).find('option:selected').attr("stock");
    (typ == "out") ? $txt = " #"+stock : $txt = "" ;
    prod=
        '<tr>' +
        '<td>'+product+$txt+'</td>' +
        '<td class="list text-center"> <input class="cant text-center can_exchange" idr="'+idr+'" reference="'+reference+'" product="'+product+'" price="'+price+'" tax="'+tax+'" typ="'+typ+'" stock="'+stock+'" value="0" /> </td>' +
        '<td class="text-right">0</td>' +
        '<td> <i class="far fa-trash-alt text-danger hand btn_del_prod" idr="'+idr+'" reference="'+reference+'" product="'+product+'" price="'+price+'" tax="'+tax+'" typ="'+typ+'" ></i> </td>' +
        '<tr>'
    ;

    switch ( typ ) {
        case "in": select = "selected_in"; tbl = "tbl_in";  break;
        case "out": select = "selected_out"; tbl = "tbl_out";  break;
    }

    $("#"+tbl+" tbody").append( prod );
    $("#"+tbl).slideDown();

    localStorage.setItem( select, tbl_selected( tbl, "list", ref) );
    localStorage.setItem( typ, update_selected( localStorage.getItem( typ ) , localStorage.getItem(select) ) );
    selector_item( JSON.parse( localStorage.getItem( typ ) ),"selected_exchange",ref,'product','');
    $("#"+typ+"_sel").val( localStorage.getItem(select) );
    totals();
});

$(document).on("change", ".can_exchange", function () {
    typ = $(this).attr("typ");

    switch ( typ ) {
        case "in": if( this.value == 0 || this.value == "" ){ toastr.error("No puede dejarlo en cero ni en blanco, elimínelo sino lo van a devolver"); $(this).val(1) } break;
        case "out":
            sto = $(this).attr("stock");
            parseInt( this.value ) <= sto ? ver = "ok" : ver = "non" ;
            switch ( ver ) {
                case 'non': toastr.info("No tiene unidades disponibles, solo puede vender maximo: "+sto); $(this).val( sto ); break;
                default: if( this.value == 0 || this.value == "" ){ toastr.error("No puede dejarlo en cero ni en blanco, elimínelo sino lo va a recibir"); $(this).val(1) } break;
            }break;
    }

    $(this).parent().parent().children(":nth-child(3)").text( format_number(this.value * $(this).attr("price"),0) );
    switch ( typ ) {
        case "in": select = "selected_in"; tbl = "tbl_in";  break;
        case "out": select = "selected_out"; tbl = "tbl_out";  break;
    }
    localStorage.setItem( select, tbl_selected( tbl, "list", ref) );
    $("#"+typ+"_sel").val( localStorage.getItem(select) );
    totals();
});
$(document).on("click", ".btn_del_prod", function () {
    typ = $(this).attr("typ");
    $available = JSON.parse( localStorage.getItem( typ ) );
    ( $available == "" ) ? data = [] : data = $available;
    data.push({
        idr : $(this).attr('idr'),
        reference : $(this).attr("reference"),
        product : $(this).attr("product"),
        price : $(this).attr("price"),
        tax : $(this).attr("tax"),
        stock : $(this).attr("stock")
    });
    localStorage.setItem( typ, JSON.stringify( data ) );
    $(this).closest('tr').remove();
    switch ( typ ) {
        case "in": select = "selected_in"; tbl = "tbl_in";  break;
        case "out": select = "selected_out"; tbl = "tbl_out";  break;
    }
    localStorage.setItem( select, tbl_selected( tbl, "list", ref) );
    $("#"+typ+"_sel").val( localStorage.getItem(select) );
    selector_item( JSON.parse( localStorage.getItem( typ ) ),"selected_exchange",ref,'product','');
    totals();
});

$(document).on("click", "#btn_save_exchange", function () {

    if( $("#in_sel").val() == "" || $("#in_sel").val() == "[]" ){
        toastr.error("Debe haber al menos un producto que devuelva el cliente para utilizar este módulo ¡ingréselo para continuar!");
    }else{
        $response = "ok"; $("#tbl_in .list input").each(function (r) { if( this.value == 0 || this.value == "" ) { $response = "error"; } });
        $("#tbl_out .list input").each(function (r) { if( this.value == 0 || this.value == "" ) { $response = "error"; } });
        switch ( $response ) {
            case "error": toastr.info("Algun producto esta en cero o en blanco ¡Modifiquelo o eliminelo para continuar!"); break;
            case "ok":
                switch ( required("required") ) {
                    case "ok":
                        bal = parseInt( $("#bal_val").val().replace(/\./g,"") );
                        pay = parseInt($("#form_exchange input[name='cash']").val().replace(/\./g,"") ) + parseInt($("#form_exchange input[name='card']").val().replace(/\./g,"") ) + parseInt($("#form_exchange input[name='other']").val().replace(/\./g,"") );
                        dev = pay - bal;
                        if( pay == bal ){ $("#form_exchange").submit(); }
                        else if ( pay > bal ){ swal.fire("La diferencia es de: $ "+dev ,"El valor debe ser igual a la devolución o al cobro que debe hacer ¡Ajustelo para continuar!","info"); }
                        else{ swal.fire("La diferencia es de: $ "+dev ,"El valor debe ser igual a la devolución o al cobro que debe hacer ¡Ajustelo para continuar!","error"); }
                        break;
                }
                break;
        }
    }

});



function totals() {
    var in_val = 0, out_val = 0;
    $("#tbl_in .list input").each(function (r) { in_val += this.value * $(this).attr("price") });
    $("#tbl_out .list input").each(function (r) { out_val += this.value * $(this).attr("price") });

    if( out_val > in_val ){ txt = "Cobrar"; col = "text-danger"; adj = 1; del = "text-success"; }
    else{ txt = "Devolver"; col = "text-success"; adj = -1; del = "text-danger"; }

    $("#in_val").val( format_number(in_val,0) );
    $("#out_val").val( format_number(out_val,0) );

    $("#mov").text( txt ).removeClass(del).addClass(col);
    $("#bal_val").val( format_number( (out_val - in_val)*adj  ,0) );
}