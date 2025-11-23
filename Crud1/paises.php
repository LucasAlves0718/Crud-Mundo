<?php
include("config.php");

// Adicionar
if (isset($_GET['acao']) && $_GET['acao'] == 'adicionar') {
    $nome = $_POST['nome'];
    $continente_id = $_POST['continente_id'];
    $lingua = $_POST['lingua'] ?? null;
    $populacao = isset($_POST['populacao']) && $_POST['populacao'] !== '' ? (int)$_POST['populacao'] : null;

    $stmt = $conn->prepare("INSERT INTO paises (nome, continente_id, lingua, populacao) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sisi", $nome, $continente_id, $lingua, $populacao);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Excluir
if (isset($_GET['acao']) && $_GET['acao'] == 'deletar') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM paises WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Editar
if (isset($_GET['acao']) && $_GET['acao'] == 'editar') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $continente_id = $_POST['continente_id'];
    $lingua = $_POST['lingua'] ?? null;
    $populacao = isset($_POST['populacao']) && $_POST['populacao'] !== '' ? (int)$_POST['populacao'] : null;

    $stmt = $conn->prepare("UPDATE paises SET nome=?, continente_id=?, lingua=?, populacao=? WHERE id=?");
    $stmt->bind_param("sisii", $nome, $continente_id, $lingua, $populacao, $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Listar países
function listarPaises() {
    global $conn;
    $sql = "SELECT id, nome, continente_id, lingua, populacao FROM paises";
    $res = $conn->query($sql);
    return $res->fetch_all(MYSQLI_ASSOC);
}
?>
