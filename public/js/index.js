var tabelaTorcedores;

/*AJAX*/
function btnSubmitForm(){

    $('#progressBar').css('display','block');

    toastr.warning('Indexando torcedores. Por favor aguarde (Isso pode demorar alguns minutos).', 'Aviso', {positionClass: "toast-bottom-right"});

    let filename = $("#nomeArquivo").val();

    let extension = filename.replace(/^.*\./, '');
    if (extension === filename) {
        extension = '';
    } else {
        extension = extension.toLowerCase();

    }

    let reader = new FileReader();

    let url;

    reader.onloadend = function(){
        url = reader.result;
    };

    let file_data = $('#arquivoAnexado').prop('files')[0];

    let form_data = new FormData();

    form_data.append('file', file_data);

    if(file_data){
        reader.readAsDataURL(file_data);
    }

    switch (extension) {
        case 'xml':
            $.ajax({
                url: '../ajax/ajaxRecebeXML.php',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(resposta){

                    resposta = JSON.parse(resposta);

                    if(resposta[0] !== false){

                        let array = resposta[2];

                        array.forEach(function (e) {

                            adicionaTorcedorNaTabela(e.nome,e.documento,e.cep,e.endereco,e.bairro,e.cidade,e.uf,e.telefone,e.email,e.ativo);
                        });

                        toastr.success(resposta[1], 'Aviso', {positionClass: "toast-bottom-right"});
                    }else{
                        toastr.error(resposta[1], 'Erro', {positionClass: "toast-bottom-right"});
                    }
                    $('#progressBar').css('display','none');
                }
            });
        break;

        case 'xlsx':
            $.ajax({
                url: '../ajax/ajaxIndexaTorcedores.php',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(resposta){

                    resposta = JSON.parse(resposta);

                    console.log(resposta);

                    if(resposta[0] !== false){

                        let array = resposta[2];
                        var i;

                        toastr.success(resposta[1], 'Aviso', {positionClass: "toast-bottom-right"});

                        for(i = 0; i < array[1].length; i++){
                            adicionaTorcedorNaTabela(array[0][i],array[1][i],array[2][i],array[3][i],array[4][i],array[5][i],array[6][i],array[7][i],array[8][i],array[9][i],array[10][i]);
                        }
                    }else{
                        toastr.error(resposta[1], 'Erro', {positionClass: "toast-bottom-right"});
                    }
                    $('#progressBar').css('display','none');
                }
            });
        break;

        case '':
            toastr.error('', 'Erro', {positionClass: "toast-bottom-right"});
    }

}

function enviaAlerta(){
    let nome = $("#nomeAlerta").val();
    let email = $("#emailAlerta").val();
    let assunto = $("#assuntoAlerta").val();
    let corpo = $("#corpoAlerta").val();
    let broadcast = false;

    if($('#checkAll').is(':checked')){
        broadcast = true;
    }

    $.post('../ajax/ajaxEnviaEmail.php',
        {
            nome,
            email,
            assunto,
            corpo,
            broadcast
        },
    resposta => {

            // resposta = JSON.parse(resposta);

            if(resposta.match('EMAILOK') !== null){

                $("#modalAlertaTorcedor").modal('hide');

                toastr.success('E-mail(s) enviado(s) com sucesso', 'Aviso', {positionClass: "toast-bottom-right"});
            }else{
                toastr.error('Erro ao enviar e-mail(s).', 'Erro', {positionClass: "toast-bottom-right"});
            }
        });
}

function editaTorcedor(torcedor){

    let botao       = $(torcedor);
    let id          = botao.attr('name');
    let nome        = $('#nome').val();
    let documento   = $('#documento').val();
    let cep         = $('#cep').val();
    let endereco    = $('#endereco').val();
    let bairro      = $('#bairro').val();
    let cidade      = $('#cidade').val();
    let uf          = $('input[name=uf]').val();
    let telefone    = $('#telefone').val();
    let email       = $('#email').val();
    let ativo       = $('input[type=radio]:checked').val();

    $.post('../ajax/ajaxEditaTorcedor.php',
    {
        id,
        nome,
        documento,
        cep,
        endereco,
        bairro,
        cidade,
        uf,
        telefone,
        email,
        ativo
    },
    resposta => {
        resposta = JSON.parse(resposta);

        console.log(resposta);

        if(resposta[0] !== false){

            atualizaTorcedorNaTabela(id, nome, documento, cep, endereco, bairro, cidade, uf, telefone, email, ativo);

            $("#modalEditaTorcedor").modal('hide');

            toastr.success(resposta[1], 'Aviso', {positionClass: "toast-bottom-right"});
        }else{
            toastr.error(resposta[1], 'Erro', {positionClass: "toast-bottom-right"});
        }
    });

}

function excluiTorcedor(){

    let id = $('#btnEditaTorcedor').attr('name');

    $.post('../ajax/ajaxExcluiTorcedor.php',
        {
            id
        },
        resposta => {
            resposta = JSON.parse(resposta);

            if(resposta[0] !== false){
                //função de remover da tabela

                $("#modalConfirmaExclusao").modal('hide');
                $("#modalEditaTorcedor").modal('hide');
                excluiTorcedorNaTabela(id);

                toastr.success(resposta[1], 'Aviso', {positionClass: "toast-bottom-right"});
            }else{
                toastr.error(resposta[1], 'Erro', {positionClass: "toast-bottom-right"});
            }
        });
}

/*Interações com a Tabela*/
function adicionaTorcedorNaTabela(id, nome, documento, cep, endereco, bairro, cidade, uf, telefone, email, ativo){
    tabelaTorcedores.row.add($(
        `<tr id="${id}">
            <td>${nome}</td>
            <td>${documento}</td>
            <td>${cep}</td>
            <td>${endereco}</td>
            <td>${bairro}</td>
            <td>${cidade}</td>
            <td>${uf}</td>
            <td>${telefone}</td>
            <td>${email}</td>
            <td>${ativo}</td>
            <td><a onclick="modalEditaTorcedor(this)"><i class="fas fa-edit"></i></a></td>
        </tr>`)[0]).draw(false);
}

function atualizaTorcedorNaTabela(id, nome, documento, cep, endereco, bairro, cidade, uf, telefone, email, ativo){

    let linha = $('#tabelaTorcedores').find('tr[id='+id+']');

    linha.find('td:eq(0)').text(nome);
    linha.find('td:eq(1)').text(documento);
    linha.find('td:eq(2)').text(cep);
    linha.find('td:eq(3)').text(endereco);
    linha.find('td:eq(4)').text(bairro);
    linha.find('td:eq(5)').text(cidade);
    linha.find('td:eq(6)').text(uf);
    linha.find('td:eq(7)').text(telefone);
    linha.find('td:eq(8)').text(email);
    linha.find('td:eq(9)').text(ativo);
}

function excluiTorcedorNaTabela(id){

    tabelaTorcedores.row($('#'+id)).remove().draw();
}

/*Modais*/
function modalAlertaTorcedor() {

    $('#modalAlertaTorcedor').modal();
}

function modalEditaTorcedor(torcedor){

    let botao = $(torcedor);
    let id = botao.parent().parent().attr('id');

    $.post('../ajax/ajaxGetTorcedor.php',
        {
            id
        },
        resposta => {
            resposta = JSON.parse(resposta);

            console.log(resposta);
            if(resposta[0] !== false){

                let nome        = resposta[1][0]['nome'];
                let documento   = resposta[1][0]['documento'];
                let cep         = resposta[1][0]['cep'];
                let endereco    = resposta[1][0]['endereco'];
                let bairro      = resposta[1][0]['bairro'];
                let cidade      = resposta[1][0]['cidade'];
                let uf          = resposta[1][0]['uf'];
                let telefone    = resposta[1][0]['telefone'];
                let email       = resposta[1][0]['email'];
                let ativo       = resposta[1][0]['ativo'];

                $('#nome').val(nome);
                $('#documento').val(documento);
                $('#cep').val(cep);
                $('#endereco').val(endereco);
                $('#bairro').val(bairro);
                $('#cidade').val(cidade);
                $('#telefone').val(telefone);
                $('#email').val(email);

                $('input[name=uf]').val(uf);
                $('label').addClass('active');

                if(ativo === "SIM"){
                    $('#ativoSIM').prop("checked","checked");
                }else{
                    $('#ativoNAO').prop("checked","checked");
                }

                $('#btnEditaTorcedor').prop('name', id);

                $('#modalEditaTorcedor').modal('show');
            }else{
                toastr.error(resposta[1], 'Erro', {positionClass: "toast-bottom-right"});
            }
        });

}

function modalConfirmaExclusao() {

    $('#modalConfirmaExclusao').modal();
}

$(document).ready(function(){

    tabelaTorcedores = $('#tabelaTorcedores').DataTable({
        "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        },
        "columnDefs": [
            {"className": "dt-center", "targets": "_all"}
        ]
    });
    $('select[name=tabelaTorcedores_length]').attr("class", "browser-default");

    $("#checkAll").click(function () {
        if($('#checkAll').is(':checked') === true){
            $("#emailAlerta").prop('disabled', true);
        }else{
            $("#emailAlerta").prop('disabled', false);
        }
    });
});