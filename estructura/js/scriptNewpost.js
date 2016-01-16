
$(document).ready(function(){
	$("#texto").click(cambiarColor1);
	$("#visual").click(cambiarColor2);
	$("#area2").hide();

	function cambiarColor1(){
		$("#texto").css("background-color","white");
		$("#visual").css("background-color","#D3DCDB");

		$("#area1").slideUp(500);
		$("#area2").slideDown(500);
	}

	function cambiarColor2(){
		$("#visual").css("background-color","white");
		$("#texto").css("background-color","#D3DCDB");

		$("#area1").slideDown(500);
		$("#area2").slideUp(500);
	}

	// **********

	$('#contenedorSelect').hide();	

	$('#btnCategoria').click(mostrarSelect);

	$('#btnAceptar').click(escribirCategoria);
	$('#btnCancelar').click(esconderSelect);

	var control = true;

	function mostrarSelect(){
		$('#contenedorSelect').slideDown(500);
		$('#btnCategoria').attr("disabled","disabled");
	}

	function esconderSelect(){
		$('#contenedorSelect').slideUp(500);
		$('#btnCategoria').removeAttr("disabled");
	}

	function escribirCategoria(){
		var categoria = $('#select').val();

		categoria = categoria.substring(0,1).toUpperCase() + categoria.substring(1, categoria.length);

		if(control === true){
			$('#divCategoria').text("");
		}
		else{
			var str = $('#divCategoria').text();

			var array = str.split(", ");

			for(i = 0; i < array.length ; i++){
				if(categoria === array[i]){
					categoria = "";
					break;
				}
			}

			if(categoria !== ""){
				categoria = ", " + categoria;
			}
		}

		$('#divCategoria').append(categoria);

		control = false;

		$('#contenedorSelect').slideUp(500);
		$('#btnCategoria').removeAttr("disabled");
	}

	$('#editor3').hide();
});

// **********

$(function() {
	$("input:file").change(function (){
		var fileName = $(this).val();
	 	$("#filename").html("Imagen seleccionada");
	 	$("#filename").css("color","blue");
	});
 });

// **********

$(function(){
	$('#btnPublicar').click(asignar);

	function asignar(){
		var contenido = $('#divCategoria').text();

		contenido = contenido.replace(/\s+/g, ''); // Elimina espacios en blanco en un string.

		$('#editor3').val(contenido);
	}
});

