/**
 * Created by Mirko on 12.5.2017.
 */
$(document).ready(function(){
    // forma za komentare je hajdovana !!!
    $('.komentari').hide();
   $('#add_comment').click(function(){
       $('.komentari').toggle();
   });
    // komentari korisnika su takođe hajdovani !!!
    $('.user_comment').hide();
    $('#all_comment').click(function(){
       $('.user_comment').toggle();
    });
    // provera input polja
    $('#add_comm').click(function(){
       //alert('Provera');
        if($('#autor').val()=='')
            $('#autorSpan').html("<font style='color:red'>* Obavezno polje !!</font>");
        else if($('#autor').val().indexOf('|')>-1||$('#autor').val().indexOf('/')>-1||$('#autor').val().indexOf('"')>-1||$('#autor').val().indexOf("'")>-1)
            $('#autorSpan').html("<font style='color:red'>Nedozvoljeni karakter !!</font>");
        else if($('#tekst').val()=='')
            $('#komSpan').html("<font style='color:red'>* Obavezno polje !!</font>");
        else if($('#tekst').val().indexOf('|')>-1||$('#tekst').val().indexOf('/')>-1||$('#tekst').val().indexOf('"')>-1||$('#tekst').val().indexOf("'")>-1)
            $('#komSpan').html("<font style='color:red'>Nedozvoljeni karakter !!</font>");
        else{
            $.post('ajax.php?funkcija=comment',{idVesti:$(this).attr('idVesti'),autor:$('#autor').val(),tekst:$('#tekst').val()},function(response){
                if(response=='1')
                {
                    $('#info_msg').html(response);
                }
                else
                {
                    $('#info_msg').html(response);
                }
                clearInputFields();
            });
        }
    });
    function clearInputFields()
    {
        $('input[type=text],textarea').each(function(){
           $(this).val('');
        });
    }
    ///paginacija !!!!
    $('.page').each(function(){
        $(this).css('background-color','#000');
    });
    $('.page').click(function(){
        $('.page').each(function(){
            $(this).css('background-color','#000');
        });
        $(this).css('background-color','#094186');
        //slanje get parametra za paginaciju strana !!!
        $.get('ajaxpaging.php?strana='+$(this).attr('strana'),function(response){
            $('#response').html(response);
        });
    });
});
// like and dislike !!!!
function doRating(id,type)
{
    //alert('provera');
    $.post('ajax2.php',{id:id,type:type},function(response){
        $('#'+id+'_'+type).html(response);
    });
}



