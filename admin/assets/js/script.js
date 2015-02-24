$(function(){

	var url = $("body").attr("data-url");

	$(".delete").click(function(){
		if( confirm('Tem certeza que deseja apagar?') ) {
			var id = $(this).attr('data-id'); 
			var parent = $(this).parent().parent().parent();

			$.post( url+'/admin/actions/delete.php', { id:id }, function(sucess){
				var data =  $.parseJSON(sucess); 
				if(data.delete == true) 
				{
					parent.slideUp('fast');
				}
				else
				{
					alert('Ocorreu um erro ao tentar excluir');
					parent.addClass('error-box'); 
					setTimeout(function(){ parent.removeClass('error-box') }, 3000);
				}
			});
		}
	});

	$(".contact").click(function(){
		var nome = $(this).parent().parent().find(".nome").text(); 
		var email = $(this).parent().parent().find(".email").text(); 
		var id = $(this).attr("data-id");
		$(".cnt").html("<div class='pp-close' title='Fechar'>X</div><form data-id='"+id+"'class='email-form'><label>E-Mail</label><input class='form-control email' value='"+email+"'><label>Assunto</label><input class='form-control assunto'><label>Mensagem</label><textarea class='form-control mensagem'>Olá "+nome+", este é um e-mail de confirmação</textarea><br />&nbsp<button type='submit' class='btn btn-default'>Enviar Contato</button></form>");
		$(".pp-fade").fadeIn('fast',function(){
			$(".popup-container").fadeIn('fast');
		});
	});

	$(".popup-container").delegate('.pp-close','click',function(){
		$(".popup-container").fadeOut("fast",function(){
			$(".pp-fade").fadeOut("fast");
		});
	});

	$(".popup-container").delegate('form','submit',function(event){
		event.preventDefault();
		var email = $(this).find('.email').val();
		var assunto = $(this).find('.assunto').val();
		var mensagem = $(this).find('.mensagem').val(); 
		var id = $(this).attr('data-id');
		$.post( url + "/admin/actions/mail.php", { id:id,email:email,assunto:assunto,mensagem:mensagem }, function(data){
			var data = $.parseJSON(data); 
			if(data.email == false) 
			{
				alert("Esse e-mail é inválido, tente outro por favor");
			}
			else if( data.mensagem == false )
			{
				alert('Mensagem vazia não dá né, parceiro?');
			}
			else if( data.mail == true )
			{
				alert("Contato enviado com sucesso!");
				$("input,textarea").val('').text('');
			}
			else if( data.mail == false )
			{
				alert("Ops! Ocorreu um erro ao tentar enviar sua mensagem, tente novamente");
			}
		})
	});

	function load_skills() {
		$.post( url + '/admin/actions/load_skills.php',{},function(data){
			var data = $.parseJSON(data); 
			var length = data.num_rows;
			console.log(length)
			if(length <=0)
			{
				$(".skills-container").html("<div class='well well-sm'> Não há registros </div>");
			}
			else
			{
				$(".skills-container").html('');
				for(var i = 0; i < length; i++ )
				{
					var ob = data[i]; 
					$(".skills-container").append("<div class='well well-sm'><h3 style='margin:0'>" + ob.name +"</h4><p>"+ob.description+"</p><button class='btn btn-default skill-delete' data-id='"+ob.id+"'>Apagar</button></div>");
				}
			}
		})
	}
	load_skills();
	$(".skill-new").submit(function(event){
		event.preventDefault(); 
		var title = $(this).find(".titulo").val();
		var description = $(this).find(".descricao").val(); 
		console.log(title,description)
		$.post( url + '/admin/actions/save_skill.php',{title:title,content:description},function(data){
			console.log(data)
			var data = $.parseJSON(data);
			console.log(data)
			if( data.save == true )
			{
				load_skills();
				$("input,textarea").val('').text('');
			}
			else
			{
				alert("Não foi possível salvar, tente novamente");
			}
		});
	});

	$(".skills-container").delegate('.skill-delete','click',function(){
		var id = $(this).attr('data-id');
		var d = $(this);
		if(confirm('Tem certeza que deseja apagar?'))
		{
			$.post( url + "/admin/actions/delete_skill.php",{id:id},function(data){
				var data = $.parseJSON(data); 
				if(data.delete == true )
				{
					d.parent().hide('fast');
					load_skills();
				}
				else
				{
					alert('Ocorreu um erro ao deletar');
				}
			});
		}
	});
});