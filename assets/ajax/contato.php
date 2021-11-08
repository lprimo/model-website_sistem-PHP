<?php

if(!isset($_POST))
	exit;

require_once '../include/config.php';
require_once '../include/class.phpmailer.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$cidade = $_POST['cidade'];
$telefone = $_POST['telefone'];
$celular = $_POST['celular'];
$mensagem = $_POST['detalhes'];

$mailer = new PHPMailer();
$mailer->IsSMTP();
$mailer->IsHTML(true);
$mailer->CharSet = 'UTF-8';
$mailer->SMTPDebug = 0;
$mailer->Port = 587; //Indica a porta de conexão para a saída de e-mails. Utilize obrigatoriamente a porta 587.

$mailer->Host = $email_host; //Onde em 'servidor_de_saida' deve ser alterado por um dos hosts abaixo:
//Para cPanel: 'localhost';
//Para Plesk 11 / 11.5: 'smtp.dominio.com.br';

//Descomente a linha abaixo caso revenda seja 'Plesk 11.5 Linux'
//$mailer->SMTPSecure = 'tls';
$mailer->SMTPAuth = true; //Define se haverá ou não autenticação no SMTP
$mailer->Username = $email_autenticacao; //Informe o e-mai o completo
$mailer->Password = $senha_autenticacao; //Senha da caixa postal
$mailer->FromName = $nome; //Nome que será exibido para o destinatário
$mailer->From = $email_from; //Obrigatório ser a mesma caixa postal indicada em "username"
$mailer->AddAddress($email_to); //Destinatários
$mailer->AddReplyTo($email);
$mailer->Subject = 'Contato - '.$nome_site;
$mailer->Body = "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
	<meta charset='UTF-8'>
	<title>Contato - $nome_site</title>
</head>
<body>
	<div style='position: relative; margin: 0 auto; padding-left: 40px; width: 600px; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 13px; background-image:url($url_site/assets/img/email/BGTexture.png); background-color: #f7f7f7;'>
		<table border='0' cellpadding='0' cellspacing='0' width='560'>
			<thead>
				<tr>
					<td height='40'>&nbsp;</td>
				</tr>
			</thead>
			<tr>
				<td>
					<table border='0' cellpadding='0' cellspacing='0' width='560'>
						<tbody>
							<tr id='invite_body_main' bgcolor='#f7f7f7'>
								<td valign='top'>
									<table width='560' border='0' cellpadding='0' cellspacing='0'>
										<tr>
											<td style='line-height:9px;'>
												<img src='$url_site/assets/img/email/topcorners.gif' width='560' height='9' />
											</td>
										</tr>
										<tr>
											<td>
												<table width='560' border='0' cellspacing='0' cellpadding='0' style='border-left:1px solid #dedede;border-right:1px solid #dedede;padding-top:0px;padding-bottom:0px;'>
													<tr>
														<td width='29'></td>
														<td width='500' class='customize_change' style='color:#404040; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;'>
															<div style='text-align:center; margin-top:30px; margin-bottom:0px;'>
																<p style='font-size:17px; line-height:21px;'>
																	<a href='$url_site/' target='_blank' style='text-decoration: none;'>
																		<img src='$url_site/assets/img/logo.png' alt='' border='0' style='margin:0 auto;'>
																	</a>
																	<br>
																	<strong id='invite_body_salutation_all' style='display:inline'>
																		<span id='invite_body_salutation' class='customize_change' style='color:#404040;'>
																			Contato - $nome_site
																		</span>
																	</strong>
																	<br />
																	<span class='customize_change' style='font-size:13px; font-weight:400px; line-height:18px; margin-top:0; color: #404040'>
																		Em ' <span style='color:#CC0000;'>"  . date('d/m/Y') .  "</span> ', às  <span style='color:#CC0000;'>"  . date('H:i') . "</span> , foi feito um contato:
																	</span>
																</p>
															</div>
															<div style='margin-top:24px;'>
																<img src='$url_site/assets/img/email/lottering.png' alt='divider' width='500' height='8' />
															</div>
															<div style='margin-top:24px;'>
																<p class='customize_change' style='line-height:18px; margin-top:0px; color:#404040;'>
																	<strong>Nome:</strong> <span>  $nome  </span>
																</p>
																<p class='customize_change' style='line-height:18px; margin-top:10px; color:#404040;'>
																	<strong>Email:</strong> <span> $email </span>
																</p>
																<p class='customize_change' style='line-height:18px; margin-top:10px; color:#404040;'>
																	<strong>Telefone:</strong> <span> $telefone </span>
																</p>
																<p class='customize_change' style='line-height:18px; margin-top:10px; color:#404040;'>
																	<strong>Celular:</strong> <span> $celular </span>
																</p>
																<p class='customize_change' style='line-height:18px; margin-top:10px; color:#404040;'>
																	<strong>Mensagem:</strong> <br> <span> $mensagem </span>
																</p>
															</div>
															<img src='$url_site/assets/img/email/lottering.png' alt='divider' width='500' height='8' />
															<table width='500' border='0' cellpadding='0' cellspacing='0' style='font-size:13px; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; line-height:18px; margin:20px 0 24px 0;'>
																<tr>
																	<td>
																		<div id='invite_body_custom_message'>
																			<div class='customize_change' style='color:#404040;'>
																				Formulário de contato recebido pelo site: <a href='$url_site' target='_blank' style='text-decoration: none; color: #CC0000;'>$url_site</a>
																			</div>
																		</div>
																	</td>
																</tr>
															</table>
															<br>
														</td>
														<td width='29'></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td style='line-height:9px;'>
												<img src='$url_site/assets/img/email/bottomcorners.gif' alt='eventbrite' width='560' height='9' />
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
";

$mailer->Send();

?>