export default class  Clientes {
    constructor() {
        console.log("Class Clientes");
        
        //setando as urls e o modal
        this.form = document.getElementById('form_cliente');
        this.modal = document.getElementById('#modal_cliente');
        this.urlEditarCliente = "clientes/ajax_editar_cliente";
        this.urlEditar = "clientes/editar";
        this.urlAdicionar = "clientes/adicionar";
        
        //pegar as variáveis do formulário
        this.nomeInput = document.querySelector('[name="nome"]');
        this.cpfInput = document.querySelector('[name="cpf"]');
        this.cnpjInput = document.querySelector('[name="cnpj"]');
        this.idInput = document.querySelector('[name="id"]');
        this.telefoneInput = document.querySelector('[name="telefone"]');
        this.dataNascimentoInput = document.querySelector('[name="data_nascimento"]');
        this.usernameInput = document.querySelector('[name="username"]');
        this.emailInput = document.querySelector('[name="email"]');
    }

    edit(id) {
        this.form.reset(); //limpando os dados do formulário
        fetch(`${siteUrl}/${this.urlEditarCliente}/${id}`) //requisitando os dados por ajax, usando o fetch
            .then(response => response.json())
            .then(data => { 
                console.log(data);
                //preenchendo os dados do formulário
                var cpf_cnpj = data.cpf_cnpj;
                console.log(cpf_cnpj.length);
                this.nomeInput.value = data.nome;
                    if (cpf_cnpj.length===19){
                        this.cnpjInput.value = cpf_cnpj;
                    }else{
                        this.cpfInput.value = cpf_cnpj;
                    }
                this.idInput.value = data.id;
                console.log(this.idInput.value);
                this.telefoneInput.value = data.telefone;
                this.dataNascimentoInput.value = data.data_nascimento;
                this.usernameInput.value = data.username;
                this.emailInput.value = data.email;
            })

            .then(response => {
                $('#modal_cliente').modal('show');
                $('.modal-title').text('Editar'); // Seta o titulo do modal
                document.getElementById('form_cliente').action = `${siteUrl}/${this.urlEditar}/${id}`;
            })
            .catch(error => {
                console.error(error);
                alert('Erro ao receber dados do AJAX');
            });
    }

    novoCliente() {
        $('#form_cliente')[0].reset();
        $('.modal-title').text('Novo Cliente'); // Set title to Bootstrap modal title
        document.getElementById('form_cliente').action = `${siteUrl}/${this.urlAdicionar}`;
    }
}
