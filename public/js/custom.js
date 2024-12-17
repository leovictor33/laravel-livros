let inputValor = document.getElementById('num_valor');
let inputEdicao = document.getElementById('num_edicao');
let inputAnoPub = document.getElementById('num_ano_publicacao');

if(inputValor !== null){
    inputValor.addEventListener('input', function () {
            let valueValor = this.value.replace(/[^\d]/g, '');

            var formattedValor = (valueValor.slice(0, -2).replace(/\B(?=(\d{3})+(?!\d))/g, ".")) +
                '' + valueValor.slice(-2);

            formattedValor = formattedValor.slice(0, -2) + ',' + formattedValor.slice(-2);
            this.value = formattedValor;
        }
    );
}

if(inputEdicao !== null){
    inputEdicao.addEventListener('input', function () {
            this.value = this.value.replace(/[^\d]/g, '');
        }
    );
}

if(inputAnoPub !== null){
    inputAnoPub.addEventListener('input', function () {
            this.value = this.value.replace(/[^\d]/g, '');
        }
    );
}

$(document).ready(function () {
    // Aplicar a máscara monetária ao campo num_valor
    $('#num_valor').mask('000.000.000,00', {reverse: true});
    $('#num_edicao').mask('000', {reverse: false});
    $('#num_ano_publicacao').mask('0000', {reverse: false});
});
