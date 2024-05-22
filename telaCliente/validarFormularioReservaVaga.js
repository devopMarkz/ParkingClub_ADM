function validarFormularioReservaVaga() {
    var dataHoraInput = document.getElementById("data-hora").value;
    var dataHoraSelecionada = new Date(dataHoraInput);

    // Obtém a data e hora atuais
    var dataHoraAtual = new Date();

    // Compara se a data e hora selecionada é anterior à data e hora atual
    if (dataHoraSelecionada < dataHoraAtual) {
        alert("Por favor, selecione uma data e hora futura.");
        return false; // Impede o envio do formulário
    }

    return true; // Permite o envio do formulário se a validação passar
}