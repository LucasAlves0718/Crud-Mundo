<?php
include("config.php");

// Adicionar
if (isset($_GET['acao']) && $_GET['acao'] == 'adicionar') {
    $nome = $_POST['nome'];
    $pais_id = $_POST['pais_id'];

    $stmt = $conn->prepare("INSERT INTO cidades (nome, pais_id) VALUES (?, ?)");
    $stmt->bind_param("si", $nome, $pais_id);
    $stmt->execute();
    header("Location: cidades_view.php?pais_id=$pais_id");
    exit;
}

// Excluir
if (isset($_GET['acao']) && $_GET['acao'] == 'deletar') {
    $id = $_GET['id'];
    $pais_id = $_GET['pais_id'];
    $stmt = $conn->prepare("DELETE FROM cidades WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: cidades_view.php?pais_id=$pais_id");
    exit;
}

// Editar
if (isset($_GET['acao']) && $_GET['acao'] == 'editar') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $pais_id = $_POST['pais_id'];

    $stmt = $conn->prepare("UPDATE cidades SET nome=? WHERE id=?");
    $stmt->bind_param("si", $nome, $id);
    $stmt->execute();
    header("Location: cidades_view.php?pais_id=$pais_id");
    exit;
}

// Listar
function listarCidades($pais_id) {
    global $conn;
    $sql = "SELECT id, nome FROM cidades WHERE pais_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pais_id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_all(MYSQLI_ASSOC);
}
?>
