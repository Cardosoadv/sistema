const siteUrl = "http://localhost/sistema/sistema";
// Formata Data
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

// Formata o número de Telefone (00) 0000-0000
function inputTelefone(fone){
const regex = /^(\d{2})(\d{5})(\d{4})$/;
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

// Formata o valor para o padrão brasileiro
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

// Formata a data para exibir
function dateFormat(date) { 
    var dateArray = date.split("-");
    var year = dateArray[0];
    var month = dateArray[1];
    var day = dateArray[2];
    const newDate = day + "/" + month + "/" + year;
    return newDate;
}

// Objeto Clientes
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
                this.dataAquisicaoInput.value = data.landed_at;
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
}
const clientes = new Clientes();

// Objeto Contas
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

//Objeto Vendas
class Revenues{
    constructor() {
        //setando as urls e o modal
        this.form = document.getElementById('form_revenue');
        this.modal = document.getElementById('modal_revenue');
        this.urlGetRevenue = "revenues/get_revenue";
        this.urlEditar = "revenues/atualizar";
        this.urlAdicionar = "revenues/adicionar";

        //pegar as variáveis do formulário
        this.revenuesInput = document.querySelector('[name="revenues"]');
        this.dueDateInput = document.querySelector('[name="due_dt"]');
        this.valueInput = document.querySelector('[name="value"]');
        this.categoryInput = document.querySelector('[name="category"]');
        this.clientIdInput = document.querySelector('[name="client_id"]');
        this.reconciledInput = document.querySelector('[name="reconciled"]');
        this.commentsInput = document.querySelector('[name="comments"]');
        
        //pegar as variáveis do formulário share:
        this.sharesInput[0][0] = document.querySelector('[name="advogado[0]"');
        this.sharesInput[0][1] = document.querySelector('[name="rateio[0]"');
        this.sharesInput[1][0] = document.querySelector('[name="advogado[1]"');
        this.sharesInput[1][1] = document.querySelector('[name="rateio[1]"');
        this.sharesInput[2][0] =  document.querySelector('[name="advogado[2]"');
        this.sharesInput[2][1] = document.querySelector('[name="rateio[2]"');
        this.sharesInput[3][0] =  document.querySelector('[name="advogado[3]"');
        this.sharesInput[3][1] = document.querySelector('[name="rateio[3]"');
        this.sharesInput[4][0] = document.querySelector('[name="advogado[4]"');
        this.sharesInput[4][1] = document.querySelector('[name="rateio[4]"');
        this.sharesInput[5][0] =  document.querySelector('[name="advogado[5]"');
        this.sharesInput[5][1] = document.querySelector('[name="rateio[5]"');
        console.log(this.sharesInput.value);
    }

    edit(id) {
        this.form.reset(); //limpando os dados do formulário

        // fetch client data
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `${siteUrl}/${this.urlGetRevenue}/${id}`);
        xhr.onload = () => {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);

                // fill form with fetched data
                this.revenuesInput.value = data.revenues;
                this.dueDateInput.value = data.due_dt;
                this.valueInput.value = data.value;
                this.categoryInput.value = data.category;
                this.clientIdInput.value = data.client_id;
                this.sharesInput.value = data.share;
                this.reconciledInput.value = data.reconciled;
                this.commentsInput.value = data.comments;

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

    novaVenda() {
        // Reset the form
        this.form.reset();

        // Set the modal title
        const modalTitle = document.querySelector('.modal-title');
        modalTitle.textContent = 'Nova Venda';

        // Set the form action
        this.form.action = `${siteUrl}/${this.urlAdicionar}`;
    }
    close() {
        this.modal.style.display = 'none';
    }
}
const revenues = new Revenues();
