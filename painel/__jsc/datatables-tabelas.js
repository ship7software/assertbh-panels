$(document).ready(function() {
    $('#usuariostable').DataTable({
        responsive: false,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[0, "asc"]],
        columns: [
            { "data": "imagem" , "orderable": false, "searchable": false, "width":"100px"},
            { "data": "nome" },
            { "data": "email" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"60px"}
        ]
    });
});

$(document).ready(function() {
    $('#condominiostable').DataTable({
        responsive: false,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[1, "asc"]],
        columns: [
            { "data": "imagem" , "orderable": false, "searchable": false, "width":"100px"},
            { "data": "nome" },
            { "data": "nome_sindico" },
            { "data": "telefone_sindico" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"120px"}
        ]
    });
});

$(document).ready(function() {
    $('#proprietariostable').DataTable({
        responsive: false,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[1, "asc"]],
        columns: [
            { "data": "imagem" , "orderable": false, "searchable": false, "width":"100px"},
            { "data": "nome" },
            { "data": "email" },
            { "data": "celular" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"90px"}
        ]
    });
});

$(document).ready(function() {
    $('#unidadestable').DataTable({
        responsive: false,
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
            { "data": "acoes", "orderable": false, "searchable": false, "width":"150px"}
        ]
    });
});

$(document).ready(function() {
    $('#cobrancatable').DataTable({
        responsive: false,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[1, "desc"]],
        columns: [
            { "data": "mes_ref"},
            { "data": "data" },
            { "data": "vencimento" },
            { "data": "valor" },
            { "data": "pagamento" },
            { "data": "valor_pago" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"150px"}
        ]
    });
});

$(document).ready(function() {
    $('#cobrancastable').DataTable({
        responsive: false,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[1, "desc"]],
        columns: [
            { "data": "data"},
            { "data": "id_proprietario"},
            { "data": "id_condominio" },
            { "data": "id_unidade" },
            { "data": "vencimento" },
            { "data": "valor" },
            { "data": "pagamento" },
            { "data": "valor_pago" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"50px"}
        ]
    });
});

$(document).ready(function() {
    $('#documentostable').DataTable({
        responsive: false,
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
            { "data": "acoes", "orderable": false, "searchable": false, "width":"60px"}
        ]
    });
});

$(document).ready(function() {
    $('#contatostable').DataTable({
        responsive: false,
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
            { "data": "acoes", "orderable": false, "searchable": false, "width":"60px"}
        ]
    });
});

$(document).ready(function() {
    $('#especies_titulotable').DataTable({
        responsive: false,
        "language": {
            "url": "Portuguese-Brasil.json"
        },
        processing: true,
        stateSave: true,
        order: [[0, "asc"]],
        columns: [
            { "data": "banco" },
            { "data": "codigo_banco" },
            { "data": "codigo_especie" },
            { "data": "sigla_boleto" },
            { "data": "descricao" },
            { "data": "acoes", "orderable": false, "searchable": false, "width":"60px"}
        ]
    });
});

$(document).on('click', '#delete_btn', function(){
    var thisElement = this;
    swal({
            title: "Deseja deletar esse registro ?",
            text: "Esse registro não poderá ser recuperado !",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim, delete !",
            cancelButtonText: "Não, cancele !",
            closeOnConfirm: false,
            closeOnCancel: false
        },

        function(isConfirm){
            if (isConfirm) {
                var id = $(thisElement).data('id');
                var tabela = $(thisElement).data('tabela');
                var pasta = $(thisElement).data('pasta');
                $.ajax( {
                    "type": "DELETE",
                    "url": "painel.php?exe="+pasta+"/index&delete="+id,
                    "success": function(){
                        swal("Deletado!", "O registro foi deletado com sucesso.", "success");
                        $(document).ajaxStop(function(){
                            setTimeout("window.location = 'painel.php?exe="+pasta+"/index'",1000);
                        });
                    }
                } );

            } else {
                swal("Cancelado!", "O registro não foi deletado. :)", "error");
            }
        }
    );
});


$(document).on('click', '#delete_remessa', function(){
    var thisElement = this;
    swal({
            title: "Deseja excluir essa remessa ?",
            text: "Esse registro não poderá ser recuperado !",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim, delete !",
            cancelButtonText: "Não, cancele !",
            closeOnConfirm: false,
            closeOnCancel: false
        },

        function(isConfirm){
            if (isConfirm) {
                var id = $(thisElement).data('id');
                var idcondominio = $(thisElement).data('idcondominio');
                var nomecond = $(thisElement).data('nomecond');
                var tabela = $(thisElement).data('tabela');
                var pasta = $(thisElement).data('pasta');
                $.ajax( {
                    "type": "DELETE",
                    "url": "painel.php?exe="+pasta+"/indexcond&id="+idcondominio+"&nomeCondominio="+nomecond+"&delete="+id,
                    "success": function(){
                        swal("Deletado!", "O registro foi deletado com sucesso.", "success");
                        $(document).ajaxStop(function(){
                            setTimeout("window.location = 'painel.php?exe="+pasta+"/indexcond&id="+idcondominio+"&nomecondominio="+nomecond+"'",1000);
                        });
                    }
                } );

            } else {
                swal("Cancelado!", "O registro não foi deletado. :)", "error");

            }

        }
    );
});

$(document).on('click', '#delete_boletos', function(){
    var thisElement = this;
    swal({
            title: "Deseja deletar esse registro ?",
            text: "Esse registro não poderá ser recuperado !",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim, delete !",
            cancelButtonText: "Não, cancele !",
            closeOnConfirm: false,
            closeOnCancel: false
        },

        function(isConfirm){
            if (isConfirm) {
                var id = $(thisElement).data('id');
                var idunidade = $(thisElement).data('idunidade');
                var tabela = $(thisElement).data('tabela');
                var pasta = $(thisElement).data('pasta');
                $.ajax( {
                    "type": "DELETE",
                    "url": "painel.php?exe="+pasta+"/index&id="+idunidade+"&delete="+id,
                    "success": function(){
                        swal("Deletado!", "O registro foi deletado com sucesso.", "success");
                        $(document).ajaxStop(function(){
                            setTimeout("window.location = 'painel.php?exe="+pasta+"/index&id="+idunidade+"'",1000);
                        });
                    }
                } );

            } else {
                swal("Cancelado!", "O registro não foi deletado. :)", "error");

            }

        }
    );
});

$(document).on('click', '#delete_prop', function(){
    var thisElement = this;
    swal({
            title: "Deseja deletar esse registro ?",
            text: "Esse registro não poderá ser recuperado !",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim, delete !",
            cancelButtonText: "Não, cancele !",
            closeOnConfirm: false,
            closeOnCancel: false
        },

        function(isConfirm){
            if (isConfirm) {
                var id = $(thisElement).data('id');
                var idcond = $(thisElement).data('idcond');
                var tabela = $(thisElement).data('tabela');
                var pasta = $(thisElement).data('pasta');
                $.ajax( {
                    "type": "DELETE",
                    "url": "painel.php?exe="+pasta+"/index&id="+idcond+"&delete="+id,
                    "success": function(){
                        swal("Deletado!", "O registro foi deletado com sucesso.", "success");
                        $(document).ajaxStop(function(){
                            setTimeout("window.location = 'painel.php?exe="+pasta+"/index&id="+idcond+"'",1000);
                        });
                    }
                } );

            } else {
                swal("Cancelado!", "O registro não foi deletado. :)", "error");

            }

        }
    );
});

$(document).on('click', '#delete_documentos', function(){
    var thisElement = this;
    swal({
            title: "Deseja deletar esse registro ?",
            text: "Esse registro não poderá ser recuperado !",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim, delete !",
            cancelButtonText: "Não, cancele !",
            closeOnConfirm: false,
            closeOnCancel: false
        },

        function(isConfirm){
            if (isConfirm) {
                var id = $(thisElement).data('id');
                var idcondominio = $(thisElement).data('idcondominio');
                var tipodoc = $(thisElement).data('tipodoc');
                var tabela = $(thisElement).data('tabela');
                var pasta = $(thisElement).data('pasta');
                $.ajax( {
                    "type": "DELETE",
                    "url": "painel.php?exe="+pasta+"/index&delete="+id,
                    "success": function(){
                        swal("Deletado!", "O registro foi deletado com sucesso.", "success");
                        $(document).ajaxStop(function(){
                            setTimeout("window.location = 'painel.php?exe="+pasta+"/documentos&tipo="+tipodoc+"&id="+idcondominio+"'",1000);
                        });
                    }
                } );

            } else {
                swal("Cancelado!", "O registro não foi deletado. :)", "error");

            }

        }
    );
});

$(document).ready(function() {
    $('#multiple-checkboxes').multiselect({
        nonSelectedText: 'Nenhum selecionado'
    });

    $('.mask-cpfCnpj').blur(function(){
        // O CPF ou CNPJ
        var cpf_cnpj = $(this).val();

        // Testa a validação e formata se estiver OK
        if ( formata_cpf_cnpj( cpf_cnpj ) ) {
            $(this).val( formata_cpf_cnpj( cpf_cnpj ) );
        } else {
            swal("CPF - CNPJ", "Número de Documento Inválido, digite somente números, tente novamente...")
            $(this).val('');
        }
    });
});
