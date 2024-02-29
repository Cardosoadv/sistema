import { Clientes } from "./modules/clientes.js";
import { Contas } from "./modules/contas.js";
import { Vendas } from "./modules/vendas.js";

const clientes = new Clientes();
const contas = new Contas();
const vendas = new Vendas();

window._sistema = {clientes, contas, vendas}