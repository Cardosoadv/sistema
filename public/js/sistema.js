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
        this.form               = document.getElementById('form_revenue');
        this.modal              = document.getElementById('modal_revenue');
        this.receiptForm        = document.getElementById('form_receipts');
        this.receiptModal       = document.getElementById('modal_receipts');
        this.urlGetRevenue      = "revenues/get_revenue";
        this.urlEditar          = "revenues/atualizar";
        this.urlAdicionar       = "revenues/adicionar";
        this.urlReceber         = "revenues/receber";
        this.urlGetReceipts     = "revenues/get_receipts";       

        //pegar as variáveis do formulário de Vendas
        this.revenuesInput      = document.querySelector('[name="revenues"]');
        this.dueDateInput       = document.querySelector('[name="due_dt"]');
        this.valueInput         = document.querySelector('[name="value"]');
        this.categoryInput      = document.querySelector('[name="category_id"]');
        this.clientIdInput      = document.querySelector('[name="client_id"]');
        this.reconciledInput    = document.querySelector('[name="reconciled"]');
        this.commentsInput      = document.querySelector('[name="comments"]');
        this.latefeeInput       = document.querySelector('[name="late_fee"]');
        this.interestInput      = document.querySelector('[name="interest"]');
        this.chargesInput       = document.querySelector('[name="charges"]');

        //pegar as variáveis do formulário share:
        this.user1Input         = document.querySelector('[name="user1"');
        this.user2Input         = document.querySelector('[name="user2"');
        this.user3Input         = document.querySelector('[name="user3"');
        this.user4Input         = document.querySelector('[name="user4"');
        this.user5Input         = document.querySelector('[name="user5"');
        this.user6Input         = document.querySelector('[name="user6"');
        this.shareUser1Input    = document.querySelector('[name="share_user1"');
        this.shareUser2Input    = document.querySelector('[name="share_user2"');
        this.shareUser3Input    = document.querySelector('[name="share_user3"');
        this.shareUser4Input    = document.querySelector('[name="share_user4"');
        this.shareUser5Input    = document.querySelector('[name="share_user5"');
        this.shareUser6Input    = document.querySelector('[name="share_user6"');

         //pegar as variáveis do formulário de Recebimento
         this.receiptRevenuesInput      = document.querySelector('[name="receipt_revenue"]');
         this.receiptDateInput          = document.querySelector('[name="receipt_dt"]');
         this.receiptValueInput         = document.querySelector('[name="receipt_value"]');
         this.receiptLatefeeInput       = document.querySelector('[name="receipt_late_fee"]');
         this.receiptInterestInput      = document.querySelector('[name="receipt_interest"]');
         this.receiptChargesInput       = document.querySelector('[name="receipt_charges"]');
         this.receiptReconciledInput    = document.querySelector('[name="receipt_reconciled"]');
         this.receiptCommentsInput      = document.querySelector('[name="receipt_comments"]');
        
        //pegar as variáveis do formulário share:
        this.receiptUser1Input          = document.querySelector('[name="receipt_user1"');
        this.receiptUser2Input          = document.querySelector('[name="receipt_user2"');
        this.receiptUser3Input          = document.querySelector('[name="receipt_user3"');
        this.receiptUser4Input          = document.querySelector('[name="receipt_user4"');
        this.receiptUser5Input          = document.querySelector('[name="receipt_user5"');
        this.receiptUser6Input          = document.querySelector('[name="receipt_user6"');
        this.receiptShareUser1Input     = document.querySelector('[name="receipt_share_user1"');
        this.receiptShareUser2Input     = document.querySelector('[name="receipt_share_user2"');
        this.receiptShareUser3Input     = document.querySelector('[name="receipt_share_user3"');
        this.receiptShareUser4Input     = document.querySelector('[name="receipt_share_user4"');
        this.receiptShareUser5Input     = document.querySelector('[name="receipt_share_user5"');
        this.receiptShareUser6Input     = document.querySelector('[name="receipt_share_user6"');
    }

    edit(id) {
        this.form.reset(); //limpando os dados do formulário

        // fetch client data
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `${siteUrl}/${this.urlGetRevenue}/${id}`);
        xhr.onload = () => {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                const verifiedChecked = ((data.reconciled==="1") ? true : false)
                // fill form with fetched data
                this.revenuesInput.value        = data.revenues;
                this.dueDateInput.value         = data.due_dt;
                this.valueInput.value           = data.value;
                this.categoryInput.value        = data.category;
                this.clientIdInput.value        = data.client_id;
                this.reconciledInput.checked    = verifiedChecked;
                this.commentsInput.textContent  = data.comments;
                this.latefeeInput.value         = data.late_fee;
                this.interestInput.value        = data.interest;
                this.chargesInput.value         = data.charges;
                this.user1Input.value           = data.user1;
                this.user2Input.value           = data.user2;
                this.user3Input.value           = data.user3;
                this.user4Input.value           = data.user4;
                this.user5Input.value           = data.user5;
                this.user6Input.value           = data.user6;
                this.shareUser1Input.value      = data.share_user1;
                this.shareUser2Input.value      = data.share_user2;
                this.shareUser3Input.value      = data.share_user3;
                this.shareUser4Input.value      = data.share_user4;
                this.shareUser5Input.value      = data.share_user5;
                this.shareUser6Input.value      = data.share_user6;
                console.log(verifiedChecked);
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

    receipt(id) {
        this.receiptForm.reset(); //limpando os dados do formulário

        // fetch revenues data
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `${siteUrl}/${this.urlGetRevenue}/${id}`);
        xhr.onload = () => {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                const verifiedChecked = ((data.reconciled==="1") ? true : false)
                // fill form with fetched data
                console.log(data);
                this.receiptValueInput.value            = data.value;
                this.receiptUser1Input.value            = data.user1; 
                this.receiptUser2Input.value            = data.user2; 
                this.receiptUser3Input.value            = data.user3; 
                this.receiptUser4Input.value            = data.user4; 
                this.receiptUser5Input.value            = data.user5; 
                this.receiptUser6Input.value            = data.user6;
                this.receiptShareUser1Input.value       = ((data.share_user1/100) * data.value);
                this.receiptShareUser2Input.value       = ((data.share_user2/100) * data.value);
                this.receiptShareUser3Input.value       = ((data.share_user3/100) * data.value);
                this.receiptShareUser4Input.value       = ((data.share_user4/100) * data.value);
                this.receiptShareUser5Input.value       = ((data.share_user5/100) * data.value);
                this.receiptShareUser6Input.value       = ((data.share_user6/100) * data.value);
                this.receiptCommentsInput.textContent   = data.comments;
                this.receiptReconciledInput.checked     = verifiedChecked;
            } else {
                console.log('Erro ao receber dados do AJAX');
            }
        };
        xhr.send();

        // show modal
        this.receiptModal.classList.add('show');
        this.receiptModal.style.display = 'block';
        this.receiptModal.querySelector('.modal-title').textContent = 'Receber';

        // set form action
        this.form.action = `${siteUrl}/${this.urlReceber}/${id}`;
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
        this.receiptModal.style.display = 'none';
    }
}
const revenues = new Revenues();
