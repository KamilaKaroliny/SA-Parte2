function validarFormulario() {

    //Pegar os dados!

    const nome = document.getElementById('email_gestor').value.trim();
    const idade = parseInt(document.getElementById('senha_gestor').value, 10);

    //Processar os dados (obrigatoriedades)!

    if(!email){
        alert('Por favor, preencha o nome.');
        return;
    }else{
        console.log(email);
    }

    if(!senha){
        alert('Por favor, preencha o nome.');
        return;
    }else{
        console.log(senha);
    }

    //Devolver

    alert('Formulário enviado com sucesso')

}