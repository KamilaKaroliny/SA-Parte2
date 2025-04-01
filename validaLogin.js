function validarFormulario() {

    //Pegar os dados!

    const nome = document.getElementById('email_gestor').value.trim();
    const idade = parseInt(document.getElementById('senha_gestor').value, 10);

    //Processar os dados (obrigatoriedades)!

    if(!nome){
        alert('Por favor, preencha o nome.');
        return;
    }else{
        console.log(nome);
    }

    if(!cpf || cpf.length !==11 || isNaN(cpf)){
        alert('Por favor, insira um CPF válido com 11 digitos');
        return;
    }else{
        console.log(cpf);
    }

    if(isNaN(idade) || idade < 21 && idade > 0){
        alert('A idade deve ser um número maior que trinta');
        return;
    }else{
        console.log(idade);
    }

    if(isNaN(experiencia) || experiencia < 3 && experiencia > 0){
        alert('Os anos de experiência devem ser maior que três ou igual');
        return;
    }else{
        console.log(experiencia);
    }

    //Devolver

    alert('Formulário enviado com sucesso')

}