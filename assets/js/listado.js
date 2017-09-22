   
    $(function(){
        $('#filtro-avanzado-top-btn').hide();

    $('#export-sel-btn').click(function(e){
        e.preventDefault();
        
        $('#frm-export-sel').submit();
    });
    
    $('#filtro-avanzado-top-btn').click(function(e){
        e.preventDefault();
        $('#frm-avanzado').submit();
    });
    
    
    $('#avanzado-trigger').click(function(e){
//        console.log('entro');
//       $('#searchloader-avanzado').show(); //loading
        e.preventDefault();
       if($('#filtros-avanzado').is(":hidden")){
         
        
        
        $('#filtro-avanzado-top-btn').show();
         $('#filtros-avanzado').show();
         $('.scroll-pane').jScrollPane(); 
         
         
         $('.prov-toggle').each(function(){
            if($(this).prop('checked')){
                $('#p-'+$(this).val()).show();
            }else{
                $('#p-'+$(this).val()).hide();
            }
            $('#p-'+$(this).val()).jScrollPane();
        });
        
        
//        $('#searchloader-avanzado').hide(); //endloading
       }else{
        $('#filtro-avanzado-top-btn').hide();
        $('#filtros-avanzado').hide();
        }
        
//        console.log('salgo');
    });
    
    
    $('#all_checks').change(function(){
//        console.log($('#all_checks:checked').length);
        if($('#all_checks:checked').length == '0')
            $('.table input.item-chk').prop('checked', false);
        else
            $('.table input.item-chk').prop('checked', true);
    });
    

                         
        });
$(function(){
    
   
   $('.anular-reporte').click(function(e){
       
       return confirm('Estas seguro de querer anular esta reporte?');
       
   });
    
   $('.ver-reporte').click(function(e){
       e.preventDefault();
       var id = $(this).attr('data-id');
       var content = $(this).html();
       var img = '<img src="'+site_url+'/assets/img/searchloader.gif" />';
       $(this).html(img);
       var link = $(this);

        $.get(site_url+"/administracion/ajax_ficha_reporte/"+id, function(data) {
           $('#ficha-usuario').html(data);
           $('#datosUsuarios').modal();
            
        });
        $(this).html(content);
        return false;
        
    });
    
    
    $('.dropdown-filtros').on('click', function(e) {
            e.stopPropagation();
    });
});
