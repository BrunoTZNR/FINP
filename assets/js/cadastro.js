//MOSTRAR SECTION pf_container E pj_container e define os required necessários
const input_tipo_title = [document.querySelector('#pf'), document.querySelector('#pj')];
const display_tipo = [document.querySelector('.pf_container'), document.querySelector('.pj_container')];
const content_tipo = [document.querySelector('#cpf'), [document.querySelector('#cnpj'), document.querySelector('#nm_empresa')]];

input_tipo_title[0].addEventListener('change',()=>{
    content_tipo[1][0].removeAttribute("required");
    content_tipo[1][1].removeAttribute("required");

    content_tipo[0].setAttribute("required", "");

    display_tipo[0].style.display = 'flex';
    display_tipo[1].style.display = 'none';
});

input_tipo_title[1].addEventListener('change',()=>{
    content_tipo[0].removeAttribute("required");

    content_tipo[1][0].setAttribute("required", "");
    content_tipo[1][1].setAttribute("required", "");

    display_tipo[1].style.display = 'flex';
    display_tipo[0].style.display = 'none';
});
/* ------------------------------------------------------------------------ */

// MASCARA CPF, CPNJ, TELEFONE E CEP
// content_tipo[0] -> cpf \\\\ content_tipo[1][0] -> cnpj
content_tipo[0].addEventListener('keypress', ()=>{
    let cpf_length = content_tipo[0].value.length;
    //123.123.123-12
    //01234567890123
    if(cpf_length == 3 || cpf_length == 7){
        content_tipo[0].value += '.';
    }else if(cpf_length == 11){
        content_tipo[0].value += '-';
    }
});

content_tipo[1][0].addEventListener('keypress', ()=>{
    let cnpj_length = content_tipo[1][0].value.length;
    //12.123.123/1234-12
    //012345678901234567
    if(cnpj_length === 2 || cnpj_length === 6){
        content_tipo[1][0].value += '.';
    }else if(cnpj_length === 10){
        content_tipo[1][0].value += '/';
    }else if(cnpj_length === 15){
        content_tipo[1][0].value += '-';
    }
});

const telefone_input = document.querySelector('#telefone');

telefone_input.addEventListener('keypress', ()=>{
    let telefone_length = telefone_input.value.length;
    //(61) 12345-1234
    //012345678901234
    if(telefone_length == 0){
        telefone_input.value += '(';
    }else if(telefone_length === 3){
        telefone_input.value += ')';
    }else if(telefone_length === 9){
        telefone_input.value += '-';
    }
});

const cep_input = document.querySelector('#cep');

cep_input.addEventListener('keypress', ()=>{
    let cep_length = cep_input.value.length;
    //12345-123
    //123456789
    if(cep_length === 5){
        cep_input.value += '-';
    }
});
/* ------------------------- */

// PEGA TODOS OS INPUTS COM REQUIRED
/*const fields = document.querySelectorAll("[required]");

for(let field of fields){
    // CHAMA A VALIDAÇÃO CASO O INPUT SEJA INVÁLIDO
    field.addEventListener('invalid', e =>{
        // ELEMINA O BUBLE (CAIXA DE VERIFICAÇÃO)
        e.preventDefault();

        // CHAMA A VALIDAÇÃO
        customValidation(e);
    });

    // CHAMA A VALIDAÇÃO SE O INPUR FOR DESFOCADO
    field.addEventListener('blur', customValidation);
}

function customValidation(e){
    // DECLARA O FIELD COMO O INPUT QUE FOI CLICKADO
    const field = e.target;

    // CHAMA A FUNÇÃO DE VALIDAÇÃO LEAVNDO O FIELD COMO PARAMETRO
    const validation = validateField(field);
    validation();
}

function validateField(field){
    // LÓGICA PARA VERIFICAR SE EXISTEM ERROS
    function verifyErrors(){
        let foundError = false;

        for(let error in field.validity){
            // VERIFICA SE HÁ ALGUM ERRO SE O FIELD NÃO FOR VÁLIDO
            if(field.validity[error] && !field.validity.valid){
                foundError = error;
            }
        }

        // console.log(foundError);

        // RETORNA O ERRO
        return foundError;
    }

    function customMessage(typeError){
        const messages = {
            // COLOCAR OS TIPOS DE INPUTS E OS RESPECTIVOS ERROS COM SUA MENSAGENS
            text: {
                valueMissing: "Preencha este campo"
            },
            email: {
                valueMissing: "Email é brigatório",
                typeMismatch: "Digite um email válido"
            },
            password: {
                valueMissing: "Preencha este campo",
                tooShort: "A senha deve ter 5 caracteres"
            }
        }

        // RETORNA O TIPO DO FIELD E A MENSAGEM DO ERRO
        return messages[field.type][typeError];
    }

    function setCustomMessage(message){
        // SELECIONA A CAIXA DE SPAN DE ACORDO COM O FIELD SENDO O PAI DELE
        const spanError = field.parentNode.querySelector(".error");

        // ADICIONA A MENSAGEM DE ERRO
        if(message){
            // CASO HAJA ERRO
            spanError.classList.add('active');
            spanError.innerHTML = message;
        }else{
            // CASO NÃO HAJA ERRO
            spanError.classList.remove('active');
            spanError.innerHTML = "";
        }
    }

    return function(){
        // VERIFICA SE HÁ ALGUM ERRO
        const error = verifyErrors();
        
        if(error){
            // CHAMA A MENSAGME DE ERRO
            const message = customMessage(error);
            setCustomMessage(message);

            // STYLE SE HOUVER ALGUM ERRO
            field.style.borderColor = 'red';
            field.parentNode.querySelector(".login_label").style.color = 'red';

            console.log(message);

            if(field.value != ''){
                field.parentNode.querySelector(".login_label").classList.add("email_focus");
            }else{
                field.parentNode.querySelector(".login_label").classList.remove("email_focus");
            }

            if(message == 'Preencha este campo'){
                field.parentNode.querySelector(".cadeado").style.color = 'red';
            }
        }else{
            // RESETA A MENSAGEM DE ERROR
            setCustomMessage();

            //STYLE SE NÃO HOUVER NENHUM ERRO
            // field.style.borderColor = 'green';
            field.parentNode.querySelector(".login_label").classList.add("email_focus");
            field.style.borderColor = 'var(--sec-2)';
            field.parentNode.querySelector(".login_label").style.color = 'var(--sec-2)';

            // SO MUDARÁ A COR DO I QUANDO NÃO HOUVER ERROS DO FIELD TYPE PASSWORD
            if(field.type == 'password'){
                field.parentNode.querySelector(".cadeado").style.color = 'var(--sec-2)';
            }
        }
    }
}*/