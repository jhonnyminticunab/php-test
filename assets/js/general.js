$("#ftech_status").select2({ theme:"bootstrap4", placeholder:"Ftech send data status"/*, allowClear: true */ });
$("#segment").select2({ theme:"bootstrap4", placeholder:"Segmento"/*, allowClear: true*/  });
$("#person").select2({ theme:"bootstrap4", placeholder:"Tipo de persona"/*, allowClear: true*/ });
$("#type_id").select2({ theme:"bootstrap4", placeholder:"Tipo de documento"/*, allowClear: true*/ });
$("#regime").select2({ theme:"bootstrap4", placeholder:"Tipo de regimen"/*, allowClear: true*/ });
$("#withholding").select2({ theme:"bootstrap4", placeholder:"¿Es autoretenedor?"/*, allowClear: true*/ });

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
$.post( url+"ajax/general.ajax.php", { unique:$("#location").val(), field:"cod", position:"tags" }, function (item) {
    var city = $('#city');
    var option = new Option( item.tag, item.id, true, true);
    city.append(option).trigger('change');
    city.trigger({ type: 'select2:select', params: { data: 'test' } });
    if( !$("#city").hasClass("text") ){ $("#city").addClass("text"); }
},"json");



$(document).on("click", ".sri", function () {
    var field = $(this).attr("field");
    var value = $(".text_"+field).val();
    $.post( url+"ajax/general.ajax.php",{ id:1, field:field, direction:"template", text:value },function (reply) {
        switch ( reply ) { case "ok": toastr.success("Cambio realizado con éxito"); break; default: error_msg(); break; }
    });
});
$(document).on("change", ".sel", function () {
    var field = $(this).attr("field");
    var value = this.value;
    $.post( url+"ajax/general.ajax.php",{ id:1, field:field, direction:"template", text:value },function (reply) {
        switch ( reply ) { case "ok": toastr.success("Cambio realizado con éxito"); break; default: error_msg(); break; }
    });
});
$(".file_template").on("change",function () {
    field = $(this).attr("field");
    file = this.files[0];

    var dataFile = new FormData();
    dataFile.append("only", 1);
    dataFile.append("direction", "template");
    dataFile.append("url", "assets/img/template/");
    dataFile.append("file", file);
    dataFile.append("field", field);

    $.ajax({
        url:url+"ajax/images.ajax.php",
        method: "POST",
        data: dataFile,
        cache: false,
        contentType: false,
        processData: false,
        success: function(r){
            if(r != 'ok'){
                toastr.error('Ocurrio un error, intente de nuevo o comuníquese con el administrador');
            }else{
                location.reload();
            }
        }
    })
});

$(document).on("change", ".text", function () {
    var field = $(this).attr("field");
    var value = this.value;
    switch ( value ) {
        case '':  toastr.error("El campo no puede ir vacio, debe llenarlo"); break;
        default: $.post( url+"ajax/general.ajax.php",{ id:1, field:field, direction:"company", text:value },function (reply) {
            switch ( reply ) { case "ok": toastr.success("Cambio realizado con éxito"); break; default: error_msg(); break; }
        }); break;

    }
});