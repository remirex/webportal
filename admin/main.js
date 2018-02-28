$(document).ready(function(){
   //alert('Radi !!!'); 
    $('#regist').click(function(){
        if($('#fname').val()=='')
        {
            $('#errfname').html("<font style='color:red'>* Obavezno polje !!</font>");
        }
        else if($('#fname').val().indexOf('|')>-1||$('#fname').val().indexOf('/')>-1||
                $('#fname').val().indexOf("'")>-1||$('#fname').val().indexOf('<')>-1||
                $('#fname').val().indexOf('>')>-1||$('#fname').val().indexOf('"')>-1)
        {
            $('#errfname').html("<font style='color:red'>Nedozvoljen karakter !!</font>");
        }
        // provera input polja last_name !!!
        else if($('#lname').val()=='')
        {
            $('#errlname').html("<font style='color:red'>* Obavezno polje !!</font>");
        }
        else if($('#lname').val().indexOf('|')>-1||$('#lname').val().indexOf('/')>-1||
                $('#lname').val().indexOf('"')>-1||$('#lname').val().indexOf('<')>-1||
                $('#lname').val().indexOf('>')>-1||$('#lname').val().indexOf("'")>-1)
        {
            $('#errlname').html("<font style='color:red'>Nedozvoljen karakter !!</font>");
        }
        // provera input polja email !!!
        else if($('#mail').val()=='')
        {
            $('#errMail').html("<font style='color:red'>* Obavezno polje !!</font>");
        }
        else if($('#mail').val().indexOf('|')>-1||$('#mail').val().indexOf('/')>-1||
                $('#mail').val().indexOf('"')>-1||$('#mail').val().indexOf('<')>-1||
                $('#mail').val().indexOf('>')>-1||$('#mail').val().indexOf("'")>-1)
        {
            $('#errMail').html("<font style='color:red'>Nedozvoljen karakter !!</font>");
        }
        // provera formata unosa email adrese !!!
        else if($('#mail').val().indexOf('@')==-1 || $('#mail').val().indexOf('.')==-1)
        {
            $('#errMail').html("<font style='color:red'>Email mora biti u formatu text@text.domen !!</font>");
        }
        // provera input polja password !!!
        else if($('#pass1').val()=='')
        {
            $('#errPass').html("<font style='color:red'>* Obavezno polje !!</font>");
        }
        else if($('#pass1').val().indexOf('|')>-1||$('#pass1').val().indexOf('/')>-1||
                $('#pass1').val().indexOf('"')>-1||$('#pass1').val().indexOf('<')>-1||
                $('#pass1').val().indexOf('>')>-1||$('#pass1').val().indexOf("'")>-1)
        {
            $('#errPass').html("<font style='color:red'>Nedozvoljen karakter !!</font>");
        }
        // provera input polja repeat password !!!
        else if($('#pass2').val()=='')
        {
            $('#errPass2').html("<font style='color:red'>* Potvrdite vašu lozinku !!</font>");
        }
        else if($('#pass1').val()==$('#pass2').val()){
            // snimanje korisničkih podataka u bazu !!!
            $.post('ajax.php?funkcija=register',{first_name:$('#fname').val(),last_name:$('#lname').val(),email:$('#mail').val(),password:$('#pass1').val()},function(response){
                if(response=="1"){
                    $('#info').html("<font style='color:green'>Uspešna registracija korisnika</font>");
                }
                else{
                    $('#info').html("<font style='color:red'>Neuspešna registracija</font>");
                }
                clearInterval();
            });
        }
    });

    // provera postojanja email-a !!!
    $('#mail').keyup(function(){
        $.post('ajax.php?funkcija=proveriEmail',{email:$(this).val()},function(response){
            if(response=="postoji")
            {
                $('#regist').prop('disabled',true);
                $('#exist').html("<font style='color:red'>Email adresa već postoji u bazi !!</font>");
            }
            else
            {
                $('#regist').prop('disabled',false);
            }
        });
    });
    // provera broja karaktera u passwordu,ograničenje sedam karaktera !!!
    $('#pass1').keyup(function(){
       if($('#pass1').val().length <=7)
           $('#errPass').html("<font style='color:red'>Broj karaktera mora biti veći od sedam !!</font>");
        else $('#errPass').html("<font style='color:green'>Sve je ok<font>");
    });
    // provera unosa ponovljenje lozinke !!!
    $('#pass2').keyup(function(){
       if($('#pass1').val()!=$('#pass2').val())
           $('#errPass2').html("<font style='color:red'>Lozinke se ne poklapaju !!!</font>");
        else $('#errPass2').html("<font style='color:green'>Sve je ok</font>");
    });
    function clearInterval()
    {
        $('input[type=text],input[type=email],input[type=password]').each(function(){
           $(this).val('');
        });
    }
    // login korisnika !!!
    $('#login').click(function(){
        // provera input polja email !!!
        if($('#email').val()=='')
        {
            $('#erremail').html("<font style='color:red'>* Obavezno polje !!</font>");
        }
        else if($('#email').val().indexOf('|')>-1||$('#email').val().indexOf('/')>-1||
                $('#email').val().indexOf('"')>-1||$('#email').val().indexOf("'")>-1||
                $('#email').val().indexOf('>')>-1||$('#email').val().indexOf('<')>-1)
        {
            $('#erremail').html("<font style='color:red'>Nedozvoljen karakter !!</font>");
        }
        // provera formata unosa email adrese !!!
        else if($('#email').val().indexOf('@')==-1 || $('#email').val().indexOf('.')==-1)
        {
            $('#erremail').html("<font style='color:red'>Email mora biti u formatu text@text.domen !!</font>");
        }
        else if($('#pass').val()=='')
            {
                $('#passwordSpan').html("<font style='color:red'>* Obavezno polje !!</font>"); 
            }
        else if($('#pass').val().indexOf('|')>-1||$('#pass').val().indexOf('/')>-1||
                $('#pass').val().indexOf('"')>-1||$('#pass').val().indexOf("'")>-1||
                $('#pass').val().indexOf('>')>-1||$('#pass').val().indexOf('<')>-1)
            {
                $('#passwordSpan').html("<font style='color:red'>Nedozvoljen karakter !!</font>"); 
            }
        else{
            // provera postojanja korisnika u bazi !!!
            $.post('ajax.php?funkcija=login',{mail:$('#email').val(),pass:$('#pass').val()},function(response){
               if(response=='index.php')
                   window.location = '/portal/index.php';
                else $('#infolog').html("<font style='color:red'>Ne postoji korisnik sa ovim podacima</font>");
            });
        }
    });
});