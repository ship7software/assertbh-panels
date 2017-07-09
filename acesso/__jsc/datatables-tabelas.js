$(document).ready(function() {
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
