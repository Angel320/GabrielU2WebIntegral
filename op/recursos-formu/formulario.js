const formulario = document.getElementById('form-ajax');
const inputs = document.querySelectorAll('#form-ajax input');

const expresiones = {
	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	psw: /^.{4,12}$/, // 4 a 12 digitos.
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{7,14}$/ // 7 a 14 numeros.
}

const campos = {
	usuario: false,
	nombre: false,
	psw: false,
	correo: false,
	telefono: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "usuario":
			validarCampo(expresiones.usuario, e.target, 'usuario');
		break;
		case "nombre":
			validarCampo(expresiones.nombre, e.target, 'nombre');
		break;
		case "psw":
			validarCampo(expresiones.psw, e.target, 'psw');
			validarconfirmar();
		break;
		case "confirmar":
			validarconfirmar();
		break;
		case "correo":
			validarCampo(expresiones.correo, e.target, 'correo');
		break;
		case "telefono":
			validarCampo(expresiones.telefono, e.target, 'telefono');
		break;
	}
}

const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value)){
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos[campo] = true;
	} else {
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos[campo] = false;
	}
} 

const validarconfirmar = () => {
	const inputpsw = document.getElementById('psw');
	const inputconfirmar = document.getElementById('confirmar');

	if(inputpsw.value !== inputconfirmar.value){
		document.getElementById(`grupo__confirmar`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__confirmar`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__confirmar i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo__confirmar i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo__confirmar .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos['psw'] = false;
	} else {
		document.getElementById(`grupo__confirmar`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__confirmar`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__confirmar i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo__confirmar i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo__confirmar .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos['psw'] = true;
	}
}






inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});

formulario.addEventListener('submit', (e) => {
	e.preventDefault();

	const terminos = document.getElementById('terminos');
	if(campos.usuario && campos.nombre && campos.psw && campos.correo && campos.telefono && terminos.checked ){
		formulario.reset();

		document.getElementById('formulario__mensaje-exito').classList.add('formulario__mensaje-exito-activo');
		setTimeout(() => {
			document.getElementById('formulario__mensaje-exito').classList.remove('formulario__mensaje-exito-activo');
		}, 5000);

		document.querySelectorAll('.formulario__grupo-correcto').forEach((icono) => {
			icono.classList.remove('formulario__grupo-correcto');
		});
	} else {
		document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo');
	}
});