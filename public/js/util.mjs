//formata o valor para o padrão brasileiro
export function formataValor(valor){
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