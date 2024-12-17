let inputValor = document.getElementById('num_valor');

inputValor.addEventListener('input', function () {
        let valueValor = this.value.replace(/[^\d]/g, '');

        var formattedValor = (valueValor.slice(0,-2).replace(/\B(?=(\d{3})+(?!\d))/g, ".")) +
            '' + valueValor.slice(-2);

        formattedValor = formattedValor.slice(0,-2) + ',' + formattedValor.slice(-2);
        this.value = formattedValor;
    }
);

$(document).ready(function() {
    // Aplicar a máscara monetária ao campo num_valor
    $('#num_valor').mask('000.000.000,00', {reverse: true});
});
