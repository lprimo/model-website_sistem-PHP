function pesquisacep(string){
	var cep = string.replace(/\D/g, '');
	if(cep != ''){
		var validacep = /^[0-9]{8}$/;
		if(validacep.test(cep)){
			$('.logradouro').val('Carregando...');
			$('.bairro').val('Carregando...');
			$('.cidade').val('Carregando...');
			$('.uf').val('Carregando...');
			var script = document.createElement('script');
			script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
			document.body.appendChild(script);
		}
		else{
			limpa_formulario_cep();
			alert('Formato de CEP inválido.');
		}
	}
	else
		limpa_formulario_cep();
}

function limpa_formulario_cep(){
	$('.logradouro').val('');
	$('.bairro').val('');
	$('.cidade').val('');
	$('.uf').val('');
}

function meu_callback(conteudo) {
	if (!("erro" in conteudo)){
		$('.logradouro').val(conteudo.logradouro).focus();
		$('.bairro').val(conteudo.bairro).focus();
		$('.cidade').val(conteudo.localidade).focus();
		$('.uf').val(conteudo.uf).focus();
		$('.numero').focus(); //VAI PARA DIGITAR O NÚMERO
	}
	else{
		limpa_formulario_cep();
		alert('CEP não encontrado.');
	}
}