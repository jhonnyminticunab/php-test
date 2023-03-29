<div id="box_print">
    <div class="txt_center txt_lg"> * </div>
</div>

<script>

   $(function () {

        setTimeout( print , 1000);
        function print (){
            onPrintFinished = function(printed){ window.history.back(); };
            onPrintFinished( window.print() );
        }

    });

</script>
