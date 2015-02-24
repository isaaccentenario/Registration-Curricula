$(function(){
	
	url = $('body').attr('data-url'); // url do site, está em <body data-url='url'>
	
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	// A variável acima servirá para testar e-mails 

	// carregando os skills para a index
	$.post( url+"/actions/load_skills.php", {}, function(data){
		var data = JSON.parse(data);
		if( data.numrows <= 0 ) {
			$(".skills-container").html("Nenhum skill encontrado");
		} else {
			for(var i=0; i< data.num_rows; i++ ) {
				$(".skills-container").append( "<div class='skill-container'><div class='skill'><input type='checkbox' name='skill[]' value='" + data[i].id+ "'>" +data[i].name+ "</div> Uma nota: <input name='points' class='points'type='number' placeholder='1 a 5' min='1' max='5' step='1' value='' title='Que nota você dá para o seu nível de conhecimento?'></div>" );
			}
		}
	});

	// marcar checkbox ao clicar na div container
	$("div.skills-container").delegate('.skill-container .skill','click',function(){
		var input = $(this).find("input");
		if(input.prop("checked") == true)
		{
			input.prop('checked',false); 
		} 
		else 
		{ 
			input.prop('checked',true);
		}
	})

	function deactivate() {
		$(".submit-form").attr('disabled','disabled').css({"background":"#999","cursor":"auto","opacity":"0.3"});
	}
	function activate() {
		$(".submit-form").removeAttr('disabled').css({"background":"#666","cursor":"pointer","opacity":"1"});
	}
	// formulário em AJAX
	$(".registration-form").submit(function(event){
		//deactivate();
		event.preventDefault();
		var nome = $(".nome").val(); 
		var email = $(".email").val(); 
		var twitter = $(".twitter").val();
		skills = [];
		var inc = 0;
		$(".skill input:checked").each(function(){
			var selector = $(this).parent().parent().find('.points');
			var pontuation = selector.val(); 
			if(pontuation == '' ) {
				pontuacao = 2;
				alert('Quando você não define uma pontuação, o padrão \'2\' é selecionado');
			} 
			var array = [];
			array[0] = $(this).val();
			array[1] = pontuation;
			skills[inc] = JSON.stringify( array );
			inc++;
		});
		if( nome == '' || nome == ' ' || nome.length > 50 ) 
		{
			alert("Nome inválido!");  activate();
		}
		else if( re.test(email) == false)
		{
			alert("E-Mail inválido");  activate();
		}
		else if( twitter == '' || twitter == ' ' || twitter.length > 50 )
		{
			alert("Nome do twitter inválido"); activate();
		}
		else
		{
			$.post( url + "/actions/save_new.php", { nome:nome, email:email, twitter:twitter, skills: skills }, function(data){
				var data = $.parseJSON( data );
				if(data.name == false) {
					alert("Nome já existe no sistema");
					activate();
					$(".nome").focus().addClass('e_active');
				} else if( data.name == 'empty' ) {
					alert("Nome vazio não dá né chapa!");
					activate();
					$(".nome").focus().addClass('e_active');
				} else if( data.email == false ) {
					alert("Esse e-mail já existe em nosso sistema");
					activate();
					$(".email").focus().addClass('e_active');
				} else if( data.email == 'invalid' ) {
					alert("Estrutura de e-mail inválida");
					activate();
					$(".email").focus().addClass('e_active');
				} else if( data.insert == false ) {
					alert("Desculpe, mas ocorreu um erro ao inscrevê-lo, tente novamente");
					activate();
				} else if( data.insert == true ) {
					alert("Parabéns, sua inscrição foi recebida! Você será contatado em breve");
					activate();
					$("input").each(function(){
						$(this).val('').removeAttr('checked');
					})
				}
			});

		} 
	});
	$("input").blur(function(){
		$(this).removeClass("e_active");
	})
});