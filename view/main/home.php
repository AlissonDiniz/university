<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<link href="<?= plugin ?>wijmo/jquery-wijmo.css" rel="stylesheet" type="text/css" />
<link href="<?= plugin ?>wijmo/jquery.wijmo-complete.all.2.2.1.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= plugin ?>wijmo/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="<?= plugin ?>wijmo/globalize.min.js"></script>
<script type="text/javascript" src="<?= plugin ?>wijmo/jquery.wijmo-complete.all.2.2.1.min.js"></script>

<script id="scriptInit" type="text/javascript">
    $(document).ready(function() {
<?
$total = 0;
foreach ($data['alunos'] as $value) {
    $total = $total + $value['dados']['matriculas'];
}
?>

    $("#wijpiechart").wijpiechart({
    showChartLabels: false,
            hint: {
    enable: true,
            content: function() {
    return this.data.label + " : " + Globalize.format(this.value / this.total, "p2");
    }
    },
            header: {
    text: "Alunos por Sexo"
    },
            footer: {
    text: "Total de Alunos:  <? echo $total; ?>",
            visible: true,
            style: {fill: "#e6ebf0"}
    },
            animation: {
    enabled: true
    },
            seriesList: [
<?
$separator = "";
foreach ($data['alunos'] as $value) {
    ?>
    <? echo $separator; ?>
        {label: "<? echo $classFunction['enum']->enumSexo($value['dados']['sexo']); ?>", legendEntry: true, data: <? echo $value['dados']['matriculas']; ?>, offset: 0}
    <?
    $separator = ",";
}
?>
    ]
    });
<?
$total = 0;
foreach ($data['matriculas'] as $value) {
    $total = $total + $value['dados']['matriculas'];
}
?>

    $("#chartMatriculas").wijpiechart({
    showChartLabels: false,
            hint: {
    enable: true,
            content: function() {
    return this.data.label + " : " + Globalize.format(this.value / this.total, "p2");
    }
    },
            header: {
    text: "Demonstrativo das Matriculas"
    },
            footer: {
    text: "Total de Alunos:  <? echo $total; ?>",
            visible: true,
            style: {
    fill: "#e6ebf0"
    }
    },
            animation: {
    enabled: true
    },
            seriesList: [
<?
$separator = "";
foreach ($data['matriculas'] as $value) {
    ?>
    <? echo $separator; ?>
        {label: "Alunos <? echo $classFunction['enum']->enumOpcoes($value['dados']['situacao'], $classFunction['situacaoPeriodo']->loadOpcoes()); ?>", legendEntry: true, data: <? echo $value['dados']['matriculas']; ?>, offset: 0}
    <?
    $separator = ",";
}
?>
    ]
    });
<?
$valorInadimplencia = 0;
foreach ($data['inadimplencia'] as $value) {
    if ($value > $valorInadimplencia) {
        $valorInadimplencia = $value;
    }
}
$valorInadimplencia = $valorInadimplencia + 10;
?>


    $("#wijbarchart").wijbarchart({
    horizontal: false, // toggle chart type: use 'true' for bar chart and 'false' for column chart 
            axis: {
    y: {
    text: "Valor em R$",
            textStyle: {
    "font-weight": "normal"
    },
            min: 0, //Minimum value for axis 
            max: <? echo $valorInadimplencia; ?>, //Maximum value for axis 
            autoMin: false, //Tell the chart not to automatically generate minimum value for axis 
            autoMax: false, //Tell the chart not to automatically generate maximum value for axis 
            annoFormatString: 'n0', //Format values on axis as number with 0 decimal places. For example, 4.00 would be shown as 4 
            alignment: "far", //axis text aligned away from xy intersection 
            labels: {
    textAlign: "near"
    }
    },
            x: {
    textStyle: {
    "font-weight": "normal"
    }
    }
    },
            showChartLabels: false,
            hint: {
    //Display custom information in tooltip. If not set, the content will default to x and y data display values 
    content: function () {
    //Check if multiple data points are on one axis entry. For example, multiple data entries for a single date.  
    if ($.isArray(this)) {
    var content = "";
            //Multiple entries of data on this point, so we need to loop through them to create the tooltip content. 
            for (var i = 0; i < this.length; i++) {
    content += this[i].label + ': ' + Globalize.format(this[i].y * 1000, 'c0') + '\n';
    }
    return content;
    }
    else {
    //Only a single data point, so we return a formatted version of it. "/n" is a line break. 
    return this.data.label + '\n' +
            //Format x as Short Month and long year (Jan 2010). Then format y value as calculated currency with no decimal ($1,983,000).  
            Globalize.format(this.x, 'MMM yyyy') + ': ' + Globalize.format(this.y * 1000, 'c0');
    }
    },
            contentStyle: {
    "font-size": "14px",
            "font-family": '"Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif'
    },
            style: {
    fill: "#444444"
    }
    },
            shadow: false,
            textStyle: {
    "font-size": "13px",
            "font-family": '"Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif'
    },
            header: {
    text: "Gráfico da Inadimplência por Mês - <? echo date("Y"); ?>"
    },
            legend: {
    visible: true,
            compass: "north",
            orientation: "horizontal"
    },
            data: {
    //X axis values as Date objects. We are using a shared x value array for this chart with multiple y value arrays. 
    x: [
            "Janeiro",
            "Fevereiro",
            "Marco",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"]
    },
            seriesList: [{
    label: "Soma dos Títulos",
            legendEntry: true,
            data: {
    //Y axis values for 2nd series 
    y: [

<?
echo $data['inadimplencia'][1] . ",";
echo $data['inadimplencia'][2] . ",";
echo $data['inadimplencia'][3] . ",";
echo $data['inadimplencia'][4] . ",";
echo $data['inadimplencia'][5] . ",";
echo $data['inadimplencia'][6] . ",";
echo $data['inadimplencia'][7] . ",";
echo $data['inadimplencia'][8] . ",";
echo $data['inadimplencia'][9] . ",";
echo $data['inadimplencia'][10] . ",";
echo $data['inadimplencia'][11] . ",";
echo $data['inadimplencia'][12];
?>
    ]
    }
    }],
            seriesStyles: [
    { fill: "rgb(25,162,208)", stroke: "none" }
    ]
    });
    });
</script>

<div class="col-xs-12">
    <h1>
        <img alt="" src="<?= image ?>icons/positive_dynamic.png" />
        Estat&iacute;sticas
    </h1>
    <div class="conteudo">
		<h4 class="text-center">Período de Matrícula - <strong><? echo $data['parametro']['dados']['periodoMatricula']; ?></strong></h4>
        <div class="divCharts">
			<div class="col-xs-6">
				<div id="chartMatriculas" class="ui-widget ui-widget-content ui-corner-all"></div>
			</div>
			<div class="col-xs-6">
				<div id="wijpiechart" class="ui-widget ui-widget-content ui-corner-all"></div>
			</div>
        </div>
    </div>
</div>
<div class="col-xs-12">
	<br />
    <div id="wijbarchart" class="ui-widget ui-widget-content ui-corner-all"></div>
	<br />
	<br />
</div>

