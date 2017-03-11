/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function setQuantidadeAulas(objeto) {
    if (objeto.value == 0) {
        $("#tableAlunos").hide();
    } else {
        var valores = objeto.value.split("-");
        quantidadeAulas = valores[1];
        for (var i = 0; i < alunosQuantidadeAulas.length; i++) {
            document.getElementById(alunosQuantidadeAulas[i][0]).innerHTML = quantidadeAulas;
            document.getElementById(alunosQuantidadeAulas[i][1]).value = quantidadeAulas;
        }
        $("#tableAlunos").show();
    }
}

function editarQuantidadeAula(quantidade, id, type) {
    var aulas = parseInt($("#spanAula" + id).html());
    if (type === "menos") {
        if ((aulas - 1) >= 1) {
            aulas = aulas - 1;
            $("#spanAula" + id).html(aulas);
            $("#valorAula" + id).val(aulas);
        }
    } else {
        if ((aulas + 1) <= quantidade) {
            aulas = aulas + 1;
            $("#spanAula" + id).html(aulas);
            $("#valorAula" + id).val(aulas);
        }
    }

    if (aulas < quantidade) {
        $("#" + id + "P").attr('checked', false);
        $("#" + id + "P").attr('disabled', true);
        $("#" + id + "F").attr('checked', true);
    } else {
        $("#" + id + "P").removeAttr('disabled');
    }
}
