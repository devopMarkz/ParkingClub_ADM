function validarFormulario() {
    // Capturar os valores dos campos do formulário
    var nome = document.getElementById('nome').value;
    var cpf = document.getElementById('cpf').value;
    var email = document.getElementById('email').value;
    var senha = document.getElementById('senha').value;
    var confirmaSenha = document.getElementById('confirmaSenha').value;

    // Validar o CPF
    if (cpf.length !== 11) {
        alert('CPF incorreto! O CPF deve conter exatamente 11 dígitos.');
        return false;
    }

    // Verificar se a senha e a confirmação de senha coincidem
    if (senha !== confirmaSenha) {
        alert('As senhas digitadas não coincidem. Por favor, tente novamente.');
        document.getElementById('senha').value = '';
        document.getElementById('confirmaSenha').value = '';
        return false;
    }

    // Se passar pela validação, enviar o formulário
    return true;
}