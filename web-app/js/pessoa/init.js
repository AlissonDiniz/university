/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function(){
    $("#cpf").mask("999.999.999-99");
    $("#cnpj").mask("99.999.999/9999-99");
    $("#dataNascimento").mask("99/99/9999");
    $("#dataIdentidade").mask("99/99/9999");
    $("#cep").mask("99999-999");
    $("#telefone1").mask("(99) 9999-9999");
    $("#telefone2").mask("(99) 9999-9999");
    $("#cpfPai").mask("999.999.999-99");
    $("#cpfMae").mask("999.999.999-99");
    $("#typePessoa").click(function(){
        if($("#typePessoa").html() == "Pessoa Jurídica"){
            $("#dadosPessoais").hide();
            $("#dadosOutros").hide();
            $("#dataNascimento").val("01/01/2013");
            $("#identidade").val("0");
            $("#naturalidade").val("0");
            
            $("#cnpj").val("");
            $("#cpf").val("@");
            $("#cnpj").show();
            $("#cpf").hide();
            $("#typePessoa").html("Pessoa Física");
        }else{
            $("#dadosPessoais").show();
            $("#dadosOutros").show();
            $("#dataNascimento").val("");
            $("#identidade").val("");
            $("#naturalidade").val("");
            
            $("#cpf").val("");
            $("#cnpj").val("@");
            $("#cpf").show();
            $("#cnpj").hide();
            $("#typePessoa").html("Pessoa Jurídica");
        }
    });
    jQuery("#form").validationEngine();
});
function alterarFoto(){
    if($("#cpf").val() === ""){
        alert('Preencha o CPF por favor!');
        $("#cpf").focus();
    }else{
        $("#alterarFotoFrame").dialog({
            width: 625,
            height: 455,
            modal: true,
            close: function() {
                $("#imageProfile").attr("src", urlImage);
            }
        });
    }
}
