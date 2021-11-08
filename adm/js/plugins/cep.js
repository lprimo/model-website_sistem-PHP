function pesquisacep(string){
	var cep = string.replace(/\D/g, '');
	if(cep != ''){
		var validacep = /^[0-9]{8}$/;
		if(validacep.test(cep)){
			$('.cep-logradouro').val('Carregando...');
			$('.cep-bairro').val('Carregando...');
			$('.cep-cidade').val('Carregando...');
			$('.cep-uf').val('Carregando...');
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
	$('.cep-logradouro').val('');
	$('.cep-bairro').val('');
	$('.cep-cidade').val('');
	$('.cep-uf').val('');
}

function meu_callback(conteudo) {
	if (!("erro" in conteudo)){
		$('.cep-logradouro').val(conteudo.logradouro).focus();
		$('.cep-bairro').val(conteudo.bairro).focus();
		$('.cep-cidade').val(conteudo.localidade).focus();
		$('.cep-uf').val(conteudo.uf).focus();
		$('.cep-numero').focus(); //VAI PARA DIGITAR O NÚMERO
	}
	else{
		limpa_formulario_cep();
		alert('CEP não encontrado.');
	}
}
