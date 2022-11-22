/* -----MOSTRAR ERRO----- */
// QUANDO CARRAGA-SE A PÁGINA COM O ERRO A FUNÇÃO FAZ ELE DESAPARECER EM 5s
const span_erro_login = document.querySelector('.invalid');
function erro_login(){
    setTimeout(()=>{
        if(span_erro_login === null){
            console.log('sem erro');
        }else{
            span_erro_login.style.display = 'none';
        }
    },5000);
}

let email_x = document.querySelector("input#email").value;
if(email_x != ''){
    document.querySelector(".email_label").style.transform = 'translateY(-50%)';
    document.querySelector(".email_label").style.fontSize = '.85rem';
    document.querySelector(".email_label").style.background = 'var(--light)';
}

// MOSTRAR SENHA
const cadeado = document.querySelector('.cadeado');

cadeado.addEventListener('click', ()=>{
    if(cadeado.classList.contains("fa-lock")){
        cadeado.classList.replace("fa-lock", "fa-unlock");
        document.querySelector('#senha').type = 'text';
    }else{
        cadeado.classList.replace("fa-unlock", "fa-lock");
        document.querySelector('#senha').type = 'password';
    }

    
})

// VALIDAR O FORMULÁRIO PARA LOGAR E APLICANDO AS DEVIDAS MENSAGENS DE ERROS E ESTILOS
document.querySelector('form').addEventListener('submit', e =>{
    console.log('enviar o formulário');

    // não vai enviar o formulário
    // e.preventDefault();
});

// PEGA TODOS OS INPUTS COM REQUIRED
const fields = document.querySelectorAll("[required]");

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
}