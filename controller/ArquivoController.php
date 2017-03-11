<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../config/urlmapping.php';
include_once '../class/Arquivo.php';
include_once '../class/ArquivoRow.php';
include_once '../class/Titulo.php';
include_once '../class/Curso.php';
include_once '../class/Configuracao.php';
include_once '../class/Baixa.php';
include_once '../class/User.php';
include_once '../class/Empresa.php';
include_once '../class/Desconto.php';
include_once '../class/Parametro.php';
include_once '../function/Enum.php';
include_once '../function/FuncoesHTML.php';
include_once '../function/util/Data.php';
include_once '../function/util/Number.php';
include_once '../function/enum/Meses.php';

class ArquivoController extends MainController {

    public $action;
    public $method;
    public $params;

    public function ArquivoController() {
        $this->authorityMethod[] = array("name" => "_index", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_listRetorno", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_listRemessa", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_loadRetorno", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_createRemessa", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_viewRemessa", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_reportRemessa", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_donwloadRemessa", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_searchRetorno", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_reportSearchRetorno", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_PROCESSRETORNO", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_reportRetorno", "authority" => 4);
        $this->authorityMethod[] = array("name" => "_CREATEARQUIVO", "authority" => 4);
    }

    public function _index() {
        $this->_list();
    }

    public function _listRetorno() {
        $arquivo = new Arquivo();
        $zebraPagination = $this->paginate($arquivo->count("RETORNO"));
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "data" => new Data());
        $data = $arquivo->listarLimit("RETORNO", $zebraPagination['limit']);
        $this->render($this->action, "listRetorno", $data);
    }

    public function _listRemessa() {
        $arquivo = new Arquivo();
        $zebraPagination = $this->paginate($arquivo->count("REMESSA"));
        $this->class = array('pagination' => $zebraPagination['pagination'], "enum" => new Enum(), "data" => new Data());
        $data = $arquivo->listarLimit("REMESSA", $zebraPagination['limit']);
        $this->render($this->action, "listRemessa", $data);
    }

    public function _loadRetorno() {
        $this->render($this->action, "loadRetorno", null);
    }

    public function _viewRemessa() {
        $this->render($this->action, "viewRemessa", null);
    }

    public function _createRemessa() {
        $configuracao = new Configuracao();
        $array = array();
        foreach ($configuracao->listar() as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['nome_banco'] . " - " . $value['dados']['agencia'] . " - " . $value['dados']['conta']);
        }
        $data['configuracao'] = $array;
        $curso = new Curso();
        $arrayCursos = $curso->listar("1");
        $array = array();
        foreach ($arrayCursos as $value) {
            $array[] = array("value" => $value['dados']['id'], "nome" => $value['dados']['nome']);
        }
        $data['cursos'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML(), "meses" => new Meses());
        $this->render($this->action, "createRemessa", $data);
    }

    public function _donwloadRemessa() {
        $arquivo = new Arquivo();
        $arrayArquivo = $arquivo->get($this->params['id']);
        $this->download(uriRemessa . $arrayArquivo['dados']['nome']);
    }

    public function _searchRetorno() {
        $user = new User();
        $array = array();
        foreach ($user->listar() as $value) {
            $array[] = array("value" => $value['dados']['username'], "nome" => $value['dados']['nome']);
        }
        $data['usuarios'] = $array;
        $this->class = array("funcoesHTML" => new FuncoesHTML());
        $this->render($this->action, "searchRetorno", $data);
    }

    public function _PROCESSRETORNO() {
        if (!$_FILES) {
            $_SESSION['error'] = "Nenhum Arquivo Enviado!";
            $this->redirect($this->action, "loadRetorno", null);
        } else {
            if ($_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "text/plain") {
                $_SESSION['error'] = "Tipo de Arquivo não compatível!";
                $this->redirect($this->action, "loadRetorno", null);
            } else {
                $file_name = str_replace(" ", "_", $_FILES['file']['name']) . date("YmdHi") . ".txt";
                $file_size = $_FILES['file']['size'];
                $file_tmp_name = $_FILES['file']['tmp_name'];
                if (!move_uploaded_file($file_tmp_name, uriRetorno . $file_name)) {
                    $_SESSION['error'] = "Error ao Mover o Arquivo!";
                    $this->redirect($this->action, "loadRetorno", null);
                } else {
                    $arquivo = new Arquivo();
                    $file = fopen(uriRetorno . $file_name, 'r');
                    $bufferFile = fread($file, $file_size);
                    fclose($file);

                    $arrayLines = explode("\r\n", $bufferFile);
                    $lineHeader = $arrayLines[0];

                    if (strlen($lineHeader) != 240) {
                        unlink(uriRetorno . $file_name);
                        $_SESSION['error'] = "O arquivo enviado não é compatível com o layout CNAB 240!";
                        $this->redirect($this->action, "loadRetorno", null);
                        die();
                    }

                    if (substr($lineHeader, 142, 1) != "2") {
                        unlink(uriRetorno . $file_name);
                        $_SESSION['error'] = "O arquivo enviado não é compatível com o layout de retono bancário CNAB 240!";
                        $this->redirect($this->action, "loadRetorno", null);
                        die();
                    }

                    $idConta = substr($lineHeader, 37, 9);
                    $descricao = "Chave da Conta: " . $idConta . "<br />Arquivo de " . count($arrayLines) . " Linhas";
                    $this->params["nome"] = $file_name;
                    $this->params["descricao"] = $descricao;
                    $this->params["type"] = "RETORNO";

                    if (!$arquivo->save($this->params)) {
                        $_SESSION['error'] = "Error ao Salvar o Arquivo!";
                        $this->redirect($this->action, "loadRetorno", null);
                    } else {
                        $data = new Data;
                        $number = new Number();
                        $enum = new Enum();
                        $lineT = false;
                        $lineU = false;

                        for ($i = 2; $i < (count($arrayLines) - 2); $i++) {
                            $idSegmento = substr($arrayLines[$i], 13, 1);

                            if ($idSegmento == "T") {
                                $lineT = true;
                                $nossoNumero = trim(substr($arrayLines[$i], 40, 13));
                                $numeroDocumento = trim(substr($arrayLines[$i], 54, 15));
                                $bancoRecebedor = substr($arrayLines[$i], 92, 3);
                                $agenciaRecebedora = substr($arrayLines[$i], 95, 4);
                                $idMotivo = substr($arrayLines[$i], 208, 10);
                            } else if ($idSegmento == "U") {
                                $lineU = true;
                                $idOcorrencia = substr($arrayLines[$i], 15, 2);
                                $jurosMultasEncargos = $number->formatCurrencyArquivo(substr($arrayLines[$i], 17, 15));
                                $valorDesconto = $number->formatCurrencyArquivo(substr($arrayLines[$i], 32, 15));
                                $valorAbatimento = $number->formatCurrencyArquivo(substr($arrayLines[$i], 47, 15));
                                $valorPago = $number->formatCurrencyArquivo(substr($arrayLines[$i], 77, 15));
                                $valorOutrasDespesas = $number->formatCurrencyArquivo(substr($arrayLines[$i], 107, 15));
                                $dataOcorrencia = $data->formatDataArquivoToUSA(substr($arrayLines[$i], 137, 8));
                            }

                            if ($lineT && $lineU) {
                                $arquivoRow = new ArquivoRow();
                                $titulo = new Titulo();
                                $arrayTitulo = $titulo->findByNossoNumero(ltrim($nossoNumero, "0"));
                                $ocorrenciaTitulo = $enum->enumMotivo($idOcorrencia, $idMotivo);
                                $params = array("idArquivo" => $arquivo->id,
                                    "idOcorrencia" => $idOcorrencia,
                                    "descricaoOcorrencia" => $ocorrenciaTitulo,
                                    "dataOcorrencia" => $dataOcorrencia,
                                    "nossoNumero" => $nossoNumero,
                                    "numeroDocumento" => $numeroDocumento,
                                    "userCreate" => $this->params['userCreate']);
                                $arquivoRow->save($params);
                                $lineT = false;
                                $lineU = false;
                                if (count($arrayTitulo) > 0) {
                                    if ($idOcorrencia == "06" || $idOcorrencia == "17") {
                                        $baixa = new Baixa();
                                        $valorPagoTitulo = $valorPago;
                                        $valorDescontoTitulo = ($valorDesconto + $valorAbatimento);
                                        $valorMultaTitulo = $jurosMultasEncargos;
                                        $valorJurosTitulo = $valorOutrasDespesas;
                                        $titulo = new Titulo();
                                        $params = array("idTitulo" => $arrayTitulo[0]['dados']['id'],
                                            "valorMulta" => $valorMultaTitulo,
                                            "valorJuros" => $valorJurosTitulo,
                                            "valorDesconto" => $valorDescontoTitulo);
                                        if ($valorPagoTitulo > 0) {
                                            if ($arrayTitulo[0]['dados']['valor_restante'] < $valorPagoTitulo) {
                                                $ocorrenciaTitulo = $ocorrenciaTitulo . "<br />Valor pago maior que o valor restante do Título!";
                                            }
                                            if (!$titulo->updateValores($params)) {
                                                $ocorrenciaTitulo = $ocorrenciaTitulo . "<br />Ocorreu um erro ao alterar o Título!";
                                            } else {
                                                $params = array("idTitulo" => $arrayTitulo[0]['dados']['id'],
                                                    "bancoRecebedor" => $bancoRecebedor,
                                                    "agenciaRecebedor" => $agenciaRecebedora,
                                                    "idArquivoRow" => $arquivoRow->id,
                                                    "formaPagamento" => "1",
                                                    "valorPago" => $valorPagoTitulo,
                                                    "dataPagamento" => $dataOcorrencia,
                                                    "userCreate" => $this->params['userCreate']);
                                                if (!$baixa->saveByArquivo($params)) {
                                                    $ocorrenciaTitulo = $ocorrenciaTitulo . "<br />Ocorreu um erro ao salvar a Baixa!";
                                                }
                                                if (!$titulo->updateSituacao($arrayTitulo[0]['dados']['id'])) {
                                                    $ocorrenciaTitulo = $ocorrenciaTitulo . "<br />Ocorreu um erro ao alterar o Título!";
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $ocorrenciaTitulo = $ocorrenciaTitulo . "<br />Nosso Número não encontrado!";
                                }
                                $arquivoRow->updateOcorrencia(array("id" => $arquivoRow->id, "descricaoOcorrencia" => $ocorrenciaTitulo));
                            }
                        }
                        $_SESSION['flash'] = "Arquivo processado com Sucesso!";
                        $this->redirect($this->action, "listRetorno", null);
                    }
                }
            }
        }
    }

    public function _reportRetorno() {
        $data = new Data();
        $number = new Number();
        $idArquivo = $this->params['id'];
        $arquivo = new Arquivo();
        $arrayArquivo = $arquivo->get($idArquivo);
        $arquivoRow = new ArquivoRow();
        $arrayRetorno = $arquivoRow->listar($idArquivo);
        $report = "resultRetorno";
        $arrayData['titulo'] = "Relatório - Processamento do Retorno Bancário";
        $arrayData['arquivo'] = $arrayArquivo;
        $arrayData['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "data" => $data, "number" => $number);
        $this->renderReport($this->action, $report, $arrayData);
    }

    public function _reportSearchRetorno() {
        $conection = new Conection();
        $data = new Data();
        $number = new Number();
        $nossoNumero = $this->params['nossoNumero'];
        $this->params['cpf'] != "" ? $cpf = "p.cpf LIKE '" . $this->params['cpf'] . "%' AND" : $cpf = "";
        $this->params['nome'] != "" ? $nome = "p.nome LIKE '" . $this->params['nome'] . "%' AND" : $nome = "";
        $this->params['matricula'] != "" ? $matricula = "a.matricula LIKE '" . $this->params['matricula'] . "%' AND" : $matricula = "";
        if ($this->params['dataOcorrenciaInit'] != "" && $this->params['dataOcorrenciaEnd'] != "") {
            $queryDataOcorrencia = "b.data BETWEEN '" . $data->dataBrasilToDataUSA($this->params['dataOcorrenciaInit']) . " " . $this->params['horaOcorrenciaInit'] . "' AND '" . $data->dataBrasilToDataUSA($this->params['dataOcorrenciaEnd']) . " " . $this->params['horaOcorrenciaEnd'] . "' AND ";
        } else {
            $queryDataOcorrencia = "";
        }
        $descricaoOcorrencia = $this->params['descricaoOcorrencia'];
        $user = $this->params['usuario'];

        $query = "SELECT s.* FROM ((SELECT ar.*, u.nome AS usuario, b.valor_pago, p.nome, p.cpf, a.matricula FROM arquivo_row ar
                  INNER JOIN usuario u ON u.username = ar.user_create
                  LEFT JOIN baixa b ON b.arquivo_row_id = ar.id
                  LEFT JOIN titulo t ON t.id = b.titulo_id
                  LEFT JOIN matricula m ON t.matricula_id = m.id
                  LEFT JOIN aluno a ON a.id = m.aluno_id
                  LEFT JOIN pessoa p ON p.id = a.pessoa_id
                  WHERE ar.nosso_numero LIKE '%$nossoNumero%' AND 
                        $nome $cpf $matricula $queryDataOcorrencia
                        ar.descricao_ocorrencia LIKE '%$descricaoOcorrencia%' AND
                        u.username LIKE '$user')
                UNION
                  (SELECT ar.*, u.nome AS usuario, b.valor_pago, p.nome, p.cpf, a.matricula FROM arquivo_row ar
                  INNER JOIN usuario u ON u.username = ar.user_create
                  LEFT JOIN baixa b ON b.arquivo_row_id = ar.id
                  LEFT JOIN titulo t ON t.id = b.titulo_id
                  LEFT JOIN aluno a ON a.id = t.aluno_id
                  LEFT JOIN pessoa p ON p.id = a.pessoa_id
                  WHERE ar.nosso_numero LIKE '%$nossoNumero%' AND 
                        $nome $cpf $matricula $queryDataOcorrencia
                        ar.descricao_ocorrencia LIKE '%$descricaoOcorrencia%' AND
                        u.username LIKE '$user')) s
                GROUP BY s.id";
        $result = $conection->selectQuery($query);
        $arrayData = array();
        $arrayRetorno = array();
        while ($array = $conection->fetch($result)) {
            $arrayRetorno[] = array("dados" => $array);
        }
        $arrayData['titulo'] = "Relatório de Ocorrências Bancárias";
        $arrayData['result'] = $arrayRetorno;
        $this->class = array("enum" => new Enum(), "data" => $data, "number" => $number);
        $this->renderReport($this->action, "resultSearchRetorno", $arrayData);
    }

    public function _CREATEARQUIVO() {
        $conection = new Conection();
        $queryMeses = "";
        $configuracao = new Configuracao();
        $arrayConfiguracao = $configuracao->get($this->params['configuracao']);
        $parametro = new Parametro();
        $arrayParametros = $parametro->get();

        if ($this->params['meses'] != "") {
            $queryMeses = "AND (";
            $separator = "";
            foreach ($this->params['meses'] as $value) {
                $queryMeses = $queryMeses . $separator . "MONTH(t.vencimento) = '" . $value . "'";
                $separator = " OR ";
            }
            $queryMeses = $queryMeses . ")";
        }

        $query = "SELECT t.*, p.nome, p.cpf, p.logradouro, p.numero, p.complemento, p.bairro, p.cidade, p.estado, p.cep, a.matricula, pR.nome AS nomeResponsavel, pR.cpf AS cpfResponsavel FROM titulo t
                    INNER JOIN matricula m ON t.matricula_id = m.id
                    INNER JOIN aluno a ON a.id = m.aluno_id
                    INNER JOIN grade g ON g.id = a.grade_id AND g.curso_id LIKE '".$this->params['curso']."'
                    INNER JOIN pessoa p ON p.id = a.pessoa_id
                    INNER JOIN pessoa pR ON pR.id = a.responsavel_id
                    LEFT JOIN arquivo_row ar ON ar.numero_documento = t.nosso_numero AND ar.id_ocorrencia = '2'
                  WHERE t.status = '1' AND 
                        t.situacao = 'A' AND 
                        t.valor_restante > 0 AND
                        t.configuracao_id = '" . $this->params['configuracao'] . "' AND
                        ar.nosso_numero IS NULL AND
                        YEAR(t.vencimento) = '" . date("Y") . "' $queryMeses LIMIT 10";
        $result = $conection->selectQuery($query);
        if (count($result) == 0) {
            $_SESSION['error'] = "Não existe títulos para gerar o arquivo!";
            $this->redirect($this->action, "createRemessa", null);
        } else {

            $file_name = "Furne-Remessa-" . date("YmdHis") . ".txt";
            $file = fopen(uriRemessa . $file_name, "x");
            $arquivo = new Arquivo();

            if (!$arquivo->save(array("nome" => $file_name, "descricao" => "Conta " . $arrayConfiguracao['dados']['conta'] . " <br />Arquivo de " . $conection->rows($result) . " Títulos", "type" => "REMESSA", "userCreate" => $this->params['userCreate']))) {
                $_SESSION['error'] = "Ocorreu um erro ao gerar o arquivo!";
                $this->redirect($this->action, "createRemessa", null);
            } else {
                $loteHeader = $arquivo->id;
                $lote = "0001";
                $empresa = new Empresa();
                $arrayEmpresa = $empresa->get();

                fwrite($file, $this->createHeader($loteHeader, $arrayEmpresa['dados']['razao'], $arrayConfiguracao['dados']['nome_banco'], $arrayConfiguracao['dados']['banco'], $arrayEmpresa['dados']['cnpj'], $arrayConfiguracao['dados']['codigo_remessa']));
                fwrite($file, $this->createHeaderLote($loteHeader, $lote, $arrayEmpresa['dados']['razao'], $arrayConfiguracao['dados']['banco'], $arrayEmpresa['dados']['cnpj'], $arrayConfiguracao['dados']['codigo_remessa']));

                $idLine = 0;
                $desconto = new Desconto();
                $data = new Data();
                while ($line = $conection->fetch($result)) {
                    $arrayDesconto = $desconto->listarByTitulo($line['id']);
                    $valorDesconto = 0;
                    foreach ($arrayDesconto as $descontoInstance) {
                        $arrayType = explode("-", $descontoInstance['dados']['type']);
                        if ($descontoInstance['dados']['status'] == '1' && $arrayType[1] == "0") {
                            $valorDesconto = $valorDesconto + $descontoInstance['dados']['valor'];
                        }
                    }

                    $valorTitulo = $line['valor_restante'];
                    if ($valorDesconto < $valorTitulo) {
                        $idLine++;
                        $arrayConta = explode("-", $arrayConfiguracao['dados']['conta']);
                        fwrite($file, $this->createLineP($arrayConfiguracao['dados']['banco'], $lote, $idLine, $arrayConfiguracao['dados']['agencia'], "3", $arrayConta[0], $arrayConta[1], $line['nosso_numero'], $data->dataUSAToDataBrasil($line['vencimento']), $valorTitulo, $valorDesconto));
                        $idLine++;
                        fwrite($file, $this->createLineQ($arrayConfiguracao['dados']['banco'], $lote, $idLine, $line['cpf'], $line['nome'], $line['logradouro'] . " " . $line['numero'] . " " . $line['complemento'], $line['bairro'], $line['cep'], $line['cidade'], $line['estado'], $line['nomeResponsavel'], $line['cpfResponsavel']));
                        $idLine++;
                        fwrite($file, $this->createLineR($arrayConfiguracao['dados']['banco'], $lote, $idLine, $data->dataUSAToDataBrasil($line['vencimento']), $valorTitulo));
                        $idLine++;
                        fwrite($file, $this->createLineS($arrayConfiguracao['dados']['banco'], $lote, $idLine, "01", $this->getMSGMultaJuros($data->dataUSAToDataBrasil($line['vencimento']), ($valorTitulo * ($arrayParametros['dados']['taxa_multa'] / 100)), ($valorTitulo * ($arrayParametros['dados']['taxa_mora'] / 100)))));
                    }
                }
                fwrite($file, $this->createTrailerLote($arrayConfiguracao['dados']['banco'], $lote, $idLine + 2));
                fwrite($file, $this->createTrailer($arrayConfiguracao['dados']['banco'], $idLine + 4));
                fclose($file);
                $this->download(uriRemessa . $file_name);
            }
        }
    }

    private function createHeader($lote, $nomeEmpresa, $nomeBanco, $codigoBanco, $cnpj, $codigoTransmissao) {
        $functionHTML = new FuncoesHTML();
        return
                $functionHTML->completaStringLeft($codigoBanco, "0", 3)
                . "0000"
                . "0"
                . $functionHTML->completaStringLeft("", " ", 8)
                . "2"
                . "0"
                . $functionHTML->completaStringLeft($functionHTML->limpaNumero($cnpj), "0", 14)
                . $functionHTML->completaStringLeft($codigoTransmissao, "0", 15)
                . $functionHTML->completaStringLeft("", " ", 25)
                . substr($functionHTML->limpaString($nomeEmpresa) . $functionHTML->completaStringLeft("", " ", 30), 0, 30)
                . substr($functionHTML->limpaString($nomeBanco) . $functionHTML->completaStringLeft("", " ", 30), 0, 30)
                . $functionHTML->completaStringLeft("", " ", 10)
                . "1"
                . date("dmY")
                . $functionHTML->completaStringLeft("", " ", 6)
                . $functionHTML->completaStringLeft($lote, "0", 6)
                . "040"
                . $functionHTML->completaStringLeft("", " ", 74) . "\r\n";
    }

    private function createHeaderLote($loteHeader, $lote, $nomeEmpresa, $codigoBanco, $cnpj, $codigoTransmissao) {
        $functionHTML = new FuncoesHTML();
        return
                $functionHTML->completaStringLeft($codigoBanco, "0", 3)
                . $functionHTML->completaStringLeft($lote, "0", 4)
                . "1"
                . "R"
                . "01"
                . $functionHTML->completaStringLeft("", " ", 2)
                . "030"
                . $functionHTML->completaStringLeft("", " ", 1)
                . "2"
                . "0"
                . $functionHTML->completaStringLeft($functionHTML->limpaNumero($cnpj), "0", 14)
                . $functionHTML->completaStringLeft("", " ", 20)
                . $functionHTML->completaStringLeft($codigoTransmissao, "0", 15)
                . $functionHTML->completaStringLeft("", " ", 5)
                . substr($functionHTML->limpaString($nomeEmpresa) . $functionHTML->completaStringLeft("", " ", 30), 0, 30)
                . "CNPJ DO CEDENTE: " . $cnpj . "     "
                . $functionHTML->completaStringLeft("", " ", 40)
                . $functionHTML->completaStringLeft($loteHeader, "0", 8)
                . date("dmY")
                . $functionHTML->completaStringLeft("", " ", 41) . "\r\n";
    }

    private function createLineP($codigoBanco, $lote, $idLine, $codigoAgencia, $digitoCodigoAgencia, $idConta, $digitoConta, $nossoNumero, $dataVencimento, $valorTitulo, $valorDesconto) {
        $functionHTML = new FuncoesHTML();
        $tipoDeCobrança = "5";
        $formaDeCadastramento = "1";
        $tipoDeDocumento = "2";
        $tipoDeProtesto = "0";
        return
                $functionHTML->completaStringLeft($codigoBanco, "0", 3)
                . $functionHTML->completaStringLeft($lote, "0", 4)
                . "3"
                . $functionHTML->completaStringLeft($idLine, "0", 5)
                . "P"
                . $functionHTML->completaStringLeft("", " ", 1)
                . "01"
                . $codigoAgencia
                . $digitoCodigoAgencia
                . $functionHTML->completaStringLeft($idConta, "0", 8)
                . $functionHTML->completaStringLeft($digitoConta, "0", 1)
                . $functionHTML->completaStringLeft($idConta, "0", 8)
                . $functionHTML->completaStringLeft($digitoConta, "0", 1)
                . $functionHTML->completaStringLeft("", " ", 2)
                . $functionHTML->completaStringLeft($nossoNumero, "0", 13)
                . $tipoDeCobrança
                . $formaDeCadastramento
                . $tipoDeDocumento
                . $functionHTML->completaStringLeft("", " ", 1)
                . $functionHTML->completaStringLeft("", " ", 1)
                . $functionHTML->completaStringLeft($nossoNumero, "0", 15)
                . $functionHTML->limpaNumero($dataVencimento)
                . $functionHTML->completaStringLeft(number_format($valorTitulo, 2, "", ""), "0", 15)
                . "0000"
                . "0"
                . $functionHTML->completaStringLeft("", " ", 1)
                . "02"
                . "N"
                . date("dmY")
                . "1"
                . $functionHTML->limpaNumero($dataVencimento)
                . $functionHTML->completaStringLeft(number_format(($valorTitulo * 0.0017), 2, "", ""), "0", 15)
                . "1"
                . $functionHTML->limpaNumero($dataVencimento)
                . $functionHTML->completaStringLeft(number_format($valorDesconto, 2, "", ""), "0", 15)
                . $functionHTML->completaStringLeft("", "0", 15)
                . $functionHTML->completaStringLeft("", "0", 15)
                . $functionHTML->completaStringLeft($nossoNumero, "0", 25)
                . $tipoDeProtesto
                . "00"
                . "2"
                . "0"
                . "00"
                . "00"
                . $functionHTML->completaStringLeft("", " ", 11) . "\r\n";
    }

    private function createLineQ($codigoBanco, $lote, $idLine, $cpf, $nome, $endereco, $bairro, $cep, $cidade, $estado, $nomeResponsavel, $cpfResponsavel) {
        $functionHTML = new FuncoesHTML();
        return
                $functionHTML->completaStringLeft($codigoBanco, "0", 3)
                . $functionHTML->completaStringLeft($lote, "0", 4)
                . "3"
                . $functionHTML->completaStringLeft($idLine, "0", 5)
                . "Q"
                . " "
                . "01"
                . "1"
                . $functionHTML->completaStringLeft($functionHTML->limpaNumero($cpf), "0", 15)
                . substr($functionHTML->limpaString($nome) . $functionHTML->completaStringLeft("", " ", 40), 0, 40)
                . substr($functionHTML->limpaString($endereco) . $functionHTML->completaStringLeft("", " ", 40), 0, 40)
                . substr($functionHTML->limpaString($bairro) . $functionHTML->completaStringLeft("", " ", 15), 0, 15)
                . substr($functionHTML->limpaNumero($cep) . $functionHTML->completaStringLeft("", "0", 5), 0, 5)
                . substr($functionHTML->limpaNumero($cep) . $functionHTML->completaStringLeft("", "0", 5), 5, 3)
                . substr($functionHTML->limpaString($cidade) . $functionHTML->completaStringLeft("", " ", 15), 0, 15)
                . substr($functionHTML->limpaString($estado) . $functionHTML->completaStringLeft("", " ", 2), 0, 2)
                . $this->verificaTipoResponsavel($cpfResponsavel)
                . $functionHTML->completaStringLeft($functionHTML->limpaNumero($cpfResponsavel), "0", 15)
                . substr($functionHTML->limpaString($nomeResponsavel) . $functionHTML->completaStringLeft("", " ", 40), 0, 40)
                . "000"
                . "000"
                . "000"
                . "000"
                . $functionHTML->completaStringLeft("", " ", 19) . "\r\n";
    }

    private function createLineR($codigoBanco, $lote, $idLine, $dataVenvimento, $valorTitulo) {
        $functionHTML = new FuncoesHTML();
        return
                $functionHTML->completaStringLeft($codigoBanco, "0", 3)
                . $functionHTML->completaStringLeft($lote, "0", 4)
                . "3"
                . $functionHTML->completaStringLeft($idLine, "0", 5)
                . "R"
                . " "
                . "01"
                . "0"
                . $functionHTML->completaStringLeft("", "0", 8)
                . $functionHTML->completaStringLeft("", "0", 15)
                . $functionHTML->completaStringLeft("", " ", 24)
                . "1"
                . $functionHTML->limpaNumero($dataVenvimento)
                . $functionHTML->completaStringLeft(number_format(($valorTitulo * 0.02), 2, "", ""), "0", 15)
                . $functionHTML->completaStringLeft("", " ", 10)
                . $functionHTML->completaStringLeft("", " ", 40)
                . $functionHTML->completaStringLeft("", " ", 40)
                . $functionHTML->completaStringLeft("", " ", 61) . "\r\n";
    }

    private function createLineS($codigoBanco, $lote, $idLine, $idLineS, $mensagem) {
        $functionHTML = new FuncoesHTML();
        return
                $functionHTML->completaStringLeft($codigoBanco, "0", 3)
                . $functionHTML->completaStringLeft($lote, "0", 4)
                . "3"
                . $functionHTML->completaStringLeft($idLine, "0", 5)
                . "S"
                . " "
                . "01"
                . "1"
                . $idLineS
                . "4"
                . substr($mensagem . $functionHTML->completaStringLeft("", " ", 100), 0, 100)
                . $functionHTML->completaStringLeft("", " ", 119) . "\r\n";
    }

    private function createTrailerLote($codigoBanco, $lote, $qtdLines) {
        $functionHTML = new FuncoesHTML();
        return
                $functionHTML->completaStringLeft($codigoBanco, "0", 3)
                . $functionHTML->completaStringLeft($lote, "0", 4)
                . "5"
                . $functionHTML->completaStringLeft("", " ", 9)
                . $functionHTML->completaStringLeft($qtdLines, "0", 6)
                . $functionHTML->completaStringLeft("", " ", 217) . "\r\n";
    }

    private function createTrailer($codigoBanco, $qtdLines) {
        $functionHTML = new FuncoesHTML();
        return
                $functionHTML->completaStringLeft($codigoBanco, "0", 3)
                . "9999"
                . "9"
                . $functionHTML->completaStringLeft("", " ", 9)
                . "000001"
                . $functionHTML->completaStringLeft($qtdLines, "0", 6)
                . $functionHTML->completaStringLeft("", " ", 211);
    }

    private function verificaTipoResponsavel($value) {
        $functionHTML = new FuncoesHTML();
        if (strlen($functionHTML->limpaNumero($value)) == 14) {
            return "2";
        } else {
            return "1";
        }
    }

    private function getMSGMultaJuros($dataVencimento, $valorMulta, $valorJuros) {
        return "MULTA APOS " . $dataVencimento . " R$ " . number_format($valorMulta, 2, ",", "") . " E COMISSAO DE PERMANENCIA AO DIA R$ " . number_format($valorJuros, 2, ",", "");
    }

    public function _reportRemessa() {
        $fileContent = file_get_contents($_FILES['file']['tmp_name']);
        $data = array();
        $arrayLines = explode("\n", $fileContent);
        for ($index = 2; $index < count($arrayLines) - 2; $index++) {
            if (substr($arrayLines[$index], 13, 1) == "P") {
                $line = array();
                $contentLine = $arrayLines[$index];
                $line['nossoNumero'] = substr($contentLine, 44, 13);
                $dataVencimento = substr($contentLine, 77, 8);
                $line['dataVencimento'] = substr($dataVencimento, 0, 2) . "/" . substr($dataVencimento, 2, 2) . "/" . substr($dataVencimento, 4, 4);
                $valor = substr($contentLine, 85, 15);
                $line['valor'] = number_format((substr($valor, 0, 13) . "." . substr($valor, 13, 2)), 2, ",", "");
            } else if (substr($arrayLines[$index], 13, 1) == "Q") {
                $contentLine = $arrayLines[$index];
                $line['aluno'] = trim(substr($contentLine, 33, 40));
                $data[] = $line;
            }
        }
        $this->render($this->action, "reportRemessa", $data);
    }

}

?>