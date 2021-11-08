<?php

require_once '../../assets/include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

if (!isset($_GET['option']) || empty($_GET['option']))
    exit('GET option required');

if (!isset($_POST) || empty($_POST))
    exit('POST required');

if ($_GET['option'] == 'select') {
    $query = $con->prepare("CALL STP_S_Noticia(:IDNoticia)");
    $query->bindValue(':IDNoticia', $_POST['IDNoticia']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);
    $res->DataCadastro = date('d/m/Y H:i', strtotime($res->DataCadastro));
    echo json_encode($res);
}

if ($_GET['option'] == 'insert') {
    $query = $con->prepare('CALL STP_I_Noticia(:Titulo, :DataCadastro, :Texto)');
    $query->bindValue(':Titulo', $_POST['Titulo']);
    $query->bindValue(':DataCadastro', date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $_POST['DataCadastro']))));
    $query->bindValue(':Texto', $_POST['Texto']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);

    $i = 0;
    while (!empty($_FILES['Imagem']['name'][$i])) {
        $extensao = strtolower(substr($_FILES['Imagem']['name'][$i], -5));
        $novo_nome = md5(date('Y-m-d H:i:s')) . $i . $extensao;
        $destino = '../../assets/img/noticia/' . $novo_nome;

        //MOVE PARA PASTA
        move_uploaded_file($_FILES['Imagem']['tmp_name'][$i], $destino);

        //SALVA NO BANCO
        $query = $con->prepare('CALL STP_I_NoticiaImagem(:IDNoticia, :Imagem)');
        $query->bindValue(':IDNoticia', $res->IDNoticia);
        $query->bindValue(':Imagem', $novo_nome);
        $query->execute();

        $i++;
    }

    echo json_encode($res);
}

if ($_GET['option'] == 'update') {
    $query = $con->prepare('CALL STP_U_Noticia(:IDNoticia, :Titulo, :DataCadastro, :Texto)');
    $query->bindValue(':IDNoticia', $_POST['IDNoticia']);
    $query->bindValue(':Titulo', $_POST['Titulo']);
    $query->bindValue(':DataCadastro', date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $_POST['DataCadastro']))));
    $query->bindValue(':Texto', $_POST['Texto']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);

    $i = 0;
    while (!empty($_FILES['Imagem']['name'][$i])) {
        $extensao = strtolower(substr($_FILES['Imagem']['name'][$i], -5));
        $novo_nome = md5(date('Y-m-d H:i:s')) . $i . $extensao;
        $destino = '../../assets/img/noticia/' . $novo_nome;

        //MOVE PARA PASTA
        move_uploaded_file($_FILES['Imagem']['tmp_name'][$i], $destino);

        //SALVA NO BANCO
        $query = $con->prepare('CALL STP_I_NoticiaImagem(:IDNoticia, :Imagem)');
        $query->bindValue(':IDNoticia', $res->IDNoticia);
        $query->bindValue(':Imagem', $novo_nome);
        $query->execute();

        $i++;
    }

    echo json_encode($res);
}

if ($_GET['option'] == 'delete') {
    $query = $con->prepare('CALL STP_D_Noticia(:IDNoticia)');
    $query->bindValue(':IDNoticia', $_POST['IDNoticia']);
    $query->execute();

    //EXCLUI AS IMAGENS DA NOTICIA DA PASTA
    while ($res = $query->fetch(PDO::FETCH_OBJ)) {
        unlink('../../assets/img/noticia/' . $res->Imagem);
    }
}

if ($_GET['option'] == 'imagemCapa') {
    if (!isset($_POST) || empty($_POST))
        exit('POST required');

    $query = $con->prepare('CALL STP_U_NoticiaImagemCapa(:IDNoticia, :IDNoticiaImagem)');
    $query->bindValue(':IDNoticia', $_POST['IDNoticia']);
    $query->bindValue(':IDNoticiaImagem', $_POST['IDNoticiaImagem']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);
    echo json_encode($res);
}

if ($_GET['option'] == 'imagemExclui') {
    if (!isset($_POST) || empty($_POST))
        exit('POST required');

    //EXLUI A IMAGEM DA PASTA
    $query = $con->prepare('CALL STP_D_NoticiaImagem(:IDNoticiaImagem)');
    $query->bindValue(':IDNoticiaImagem', $_POST['IDNoticiaImagem']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);
    echo json_encode($res);

    unlink('../../assets/img/noticia/' . $res->Imagem);
}
