/**
 * Classe Gerais de Formatacao
 * @author Augusto Michel <augustomichel@gmail.com>
 */
class Util {

    dataDBFormatBR(datatime, time = true) {
        var dataSep = datatime.split(' ');
        var dataBR = dataSep[0].split('-');

        if (time) {
            return dataBR[2] + '/' + dataBR[1] + '/' + dataBR[0] + ' ' + dataSep[1];
        } else {
            return dataBR[2] + '/' + dataBR[1] + '/' + dataBR[0];
        }
    }

    empty(str) {
        return (!str || 0 === str.length || !str.trim());
    }

    dataMoedaBR(valorFloat) {
        return valorFloat.toLocaleString('pt-br', {
            style: 'currency',
            currency: 'BRL'
        });
    }
}