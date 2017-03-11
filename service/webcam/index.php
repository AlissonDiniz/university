<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="<?= css ?>webcam/main.css" />
    <script type="text/javascript" src="<?= js ?>jquery/jquery-1.8.0.min.js" ></script>
    <script type="text/javascript" src="<?= js ?>jquery/jquery.base64.min.js"></script>
    <script type="text/javascript" src="<?= js ?>jquery/jquery.webcam.js"></script>
</head>
<script type="text/javascript">
    var image = null;
    var ctx = null;
    var pos = 0;
    var p_canvas = 0;
    var cpfVar = '<? echo $data; ?>';

    function criarFotoPerfil(){
        $("#salvar_foto").hide();
        $("#criarFoto").hide();
        $("#updateFoto").show();
        $("#webcam").webcam({
            width: 320,
            height: 240,
            mode: "callback",
            swffile: "<?= swf ?>jscam_canvas_only.swf",
            debug: function(type, msg) {
                console.log(type + ": " + msg);
            },
            onCapture: function() {
                webcam.save();
            },
            onSave: function(data) {
                var col      = data.split(";");
                var img      = image;

                for(var i = 0; i < 320; i++) {
                    var x = pos % (320 * 4);
                    var tmp = parseInt(col[i]);

                    if (x > 70 * 4 && x <= (320 - 70) * 4) {
                        img.data[p_canvas + 0] = (tmp >> 16) & 0xff;
                        img.data[p_canvas + 1] = (tmp >> 8) & 0xff;
                        img.data[p_canvas + 2] = tmp & 0xff;
                        img.data[p_canvas + 3] = 0xff;
                        p_canvas += 4
                    }

                    pos += 4;
                }

                if (pos >= 320 * 240 * 4) {
                    ctx.putImageData(img, 0, 0);
                    pos = 0;
                    p_canvas = 0;
                    $("#salvar_foto").show();
                }
            }
        });
    }

    jQuery(function(){
        criarFotoPerfil();
        var img = new Image();
        img.src = '<?= path ?>images/profile/?id='+$.base64.encode(cpfVar);
        img.onload = function() {
            ctx.drawImage(img, 0, 0);
        }

        $("#salvar_foto").click(function() {
            $("#spinner").show();
            $("#tirar_foto").hide();
            $("#salvar_foto").hide();
            $.post("<?= $uri ?>upLoad", {type: "data",
                image: canvas.toDataURL("image/png"),
                filename: cpfVar}, function(data) {
                $("#spinner").hide();
                $("#tirar_foto").show();
                alert(data);
            });
        });

        $("#tirar_foto").click(function() {
            webcam.capture();
        });

        var canvas = document.getElementById("canvas");

        if (canvas.getContext) {
            ctx = document.getElementById("canvas").getContext("2d");
            ctx.clearRect(0, 0, 180, 240);
            image = ctx.getImageData(0, 0, 180, 240);
        }
    });
</script>
<body>
    <div id="estudio">
        <div id="createFoto">
            <canvas id="canvas" class="moldura" height="240" width="180"></canvas>
        </div>
        <div id="updateFoto">
            <div id="webcam" class="moldura"></div>
            <div class="clear">
                <img alt="" id="spinner" src="<?= image ?>proprio/spinner.gif" />
                <a href="#" id="tirar_foto">&raquo;Tirar Foto</a>
                <a href="#" id="salvar_foto">&raquo;Salvar</a>
            </div>
        </div>
    </div>
</body>
</html>

