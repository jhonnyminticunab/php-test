$(window).on("load", function() {
    var preloaderFadeOutTime = 500;
    function hidePreloader() {
        var preloader = $(".spinner-wrapper");
        setTimeout(function() {
            preloader.fadeOut(preloaderFadeOutTime);
        }, 500);
    }
    hidePreloader();
    notification(); setInterval( notification, 300000 );
});

/*global*/
const Toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});
var url = $("#txtUrl").val();
var rout_js = []; rout_js = window.location.pathname.split("/");
var rout_end = window.location.href.substring(window.location.href.lastIndexOf("/") + 1);
var user_id = $("#txtIdu").val();
var color = $("#corporate_color").val();
$('[data-toggle="tooltip"]').tooltip({trigger: "hover"});

$(".bg-corporate, .btn-corporate").css( {"background":color} );
$(".text-corporate").css( {"color":color} );
$(".border-corporate").css( {"border": "0.1em solid "+color} );
$(".btn-corporate").mouseover(function() {
    $(this).css({"background":"#000000","color":color});
}).mouseout(function() {
    $(this).css({"background":color,"color":"#000000"});
});
$(".dr_ad").on("click",function () {
    if( $(this).children().hasClass("fa-angle-down") === true ){
        $(this).children().removeClass("fa-angle-down").addClass("fa-angle-up");
    }else if( $(this).children().hasClass("fa-angle-up") === true ){
        $(this).children().removeClass("fa-angle-up").addClass("fa-angle-down");
    }
});

$("#tbl_inventories").DataTable({
    info: false,
    lengthChange: false,
    pageLength: 10,
    language: { search: "_INPUT_", searchPlaceholder: "Buscar..." },
});
$("#tbl_products, #tbl_reports_dynamic, #tbl_customer").DataTable({
    info: false,
    lengthChange: false,
    pageLength: 10,
    dom: 'Bfrtip',
    language: { search: "_INPUT_", searchPlaceholder: "Buscar..." },
    buttons: [{ extend: 'excelHtml5', className: "btn-download", text: '<i class="fas fa-file-excel"></i>', title: null, filename: name+'_'+date("file"), }],
});

if( $(window).width() < 1100 ){ $(".table").addClass( "table-responsive" ); }


/* login */
$(document).on("click", "#pass_login", function () {
    if( $(this).hasClass("fa-eye") ){ $(this).removeClass("fa-eye").addClass("fa-eye-slash"); $("#password_login").attr("type","text"); }
    else{ $(this).removeClass("fa-eye-slash").addClass("fa-eye"); $("#password_login").attr("type","password"); }
});
$(document).on("focus", "#user_login", function () { $("#msg_user").html(""); });
$(document).on("focus", "#password_login", function () { $("#msg_pass").html(""); });
$(document).on("click", "#btn_login", function () {

    $("#msg_user").html("");
    $("#msg_pass").html("");

    if( $("#user_login").val() === "" && $("#password_login").val() === "" ){
        if( $("#user_login").val() === ""  ){ $("#msg_user").html("<b>Ingese su usuario para ingresar...</b>"); }
        if( $("#password_login").val() === ""  ){ $("#msg_pass").html("<b>Ingese su contraseña para ingresar...</b>"); }
    }else{
        $("#form_login").submit();
    }

});
$(document).on("click", "#btn_recovery_pass", function () {
   if( $("#form_recovery input[name='mail_recovery']").val() != '' &&  $("#form_recovery input[name='username_recovery']").val() != '' ) {

       if( !validate_mail( $("#form_recovery input[name='mail_recovery']").val() ) ) {
           toastr.info('El correo electrónico que ingreso tiene un error, por favor corríjalo para continuar'); return;
       }

       $("#form_recovery").submit();

   }else{ toastr.warning("Todos los campos son obligatorios, ingreselos para continuar"); }
});

/* pass */
$(document).on("click", "#pass", function () {
    if( $(this).hasClass("fa-eye") ){ $(this).removeClass("fa-eye").addClass("fa-eye-slash"); $("#password").attr("type","text"); }
    else{ $(this).removeClass("fa-eye-slash").addClass("fa-eye"); $("#password").attr("type","password"); }
});
$(document).on("click", "#btn_new_pass", function () {
    swal.fire({
        title: "¡Va a modificar su contraseña!",
        text: 'Si esta seguro de cambiarla de click en "Si, Cambiar", en caso contrario de click en "No, Me equivoque"',
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Cambiar!",
        cancelButtonText: "No, Me equivoque!",
        confirmButtonColor: color,
        cancelButtonColor: "#d33"
    }).then((result) => {
        if (result.value) {
            if( $("#password").val() != "" ){
                $("#form_new_pass").submit();
            }else{
                toastr.error("No ingreso una nueva contraseña, para cambiarla debe ingresar una...");
            }
        }
    });
});

/* comands */
$(document).on("click", ".refresh", function () {
    location.reload();
});

/* users */
$(document).on("click", ".btn_sta", function () {
    var btn = $(this);
    var sta = $(this).attr("sta");

    $.post( url+"ajax/general.ajax.php", { status:$(this).attr("idu"), value:sta, position:"users" }, function (reply) {

        if( reply == "ok" ){
            if( sta == 1 ){ $(btn).removeClass("btn-danger").addClass("btn-success").attr("sta",0).html( '<i class="fas fa-toggle-on"></i> Activo' );
            }else{ $(btn).removeClass("btn-success").addClass("btn-danger").attr("sta",1).html( '<i class="fas fa-toggle-off"></i> Inactivo' );  }
        }else{ error_msg(); }

    });

});
$(document).on("click", "#btn_new_usu", function () {
    $("#usu_title").text("Crear Usuario");
    $("#form_users")[0].reset();
    $("#modal_users").modal("show");
});
$(document).on("click", "#btn_edit_user", function () {
    $.post( url+"ajax/general.ajax.php", { detailed:$(this).attr("idu"), position:"users" }, function (reply) {

        $("#usu_title").text("Editar Usuario");
        $("#form_users input[ name= 'usu_id' ]").val( reply["id"] );
        $("#form_users input[ name= 'name' ]").val( reply["name"] );
        $("#form_users input[ name= 'document' ]").val( reply["document"] );
        $("#form_users input[ name= 'username' ]").val( reply["username"] );
        $("#form_users select[ name= 'role' ]").val( reply["role"] );
        $("#form_users select[ name= 'site' ]").val( reply["site"] );
        $("#form_users input[ name= 'email' ]").val( reply["email"] );
        $("#form_users input[ name= 'phone' ]").val( reply["phone"] );
        $("#form_users textarea[ name= 'address' ]").val( reply["address"] );

        $("#modal_users").modal("show");

    },"json");
});
$(document).on("click", "#btn_save_usu", function () {
    if(
        $("#form_users input[ name= 'name' ]").val() != "" &&
        $("#form_users input[ name= 'document' ]").val() != "" &&
        $("#form_users input[ name= 'username' ]").val() != "" &&
        $("#form_users select[ name= 'role' ]").val() != "" &&
        $("#form_users input[ name= 'email' ]").val() != "" &&
        $("#form_users input[ name= 'phone' ]").val() != "" &&
        $("#form_users textarea[ name= 'address' ]").val() != ""
    ){
       $("#form_users").submit();
    }else{ toastr.warning("Todos los campos son obligatorios, llenelos todos para continuar..."); }

});
$(document).on("click", "#btn_reset_pass_user", function () {

    Swal.fire({
        title: "¿Quiere restablecer la contraseña de este usuario?",
        html: 'Si la quiere restablecer de click en <b>"Si, Restablecer!"</b>, en caso contrario de click en <b>"No, Cancelar!"</b>',
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Restablecer!",
        cancelButtonText: "No, Cancelar!"
    }).then((result) => {
        if (result.value) {
            $.post( url+"ajax/general.ajax.php" , { reset:$(this).attr("idu") }, function (reply) {
                switch ( reply ) {
                    case "error": error_msg(); break;
                    default: swal.fire({ title:"¡Recuperacion realizada con éxito!", html:"La nueva contraseña es: <b>"+reply+"</b>, la cual debe ser entregada al usuario para su actual acceso, el luego puede cambiarla a su gusto", icon:"success", showCancelButton: false, confirmButtonText: "ok!", allowOutsideClick: false }); break;
                }
            });
        }
    });

});

/* reports */
$("#date_between_reports").daterangepicker({
    startDate: rout_js[3],
    endDate: rout_js[4],
    singleDatePicker: false,
    locale: { format: "YYYY-MM-DD" },
    calender_style: "picker_4",
});
$(".cancelBtn").hide();
$(".applyBtn").html("<i class=\"fas fa-search\"></i> Buscar");
$(document).on("click", ".applyBtn", function () {
    window.location = url + "reports/" + rout_js[2] + "/" + $("#date_between_reports").val().slice( 0, 10 ) + "/" + $("#date_between_reports").val().slice( -10 );
});

/* actions general */
$(document).on("change", ".required, .base, .expense ", function () {
    if( $(this).parent().children(":last-child").hasClass("fa-times-circle") == true ){
        $(this).removeClass("input_empty").parent().children(":last-child").remove();
    }
});
$(document).on("change", ".req_cus_fe", function () {
    if( $(this).val() != "" ){
        if( $(this).parent().children(":nth-child(3)").hasClass("fa-times-circle") == true ){
            $(this).parent().children(":nth-child(3)").remove();
            $(this).siblings("span").removeClass("input_empty");
            $(this).removeClass("input_empty");
        }else if( $(this).parent().children(":nth-child(2)").hasClass("fa-times-circle") == true ){
            $(this).parent().children(":nth-child(2)").remove();
            $(this).removeClass("input_empty");
        }
    }
});
$(".pending").on("click", function () {
    ( $(this).hasClass("fa-angle-down") == true ) ? $(this).removeClass("fa-angle-down").addClass("fa-angle-up") : $(this).removeClass("fa-angle-up").addClass("fa-angle-down");
});
$(".dr_ad").on("click", function () {
    if( $(this).hasClass("fa-caret-square-down") == true ){ $(this).removeClass("fa-caret-square-down").addClass("fa-caret-square-up"); }
    else if ( $(this).hasClass("fa-caret-square-up") == true ){ $(this).removeClass("fa-caret-square-up").addClass("fa-caret-square-down"); }
});


/* functions */
function date( type ) {

    var date = new Date();
    yyyy = date.getFullYear();
    mm = ('0' + (date.getMonth()+1)).slice(-2);
    dd = ('0' + date.getDate()).slice(-2);
    hh = ('0' + date.getHours()).slice(-2);
    ii = ('0' + date.getMinutes()).slice(-2);
    ss = ('0' + date.getSeconds()).slice(-2);

    switch (type) {
        case "now": date_now = yyyy+"-"+mm+"-"+dd+" "+hh+":"+ii+":"+ss; break;
        case "date": date_now = yyyy+"-"+mm+"-"+dd; break;
        case "time": date_now = hh+":"+ii+":"+ss; break;
        case "file": date_now = yyyy + mm + dd + hh + ii + ss; break;
    }

    return date_now;

}
function error_msg() {
    toastr.error("Ocurrio un error, intente de nuevo o comuniquese con el administrador");
}
function mail_msg() {
    toastr.error("El correo electrónico que ingreso tiene un error, por favor corríjalo para continuar");
}
function phone_msg() {
    toastr.info("Numero de celular incompleto, ingreselo de forma correcta para continuar");
}
function reload () {
    location.reload();
}
function validate_mail( email ) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( email );
}
function switch_btn( btn, sta ) {
    if( sta == 1 ){ $(btn).removeClass("btn-outline-danger").addClass("btn-outline-success").attr("title","Desactivar").attr("data-original-title","Desactivar").attr("sta",0).html( '<i class="fas fa-toggle-on"></i></button>' )
    }else{ $(btn).removeClass("btn-outline-success").addClass("btn-outline-danger").attr("title","Activar").attr("data-original-title","Activar").attr("sta",1).html( '<i class="fas fa-toggle-off"></i></button>' ) }
}
function switch_btn_txt( btn, sta ) {
    ( sta == 0 ) ? $(btn).removeClass("btn-outline-danger").addClass("btn-outline-success").attr("sta",1).html( '<i class="fa fa-check-circle"></i>' )
        : $(btn).removeClass("text-success").addClass("btn-outline-danger").attr("sta",0).html( '<i class="fa fa-times"></i>' )
}
function format_number(number) {
    var n = number.toString().split(".");
    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return n[0];
}
function format(input) {
    var num = input.value.replace(/\./g, '');
    if (!isNaN(num)) {
        num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
        num = num.split('').reverse().join('').replace(/^[\.]/, '');
        input.value = num;
    } else {
        Toast.fire({ icon: "error", title: "&nbsp; Solo se aceptan numeros" });
        input.value = input.value.replace(/[^\d\.]*/g, '');
    }
}
function identificate(input) {
    var num = input.value.replace(/\./g, '');
    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/, '');
    input.value = num;
}
function remP( num ) {
    var debugged = num.replace(/\./g,"");
    return debugged;
}

function required_select2( field ) {
    var response = "ok";
    $("."+field).each(function () {
        switch ( $(this).val() ) {
            case "":
                if( $(this).parent().children(":last-child").hasClass("fa-times-circle") != true ){
                    if( $(this).siblings('span').hasClass("select2-container") ){
                        $(this).siblings('span').addClass("input_empty").after("<i class='fas fa-times-circle fe hand' data-toggle='popover' data-placement='top' data-content='¡Campo obligatorio!'></i>"); $("[data-toggle='popover']").popover({trigger: "hover"});
                    }else{
                        $(this).addClass("input_empty").after("<i class='fas fa-times-circle fe hand' data-toggle='popover' data-placement='top' data-content='¡Campo obligatorio!'></i>"); $("[data-toggle='popover']").popover({trigger: "hover"});
                    }
                }
                response = "error"; break;
        }
    });
    return response;
}
function validate_cell_phone($phone) {
    var response = true;
    if( $phone.indexOf("_") > -1 ){ response = false; }
    return response;
}

function required( field ) {
    var response = "ok";
    $("."+field).each(function () {
        switch ( $(this).val() ) {
            case "":
                if( $(this).parent().children(":last-child").hasClass("fa-times-circle") != true ){
                    $(this).addClass("input_empty").after("<i class='fas fa-times-circle hand' data-toggle='popover' data-placement='top' data-content='Obligatorio'></i>"); $("[data-toggle='popover']").popover({trigger: "hover"});
                }
                response = "error"; break;
        }
    });
    return response;
}
function required_msg( form ) {
    response = "";
    $("#"+form).find('.required').each(function() {
        if( this.value == "" ) { response += [ "<strong>"+$(this).attr("placeholder")+"</strong>, "] }
    });
    return response;
}
function clear_localstorage() {
    localStorage.clear();
}

function item_push( data, attributes  ) {
    obejt = [];
    $.each( data, function (r,row) {
        first = []; array = {};
        $.each( attributes, function (i,item) {
            ( item == "idr" ) ? valor = "id" : valor = item;
            first[i] = [ array[item] = row[valor] ];
        });
        obejt[r] = array
    });
    return JSON.stringify( obejt );
}
function tbl_selected( tbl, cla, attributes ) {
    obejt = [];
    $("#"+tbl+" ."+cla+" input").each(function (r) {
        val = $(this);
        array = {cant:$(this).val()};
        /*switch ( tbl ) {
            case "tbl_selector_pro": array = { estimate:$(this).val(), finished:"0", discarded:"0" } ;break;
            case "tbl_selector_mp": array = { cant:$(this).val(), pm:$(this).attr("pm") } ;break;
        }*/
        test = [];
        $.each( attributes, function (i,item) {
            test[i] = [ array[item] = val.attr(item) ];
        });
        obejt[r] = array
    });
    return JSON.stringify(obejt);
}
function update_selected( ava, sel ) {
    if( $("#selection").val() != "" ){
        available = JSON.parse( ava );
        selection = JSON.parse( sel );
        var array = [];
        for (var i = 0; i < available.length; i++) {
            var igual = false;
            for (var j = 0; j < selection.length & !igual; j++) {
                if (available[i]['idr'] == selection[j]['idr'])
                    igual = true;
            }
            if (!igual) array.push(available[i]);
        }
        return JSON.stringify( array );
    }else{
        // return ava;
        return JSON.stringify( ava );
    }
}
function selector_item( data, select, atribute, text, other ) {
    var references = [];
    $.each( data, function (i, item) {
        $dep = []; $.each ( atribute, function (a, at) { $dep[a] = [ at + '="' + item[at] +'" ']; }); attr = $dep.join(" ");
        other != "" ? oth = " #"+item[other] : oth = "";
        txt = item[text] + oth;
        references[i] = '<option '+attr+' > '+txt+' </option>';
    });
    $("#"+select).empty().append( "<option></option>"+references ).select2({ theme:"bootstrap4", placeholder: "Seleccione o escriba el ítem...", allowClear: true });
}

function notification(){
    $.post( url+"ajax/general.ajax.php", {all:"sale", filter:'id > 43 and transaccionID = "0" and status_sale > 0'}, function (data) {
        let can = 0; let row = [];
        $.each( data, function (i,item) {
            can = can + 1;
            date = item['created'].toLowerCase().split(' ');
            row[i] = '<a href="'+url+'close-day/'+date[0]+'/0" class="dropdown-item"><i class="fas fa-receipt text-warning"></i> <span class="text-sm">FE80-'+item['sales']+' <small>('+item['created']+')</small></span></a>';
        });
        if( can > 0 ){
            $("#cantFEP").text(can);
            $("#itemFEP").html(row);
        }
    },"json");
}