$(document).ready(function() {
    $('#bannerstable').DataTable({
        responsive: true,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[1, "asc"]],
        columns: [
            { "data": "banner","orderable": false, "searchable": false, "width":"80px"},
            { "data": "texto" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"90px"}
        ]
    });
});

$(document).ready(function() {
    $('#usuariostable').DataTable({
        responsive: true,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[0, "asc"]],
        columns: [
            { "data": "imagem" , "orderable": false, "searchable": false, "width":"50px"},
            { "data": "nome" },
            { "data": "email" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"50px"}
        ]
    });
});

$(document).ready(function() {
    $('#condominiostable').DataTable({
        responsive: true,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[1, "asc"]],
        columns: [
            { "data": "imagem" , "orderable": false, "searchable": false, "width":"50px"},
            { "data": "nome" },
            { "data": "contato" },
            { "data": "telefone" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"150px"}
        ]
    });
});

$(document).ready(function() {
    $('#proprietariostable').DataTable({
        responsive: true,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[1, "asc"]],
        columns: [
            { "data": "imagem" , "orderable": false, "searchable": false, "width":"50px"},
            { "data": "nome" },
            { "data": "email" },
            { "data": "telefone" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"50px"}
        ]
    });
});

$(document).ready(function() {
    $('#unidadestable').DataTable({
        responsive: true,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[1, "asc"]],
        columns: [
            { "data": "id_proprietario"},
            { "data": "id_condominio" },
            { "data": "bloco" },
            { "data": "contato_emergencia" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"50px"}
        ]
    });
});

$(document).ready(function() {
    $('#documentostable').DataTable({
        responsive: true,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[1, "asc"]],
        columns: [
            { "data": "data"},
            { "data": "descricao" },
            { "data": "tipo_doc" },
            { "data": "arquivo" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"50px"}
        ]
    });
});

$(document).ready(function() {
    $('#contatostable').DataTable({
        responsive: true,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[0, "asc"]],
        columns: [
            { "data": "departamento" },
            { "data": "responsavel" },
            { "data": "email" },
            { "data": "telefone" },
            { "data": "skype" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"50px"}
        ]
    });
});


$(document).ready(function() {
    $('.mask-cpfCnpj').blur(function(){
        // O CPF ou CNPJ
        var cpf_cnpj = $(this).val();

        // Testa a validação e formata se estiver OK
        if ( formata_cpf_cnpj( cpf_cnpj ) ) {
            $(this).val( formata_cpf_cnpj( cpf_cnpj ) );
            swal("CPF - CNPJ", "Validação de Documento OK !!")
        } else {
            swal("CPF - CNPJ", "Número de Documento Inválido, digite somente números, tente novamente...")
            $(this).val('');
        }
    });
});
