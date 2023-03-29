
$("#customer_credit").select2({
    ajax : {
        url : url+"ajax/credit.ajax.php",
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

$(document).on("change", "#customer_credit", function () {

    $.post( url+"ajax/credit.ajax.php", { customer:this.value }, function (data) {

        data.cust.document == 0 ? nit = "" : nit = data.cust.document;
        $("#blq_data_cus").html( '<li><b>'+data.cust.business_name+'</b> (<small>Nit: </small>'+nit+')<br> <small>Email: </small>'+data.cust.mail+' / <small>Dir.: </small> '+data.cust.address+' / <small>Tel.: </small> '+data.cust.person_phone+'</li>' );
        tbl = [];
        $.each( data.cred, function (i,item) {
            $pay = parseInt(item.cash)+parseInt(item.card)+parseInt(item.other)+parseInt(item.payment);
            tbl[i]=
                '<tr class="credit hand" id="'+item.id+'" typ="'+item.typ+'">' +
                '<td>'+item.created.slice(0,10) +'</td>' +
                '<td class="text-center">'+item.sales+'</td>' +
                '<td class="text-right">'+format_number(item.total,0)+'</td>' +
                '<td class="text-right">'+format_number($pay,0)+'</td>' +
                '<td class="text-right">'+format_number(item.balance,0)+'</td>' +
                '</tr>';
        })
        $("#tbl_credits tbody").html(tbl);

        $("#blq_provider_credit").addClass("collapsed-card");
        $("#blq_credits").slideDown();

    },"json");

});
$(document).on("click", ".credit", function () {

    typ = $(this).attr("typ");
    $.post( url+"ajax/credit.ajax.php", { single:this.id, name:typ }, function (data) {

        $("#customer_id").val( data.customer_id );
        $("#idr").val( data.id );
        $("#tot").val( format_number( data.total,0 ) );
        $("#bal").val( format_number( data.balance,0 ) );
        $("#tbl").val( typ );

        $pro = JSON.parse( data.products, true );
        tbl = [];
        $.each( $pro, function (i,item) {
           tbl[i]=
               '<tr>' +
               '<td class="text-left">'+item.product+'</td>'+
               '<td class="text-center">'+item.cant+'</td>'+
               '<td class="text-right">'+format_number(item.cant*item.price,0)+'</td>'+
               '</tr>'
        });
        $("#tbl_detailed_credits tbody").html(tbl);
        $("#blq_sales").addClass("collapsed-card");
        $("#blq_payment").slideDown();

    },"json");

});
$(document).on("click", "#btn_save_pay", function () {
    switch ( required("required") ) {
        case "ok":
            bal = parseInt( $("#bal").val().replace(/\./g,"") );
            pay = parseInt($("#form_payment input[name='cash']").val().replace(/\./g,"") ) + parseInt($("#form_payment input[name='card']").val().replace(/\./g,"") ) + parseInt($("#form_payment input[name='other']").val().replace(/\./g,"") );
            dev = pay - bal;
            if( pay == bal ){
                $("#form_payment").submit();
            }else if ( pay > bal ){
                swal.fire("El valor a devolver es: $ "+dev ,"El valor del pago debe ser igual al del saldo ¡Ajustelo para continuar!","");
            }else{
                swal.fire({
                    title: "¿Se va a realizar un Abono?",
                    html: 'Si esta seguro de click en <b class="text-primary">"¡Continuar!"</b>, si va a cancelar el cédito de clic en <b class="text-gray">"No, me equivoque!"</b> y ajuste el valor del pago para cancelarlo',
                    icon: "warning", showCancelButton: true, confirmButtonText: "¡Continuar!", cancelButtonText: "No, me equivoque!",
                }).then((result) => { if (result.value) { $("#form_payment").submit(); } });
            }
            break;
    }

});
