import { Clientes } from "./modules/clientes.js";
import { Contas } from "./modules/contas.js";
import { Vendas } from "./modules/vendas.js";
import { Testes } from "./modules/testes.js";

const clientes = new Clientes();
const contas = new Contas();
const vendas = new Vendas();
const testes = new Testes();

window._sistema = {clientes, contas, vendas, testes};