$(document).ready( function () {

    $("#loginForm").submit(function (event) {
        event.preventDefault();

        let usuario = $('#formuser').val();
        let senha = $('#formpass').val();

        $('#progressBarLogin').css('display','block');

        $.post('../ajax/ajaxLogin.php',
            {
                usuario,
                senha
            },
            data => {

                let newdata = JSON.parse(data);

                switch (newdata[1]) {

                    case 'LOGGED':{
                        console.log(newdata[2]);
                        window.location.href='../../index.php';
                        break;
                    }

                    case 'INCORRECTAUT':{
                        toastr.error(newdata[2], 'Aviso', {positionClass: "toast-bottom-right"});
                        break;
                    }

                    case 'CNNTCONN':{
                        toastr.error(newdata[2], 'Erro', {positionClass: "toast-bottom-right"});
                        break;
                    }

                }
                $('#progressBarLogin').css('display','none');

            });

    });

    $('.fa').click(function(){

        if($('.fa').parent().find('input').attr('type') === 'password'){
            $('.fa').parent().find('input').attr('type', 'text');
            $('.fa').attr('class', 'fa fa-eye fa-lg white-text icon-senha');
            $('.fa').attr('title', 'Ocultar senha');
        }else{
            $('.fa').parent().find('input').attr('type', 'password');
            $('.fa').attr('class', 'fa fa-eye-slash fa-lg white-text icon-senha');
            $('.fa').attr('title', 'Mostrar senha');
        }
    });
});