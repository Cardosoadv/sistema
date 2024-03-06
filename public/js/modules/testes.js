import { siteUrl } from "./url.js";

export class Testes{
    constructor() {
        console.log("Leu Teste!");
        const form      = document.getElementById('form_revenue');
        const inputs    = form.elements;

        for (const input of inputs) {
            // Faça algo com o input
            console.log(input.name);
        }






    }
}
