
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>

<div id="navbar" class="navbar-collapse collapse">
	<ul class="nav navbar-nav">
		<li>
			<a href="<?= application ?>main" class="menu-logo">
				<img src="<?= image ?>logos/logo-furne.png" border="0" />
			</a>
		</li>
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-search"></span>
				Busca Rápida
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?= application ?>pessoa/search">Pessoas</a></li>
			  <li><a href="<?= application ?>aluno/search">Alunos</a></li>
			</ul>
		</li>
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-list-alt"></span>
				Cadastro
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?= application ?>pessoa">Pessoas</a></li>
			  <li><a href="<?= application ?>aluno">Alunos</a></li>
			  <?
				if ($_SESSION['modulo'] == 'ACADEMICO' || $_SESSION['modulo'] == 'ALL') {
				?>
				<li role="separator" class="divider"></li>
				<li class="dropdown-header">Acad&ecirc;micos</li>
				<li><a href="<?= application ?>professor">Professores</a></li>
				<li><a href="<?= application ?>curso">Cursos</a></li>
				<li><a href="<?= application ?>disciplina">Disciplinas</a></li>
				<li><a href="<?= application ?>periodo">Períodos</a></li>
				<li><a href="<?= application ?>sala">Salas</a></li>
				<li><a href="<?= application ?>grade">Estruturas Curriculares</a></li>
				<?
				}
				?>
				<?
				if ($_SESSION['modulo'] == 'FINANCEIRO' || $_SESSION['modulo'] == 'ALL') {
				?>
				<li role="separator" class="divider"></li>
				<li class="dropdown-header">Financeiros</li>
				<li><a href="<?= application ?>configuracao">Configuração Bancária</a></li>
				<li><a href="<?= application ?>formaPagamento">Forma de Pagamento</a></li>
				<li><a href="<?= application ?>tipoDesconto">Tipo de Desconto</a></li>
				<?
				}
			  ?>
			</ul>
		</li>
		<?
        if ($_SESSION['modulo'] == 'ACADEMICO' || $_SESSION['modulo'] == 'ALL') {
		?>
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-book"></span>
				Acad&ecirc;micos
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?= application ?>turma">Turmas</a></li>
			  <li><a href="<?= application ?>turmaDisciplina">Turmas Disciplina</a></li>
			  <li><a href="<?= application ?>horario">Horários</a></li>
			</ul>
		</li>
		<?
        }
        ?>
		<?
        if ($_SESSION['modulo'] == 'FINANCEIRO' || $_SESSION['modulo'] == 'ALL') {
		?>
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-usd"></span>
				Financeiros
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?= application ?>plano">Planos de Pagamento</a></li>
			  <li><a href="<?= application ?>acrescimo">Acr&eacute;scimos</a></li>
			  <li><a href="<?= application ?>desconto">Descontos</a></li>
			  <li><a href="<?= application ?>titulo">T&iacute;tulos</a></li>
			</ul>
		</li>
		<?
        }
        ?>
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-tasks"></span>
				Lançamentos
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?= application ?>mensagem">Mensagens</a></li>
			  <li><a href="<?= application ?>pendencia">Pendências</a></li>
			  <li><a href="<?= application ?>observacao">Observações</a></li>
			  <?
			  if ($_SESSION['modulo'] == 'ACADEMICO' || $_SESSION['modulo'] == 'ALL') {
				  ?>
				  <li role="separator" class="divider"></li>
				  <li class="dropdown-header">Acad&ecirc;micos</li>
				  <li><a href="<?= application ?>turmaDisciplina/diario">Diários / Aulas</a></li>
				  <li><a href="<?= application ?>nota">Notas e Faltas</a></li>
				  <?
			  }
			  ?>
			  <?
			  if ($_SESSION['modulo'] == 'FINANCEIRO' || $_SESSION['modulo'] == 'ALL') {
				  ?>
				  <li role="separator" class="divider"></li>
				  <li class="dropdown-header">Financeiros</li>
				  <li><a href="<?= application ?>baixa">Baixas</a></li>
				  <?
			  }
			  ?>
			</ul>
		</li>
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-star"></span>
				Miscel&acirc;neas
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?= application ?>report">Gerador de Relatórios</a></li>
			  <li><a href="<?= application ?>matricula">Matriculas do Aluno</a></li>
			  <li><a href="<?= application ?>matricula/create">Matricular Aluno</a></li>
			  <?
			  if ($_SESSION['modulo'] == 'ACADEMICO' || $_SESSION['modulo'] == 'ALL') {
				  ?>
				  <li role="separator" class="divider"></li>
				  <li class="dropdown-header">Acad&ecirc;micos</li>
				  <li><a href="<?= application ?>academico/rematricular">Rematricular</a></li>
				  <li><a href="<?= application ?>equivalenciaDisciplina">Equivalências</a></li>
				  <li><a href="<?= application ?>academico/transferir">Transferência de Aluno</a></li>
				  <li><a href="<?= application ?>academico/diario">Fechar Diários</a></li>
				  <li><a href="<?= application ?>academico/historico">Atualizar o Histórico</a></li>
				  <?
			  }
			  ?>
			  <?
			  if ($_SESSION['modulo'] == 'FINANCEIRO' || $_SESSION['modulo'] == 'ALL') {
				  ?>
				  <li role="separator" class="divider"></li>
				  <li class="dropdown-header">Financeiros</li>
				  <li><a href="<?= application ?>arquivo/listRemessa">Arquivo Remessa</a></li>
				  <li><a href="<?= application ?>arquivo/listRetorno">Processar Retorno</a></li>
				  <?
			  }
			  ?>
			</ul>
		</li>
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-file"></span>
				Relat&oacute;rios
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?= application ?>report/report">Gerador de Relatórios</a></li>
			  
			  <li role="separator" class="divider"></li>
			  <li class="dropdown-header">Cadastros</li>
			  <li><a href="<?= application ?>aluno/report">Aluno</a></li>
			  <?
			  if ($_SESSION['modulo'] == 'ACADEMICO' || $_SESSION['modulo'] == 'ALL') {
				  ?>
				  <li><a href="<?= application ?>professor/report">Professor</a></li>
				  <li><a href="<?= application ?>curso/report">Curso</a></li>
				  <li><a href="<?= application ?>disciplina/report">Disciplina</a></li>
				  <li><a href="<?= application ?>sala/report">Sala</a></li>
				  <li><a href="<?= application ?>grade/report">Estrutura Curricular</a></li>
				  <?
			  }
			  ?>
			  <?
			  if ($_SESSION['modulo'] == 'ACADEMICO' || $_SESSION['modulo'] == 'ALL') {
				  ?>
				  <li role="separator" class="divider"></li>
				  <li class="dropdown-header">Acad&ecirc;micos</li>
				  <li><a href="<?= application ?>aluno/reportHistorico">Histórico do Aluno</a></li>
				  <li><a href="<?= application ?>aluno/reportRDM">RDM do Aluno</a></li>
				  <li><a href="<?= application ?>diario/alunos">Diário - Alunos</a></li>
				  <li><a href="<?= application ?>diario/listaPresenca">Diário - Lista de Presença</a></li>
				  <?
			  }
			  ?>
			  <?
			  if ($_SESSION['modulo'] == 'FINANCEIRO' || $_SESSION['modulo'] == 'ALL') {
				  ?>
				  <li role="separator" class="divider"></li>
				  <li class="dropdown-header">Financeiros</li>
				  <li><a href="<?= application ?>boleto">Boleto Mensalidade</a></li>
				  <li><a href="<?= application ?>plano/report">Planos de Pagamento</a></li>
				  <li><a href="<?= application ?>acrescimo/report">Acréscimos</a></li>
				  <li><a href="<?= application ?>desconto/report">Descontos</a></li>
				  <li><a href="<?= application ?>titulo/report">Títulos</a></li>
				  <?
			  }
			  ?>
			  <li role="separator" class="divider"></li>
			  <li class="dropdown-header">Lan&ccedil;amentos</li>
			  <li><a href="<?= application ?>baixa/report">Baixas</a></li>
			  <li><a href="<?= application ?>baixa/reportByTurma">Baixas por Turma</a></li>
			  
			  <li role="separator" class="divider"></li>
			  <li class="dropdown-header">Miscel&acirc;neas</li>
			  <li><a href="<?= application ?>matricula/alunos">Alunos Matriculados</a></li>
			  <?
			  if ($_SESSION['modulo'] == 'FINANCEIRO' || $_SESSION['modulo'] == 'ALL') {
			  ?>
			  <li><a href="<?= application ?>financeiro/inadimplencia">Inadimplência</a></li>
			  <li><a href="<?= application ?>financeiro/inadimplenciaIndividual">Inadimplência Individual</a></li>
			  <li><a href="<?= application ?>financeiro/controleFinanceiroAluno">Contr. Financeiro - Aluno</a></li>
			  <li><a href="<?= application ?>financeiro/controleFinanceiro">Contr. Financeiro - Turma</a></li>
			  <?
			  }
			  if ($_SESSION['modulo'] == 'ALL') {
			  ?>
			  <li role="separator" class="divider"></li>
			  <li class="dropdown-header">Configura&ccedil;&otilde;es</li>
			  <li><a href="<?= application ?>auditoria/logs">Auditoria de Logs</a></li>
			  <?
			  }
			  ?>
			</ul>
		</li>
		<?
		if ($_SESSION['modulo'] == 'ALL') {
		?>
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-cog"></span>
				Configura&ccedil;&atilde;o
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?= application ?>empresa">Empresa</a></li>
			  <li><a href="<?= application ?>parametro">Parametros</a></li>
			  <li><a href="<?= application ?>user">Usu&aacute;rio</a></li>
			</ul>
		</li>
		<?
		}
		?>
	</ul>
	<ul class="nav navbar-nav navbar-right">
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-user"></span>
				<? echo $_SESSION['nome']; ?>
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li role="separator" class="divider"></li>
			  <li><a href="<?= application ?>user/mudarSenha"><span class="glyphicon glyphicon-edit"></span> Mudar a Senha</a></li>
			  <li><a href="<?= service ?>account/logout"><span class="glyphicon glyphicon-off"></span> Sair do Sistema</a></li>
			</ul>
		</li>
	</ul>
</div>