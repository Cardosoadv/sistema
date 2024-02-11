const siteUrl = "http://localhost/sistema/sistema";

function inputData(data){
    // Expressão regular para extrair partes da data
    const regex = /^(\d{1,2})(\d{1,2})(\d{4})$/;

    // Extrair dia, mês e ano da string
    const partesData = regex.exec(data);
    if (!partesData) {
        return "Data inválida";
    }
    const dia = partesData[1];
    const mes = partesData[2];
    const ano = partesData[3];

    // Retornar data formatada
    return `${dia}/${mes}/${ano}`;
}

function inputTelefone(fone){
const regex = /^(\d{2})(\d{4})(\d{4})$/;
const partesTel = regex.exec(fone);
if (!partesTel){
    return "Telefone inválido!";
}
const ddd = partesTel[1];
const parte1 = partesTel[2];
const parte2 = partesTel[3];

//retornar telefone formatado
return `(${ddd}) ${parte1}-${parte2}`;
}


//formata o valor para o padrão brasileiro
function formataValor(valor) {
    var valorBr = valor.replace(".", ",");
    const arrvbr = valorBr.split(",");
    const inteiros = arrvbr[0];
    const decimais = arrvbr[1] || "00"; // garante que há pelo menos dois dígitos decimais
    const inteirosArr = inteiros.split("");
    if (inteirosArr.length > 6) {
        inteirosArr.splice(inteirosArr.length - 6, 0, "."); // insere um ponto antes dos últimos 3 dígitos
    }
    if (inteirosArr.length > 3) {
        inteirosArr.splice(inteirosArr.length - 3, 0, "."); // insere um ponto antes dos últimos 3 dígitos
    }
    const valorFormatado = inteirosArr.join("") + "," + decimais; // junta os elementos do array em uma string novamente
    console.log(valorFormatado);
    return valorFormatado;
}

function dateFormat(date) { //Formata a data para exibir
    var dateArray = date.split("-");
    var year = dateArray[0];
    var month = dateArray[1];
    var day = dateArray[2];
    const newDate = day + "/" + month + "/" + year;
    return newDate;
}

class Clientes {
    constructor() {
        //setando as urls e o modal
        this.form = document.getElementById('form_cliente');
        this.modal = document.getElementById('modal_cliente');
        this.urlGetCliente = "clients/get_client";
        this.urlEditar = "clients/atualizar";
        this.urlAdicionar = "clients/adicionar";

        //pegar as variáveis do formulário
        this.nameInput = document.querySelector('[name="name"]');
        this.idInput = document.querySelector('[name="id"]');
        this.telefoneInput = document.querySelector('[name="celular"]');
        this.dataAquisicaoInput = document.querySelector('[name="landed_at"]');
        this.emailInput = document.querySelector('[name="email"]');
    }

    edit(id) {
        this.form.reset(); //limpando os dados do formulário

        // fetch client data
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `${siteUrl}/${this.urlGetCliente}/${id}`);
        xhr.onload = () => {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);

                // fill form with fetched data
                this.nameInput.value = data.name;
                this.idInput.value = data.id;
                this.telefoneInput.value = data.celular;
                this.dataAquisicaoInput.value = dateFormat(data.landed_at);
                this.emailInput.value = data.email;
            } else {
                console.log('Erro ao receber dados do AJAX');
            }
        };
        xhr.send();

        // show modal
        this.modal.classList.add('show');
        this.modal.style.display = 'block';
        this.modal.querySelector('.modal-title').textContent = 'Editar';

        // set form action
        this.form.action = `${siteUrl}/${this.urlEditar}/${id}`;
    }

    novoCliente() {
        // Reset the form
        document.getElementById('form_cliente').reset();

        // Set the modal title
        const modalTitle = document.querySelector('.modal-title');
        modalTitle.textContent = 'Novo Cliente';

        // Set the form action
        document.getElementById('form_cliente').action = `${siteUrl}/${this.urlAdicionar}`;
    }
    close() {
        this.modal.style.display = 'none';
    }
    inputMask() {
        this.dataAquisicaoInput.addEventListener('blur', () => {
            // Access the current value within the callback using 'this'
            const data = this.dataAquisicaoInput.value;
            const newValue = inputData(data);
            this.dataAquisicaoInput.value = newValue;
          });
        this.telefoneInput.addEventListener('blur', () => {
            // Access the current value within the callback using 'this'
            const fone = this.telefoneInput.value;
            const newValue = inputTelefone(fone);
            this.telefoneInput.value = newValue;  
        });
    }
}
const clientes = new Clientes();
clientes.inputMask();

class Contas {

    constructor() {
        console.log("Class Contas");

        //setando as urls e o modal
        this.form = document.getElementById('form_contas');
        this.modal = document.getElementById('modal_contas');
        this.urlGetAccount = "accounts/get_account";
        this.urlEditar = "accounts/atualizar";
        this.urlAdicionar = "accounts/adicionar";

        //pegar as variáveis do formulário
        this.accountInput = document.querySelector('[name="account"]');
        this.idInput = document.querySelector('[name="id"]');
        this.commentInput = document.querySelector('[name="comments"]');
    }

    edit(id) {
        this.form.reset(); //limpando os dados do formulário

        // fetch client data
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `${siteUrl}/${this.urlGetAccount}/${id}`);
        xhr.onload = () => {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);

                // fill form with fetched data
                this.accountInput.value = data.account;
                this.idInput.value = data.id;
                this.commentInput.value = data.comments;
            } else {
                console.log('Erro ao receber dados do AJAX');
            }
        };
        xhr.send();

        // show modal
        this.modal.classList.add('show');
        this.modal.style.display = 'block';
        this.modal.querySelector('.modal-title').textContent = 'Editar';

        // set form action
        this.form.action = `${siteUrl}/${this.urlEditar}/${id}`;
    }

    novaConta() {
        // Reset the form
        document.getElementById('form_contas').reset();

        // Set the modal title
        const modalTitle = document.querySelector('.modal-title');
        modalTitle.textContent = 'Nova Conta';

        // Set the form action
        document.getElementById('form_contas').action = `${siteUrl}/${this.urlAdicionar}`;
    }
    close() {
        this.modal.style.display = 'none';
    }





}
const contas = new Contas();


