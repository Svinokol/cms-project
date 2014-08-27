<link rel="stylesheet" href="http://antirek.github.io/pixi-editor/lib/seiyria-bootstrap-slider/css/bootstrap-slider.css" />
<link rel="stylesheet" href="http://antirek.github.io/pixi-editor/lib/spectrum/spectrum.css" />
<script type="text/javascript" src="http://antirek.github.io/pixi-editor/lib/seiyria-bootstrap-slider/js/bootstrap-slider.js"></script>
<script type="text/javascript" src="http://antirek.github.io/pixi-editor/lib/pixi.js/bin/pixi.dev.js"></script>
<script type="text/javascript" src="http://antirek.github.io/pixi-editor/lib/spectrum/spectrum.js"></script>
<script type="text/javascript" src="http://antirek.github.io/pixi-editor/pixi-editor.js"></script>
<script type="text/javascript">

    var editor1 = null;

    $(function(){

        editor1 = new editor('view', 650, 400);
        editor1.onSave(function(image){
            var win = window.open(image);
        });

    });

</script>

<div class="container">

    <div class="header">
        <h3>Pixi editor</h3>
    </div>

    <div class="well" id="view">
    </div>


</div>
