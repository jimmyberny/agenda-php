//=== Utilidades de javascript para el proyecto
/*
* div: Objeto jQuery
* template: 
*/
function uxShowMessage(div, template, _type, _title, _message) {
	div.html(Mustache.to_html(template, {type: _type, title: _title, message: _message}));
}

// Función correcta completa
function uxShowMsg(divId, templateId, _type, _title, _message) {
	$('#' + divId).html(Mustache.to_html($('#' + templateId).html(), 
		{type: _type, title: _title, message: _message}));
}

// Mensaje genérico
function uxGenericMsg(div, template, params) {
	// div.append(Mustache.to_html(template, params));
	$(Mustache.to_html(template, params)).prependTo(div).fadeOut(2500);
	// div.slideDown(1500).fadeOut(2500);
}

// Mensaje básico
function uxMessage(_type, _title, _message) {
	var template = '<div class=\"alert alert-{{type}} alert dismissable\">'
	template += '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>';
	template += '<strong>{{title}}: </strong>{{message}}</div>';

	// Call generic message
	uxGenericMsg($('#mensajes'), template, {type: _type, title: _title, message: _message});
}

// Mensaje de error
function uxErrorAlert(message) {
	uxMessage('danger', 'Error', message);
}

// Mensaje de éxito
function uxSuccessAlert(message) {
	uxMessage('success', 'Mensaje', message);
}

//--> Funciones de utiliería <--//
function clearForm() {
	$('.form-control').val( function() {
		return this.defaultValue;
	});
	// El campo tipo 'hidden' no se comporta como los otros
	$('#id').val(null);
}

function enableForm(enable) {
	// Desactivar la entrada de datos
	if (enable){
		$('.form-control').each(function(){
				$(this).removeAttr('disabled');
			});
	} else {
		$('.form-control').each(function(){
				$(this).attr('disabled', 'true');
			});
	}
}
//--> Terminan funciones de utilería <--//