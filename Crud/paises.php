<?php
include "config.php";

$acao = $_GET['acao'] ?? '';

if ($acao == 'listar') {
    $sql = "SELECT p.id, p.nome, c.nome AS continente 
            FROM paises p 
            JOIN continentes c ON p.continente_id = c.id";
    $res = $conn->query($sql);
    $dados = [];
    while($row = $res->fetch_assoc()) {
        $dados[] = $row;
    }
    echo json_encode($dados);
}

if ($acao == 'adicionar') {
    $nome = $_POST['nome'];
    $continente_id = $_POST['continente_id'];
    $sql = "INSERT INTO paises (nome, continente_id) VALUES ('$nome', $continente_id)";
    echo $conn->query($sql) ? "País adicionado!" : "Erro: ".$conn->error;
}

if ($acao == 'editar') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $continente_id = $_POST['continente_id'];
    $sql = "UPDATE paises SET nome='$nome', continente_id=$continente_id WHERE id=$id";
    echo $conn->query($sql) ? "País atualizado!" : "Erro: ".$conn->error;
}

if ($acao == 'deletar') {
    $id = $_POST['id'];
    $sql = "DELETE FROM paises WHERE id=$id";
    echo $conn->query($sql) ? "País excluído!" : "Erro: ".$conn->error;
}
?>
