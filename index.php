<html>
<head>	
	<script
			  src="https://code.jquery.com/jquery-3.3.1.js"
			  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
			  crossorigin="anonymous"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script>
	function calcular() {
		var opSel = $("#combo").find("option:selected").val();
	    $.ajax({
	        url: "operaciones.php",
	        type: "POST",       
	        data: {
	        	"operacion": opSel,
	        	"numeros": "12, 2", 
	        	"datos": '{"username":"admin", "password":"9542931e640c671a60ea44a954b249c179da1239"}' 
	        },

	        success: function(ajaxResponse){
	            //var parsed_data = JSON.parse(ajaxResponse);
	            $("#divResultado").html(ajaxResponse);
	            //Para debug del ajax
	            console.log("Success! = " + ajaxResponse );

	        }, 
	        error: function(error) {
	            console.log("Error: " + JSON.stringify(error));

	        },
	        complete : function(){
	            console.log("Complete!");
	        }
	    });
}

$(document).ready(function(){
    $("#paneEnvia").click(function(evt){
    	//Para denug del AJAX
  		//console.log("Envialo");
  		calcular();  	
  		//Para debug por post
  		//$("#formulario").submit();
    });
});
</script>	

</head>
<body>
	<div class="container">
		<h1>Operaciones</h1>	
		<form action="operaciones.php" method="post" id="formulario">
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label class="control-label">
						Seleccione una operaci&oacute;n
						</label>
						<select name="combo" id="combo" class="form-control">
							<option value="0">Seleccione</option>
							<option value="1">Dividir</option>
							<option value="2">Multiplicar</option>
							<option value="3">Suma</option>
							<option value="4">Resta</option>
						</select>
					</div>
					<button class="btn btn-primary" type="button" id="paneEnvia">Enviar</button>
				</div>
			</div>		
		</form>
	<div class="row"><div class="col-sm-6"><div class="alert alert-success">
		Resultado:<span id="divResultado"></span></div></div></div>		
	</div>



</body>

</html>