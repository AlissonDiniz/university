<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BoletoService
 *
 * @author Alisson
 */
include_once '../lib/barcode/barCodeGenerator.php';
include_once '../class/Parametro.php';
include_once '../class/Titulo.php';
include_once '../class/Aluno.php';
include_once '../class/Pessoa.php';
include_once '../class/Acrescimo.php';
include_once '../class/Desconto.php';
include_once '../class/Configuracao.php';
include_once '../class/Empresa.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Data.php';

class BoletoService extends MainService {

    public $params;

    public function _index() {
        $this->barcode();
    }

    public function _barcode() {
        new barCodeGenerator($this->params['code'], 0, 'barcode.gif', 434.645669291, 56.692913386, false);
    }

    public function _create() {
        $idTitulo = null;
        
        if (!empty($this->params['nossoNumero'])) {
            $nossoNumero = $this->params['nossoNumero'];
        }
        if (!empty($this->params['idAluno'])) {
            $aluno = $this->params['idAluno'];
        }
        if (!empty($this->params['periodo'])) {
            $periodo = $this->params['periodo'];
        }
        if (!empty($this->params['parcela'])) {
            $parcela = $this->params['parcela'];
        }
        if (!empty($this->params['idTitulo'])) {
            $idTitulo = $this->params['idTitulo'];
        }

        $titulo = new Titulo();
        if($idTitulo == null){
            if ($nossoNumero != "") {
                $arrayTitulo = $titulo->findByNossoNumero($nossoNumero);
            } else {
                $arrayTitulo = $titulo->findByAlunoParcela($aluno, $parcela, $periodo);
            }
            $arrayTitulo = $arrayTitulo[0];
        }else{
            $arrayTitulo = $titulo->get($idTitulo);
        }

        if ($this->params['venc'] == "true") {
            $arrayTitulo['dados']['vencimento'] = date("Y-m-d");
        }

        $arrayData = $this->getBoletoData($arrayTitulo);
        $this->render($this->action, "result", $arrayData);
    }
    
    public function _createLote(){
        $titulo = new Titulo();
        $arrayData = array();
        foreach(explode("-", $this->params['ids']) as $id){
            $arrayTitulo = $titulo->get($id);
            $arrayData[] = $this->getBoletoData($arrayTitulo);
        }
        $this->render($this->action, "resultLote", $arrayData);
    }

    private function getBoletoData($arrayTitulo) {
        $arrayData = array();
        $parametro = new Parametro();
        $data['parametros'] = $parametro->get();
        $functionHTML = new FuncoesHTML();
        $aluno = new Aluno();
        $pessoa = new Pessoa();
        $desconto = new Desconto();
        $dataFormat = new Data();


        $valorTitulo = $arrayTitulo['dados']['valor_restante'];
        $arrayDesconto = $desconto->listarByTitulo($arrayTitulo['dados']['id']);
        $valorDesconto = 0;
        foreach ($arrayDesconto as $descontoInstance) {
            $arrayType = explode("-", $descontoInstance['dados']['type']);
            if ($descontoInstance['dados']['status'] == '1' && $arrayType[1] == "0") {
                $valorDesconto = $valorDesconto + $descontoInstance['dados']['valor'];
            }
        }

        // DADOS DO BOLETO PARA O SEU CLIENTE
        $arrayData['dias_de_prazo_para_pagamento'] = $data['parametros']['dados']['dias_para_atrazo'];
        $taxa_boleto = $data['parametros']['dados']['taxa_boleto'];
        $data_venc = $dataFormat->dataUSAToDataBrasil($arrayTitulo['dados']['vencimento']);
        $valor_cobrado = str_replace(",", ".", $valorTitulo);
        $valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

        if ($arrayTitulo['dados']['nossoNumeroBanco'] != "") {
            $dadosboleto["nosso_numero"] = $functionHTML->completaStringLeft($arrayTitulo['dados']['nossoNumeroBanco'], 13, "0");
        } else {
            $dadosboleto["nosso_numero"] = $functionHTML->completaStringLeft($arrayTitulo['dados']['nosso_numero'], 13, "0");
        }

        $dadosboleto["numero_documento"] = $functionHTML->completaStringLeft($arrayTitulo['dados']['nosso_numero'], 15, "0");
        $dadosboleto["data_vencimento"] = $data_venc;
        $dadosboleto["data_documento"] = date("d/m/Y");
        $dadosboleto["data_processamento"] = date("d/m/Y");
        $dadosboleto["valor_boleto"] = $valor_boleto;
        $dadosboleto["valor_desconto"] = number_format($valorDesconto, 2, ',', '');

        if ($arrayTitulo['dados']['matricula_id'] != "") {
            $arrayAluno = $aluno->getByMatricula($arrayTitulo['dados']['matricula_id']);
        } else {
            $arrayAluno = $aluno->get($arrayTitulo['dados']['aluno_id']);
        }

        $arrayPessoa = $pessoa->get($arrayAluno['dados']['pessoa_id']);
        if ($arrayAluno['dados']['responsavel_id'] == $arrayAluno['dados']['id']) {
            $arrayPessoaResponsavel = $arrayPessoa;
        } else {
            $arrayPessoaResponsavel = $pessoa->get($arrayAluno['dados']['responsavel_id']);
        }

        // DADOS DO SEU CLIENTE
        $dadosboleto["sacado"] = $functionHTML->removeAcentoU($arrayPessoa['dados']['nome']);
        $dadosboleto["endereco1"] = $functionHTML->removeAcentoU($arrayPessoa['dados']['logradouro']) . " - " . $arrayPessoa['dados']['numero'] . " - " . $functionHTML->removeAcentoU($arrayPessoa['dados']['complemento']) . " - " . $functionHTML->removeAcentoU($arrayPessoa['dados']['bairro']);
        $dadosboleto["endereco2"] = $functionHTML->removeAcentoU($arrayPessoa['dados']['cidade']) . " - " . $arrayPessoa['dados']['estado'] . " - " . $arrayPessoa['dados']['cep'];
        $dadosboleto["avalista"] = $functionHTML->removeAcentoU($arrayPessoaResponsavel['dados']['nome']) . "&nbsp;&nbsp;-&nbsp;&nbsp;" . $functionHTML->removeAcentoU($arrayPessoaResponsavel['dados']['cpf']);
        $dadosboleto["cpf"] = $arrayPessoa['dados']['cpf'];
        $dadosboleto["curso"] = $functionHTML->removeAcentoU($arrayAluno['dados']['nomeCurso']);

        $arrayData['multa'] = number_format((($valor_cobrado + $taxa_boleto) * ($data['parametros']['dados']['taxa_multa'] / 100)), 2, ',', '');
        $arrayData['juros'] = number_format((($valor_cobrado + $taxa_boleto) * ($data['parametros']['dados']['taxa_mora'] / 100)), 2, ',', '');

        $arrayMensagens = explode("\r\n", $data['parametros']['dados']['mensagens']);
        for ($index = 0; $index < count($arrayMensagens); $index++) {
            $dadosboleto["mensagem"][] = array("dados" => $arrayMensagens[$index]);
        }

        // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
        $dadosboleto["quantidade"] = "";
        $dadosboleto["valor_unitario"] = "";
        $dadosboleto["aceite"] = "NAO";
        $dadosboleto["especie"] = "REAL";
        $dadosboleto["especie_doc"] = "DM";

        $configuracao = new Configuracao();
        $arrayConfiguracao = $configuracao->get($arrayTitulo['dados']['idConfiguracao']);

        // DADOS PERSONALIZADOS - SANTANDER BANESPA
        $dadosboleto["banco"] = $arrayConfiguracao['dados']['banco'];
        $dadosboleto["codigo_cliente"] = $arrayConfiguracao['dados']['codigo_cliente'];
        $dadosboleto["ponto_venda"] = $arrayConfiguracao['dados']['agencia'];
        $dadosboleto["carteira"] = $arrayConfiguracao['dados']['carteira'];
        $dadosboleto["carteira_descricao"] = "COBRAN&Ccedil;A SIMPLES - CSR";

        $empresa = new Empresa();
        $arrayEmpresa = $empresa->get();

        // SEUS DADOS
        $dadosboleto["identificacao"] = $arrayEmpresa['dados']['nome'];
        $dadosboleto["cpf_cnpj"] = $arrayEmpresa['dados']['cnpj'];
        $dadosboleto["endereco"] = $arrayEmpresa['dados']['logradouro'] . ", " . $arrayEmpresa['dados']['numero'] . " - " . $arrayEmpresa['dados']['bairro'];
        $dadosboleto["cidade_uf"] = "CEP: " . $arrayEmpresa['dados']['cep'] . ", " . $arrayEmpresa['dados']['cidade'] . "/" . $arrayEmpresa['dados']['estado'];
        $dadosboleto["cedente"] = $arrayEmpresa['dados']['nome'];
        $arrayData['dadosBoleto'] = $dadosboleto;

        return $arrayData;
    }

}

?>
