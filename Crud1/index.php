<?php include("paises.php"); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>CRUD Mundo - Países</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Gerenciar Países</h2>

    <!-- Formulário Adicionar -->
    <form action="paises.php?acao=adicionar" method="POST" class="form-inline">
        <input type="text" name="nome" placeholder="Nome do país" required>
        <select name="continente_id" required>
            <option value="">Selecione o continente</option>
            <option value="1">América do Sul</option>
            <option value="2">América do Norte</option>
            <option value="3">Europa</option>
            <option value="4">África</option>
            <option value="5">Ásia</option>
            <option value="6">Oceania</option>
        </select>
        <button type="submit" class="btn add">Adicionar</button>
    </form>

    <!-- Tabela -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Continente</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $continentes = [
                1 => "América do Sul",
                2 => "América do Norte",
                3 => "Europa",
                4 => "África",
                5 => "Ásia",
                6 => "Oceania"
            ];
            $paises = listarPaises();
            foreach ($paises as $p) {
                echo "<tr>
                        <td>{$p['id']}</td>
                        <td>{$p['nome']}</td>
                        <td>" . ($continentes[$p['continente_id']] ?? "Não definido") . "</td>
                        <td>
                            <a href='cidades_view.php?pais_id={$p['id']}' class='btn view'>Cidades</a>
                            <a href='editar_pais.php?id={$p['id']}' class='btn edit'>Editar</a>
                            <form action='paises.php?acao=deletar&id={$p['id']}' method='POST' style='display:inline'>
                                <button type='submit' class='btn delete' onclick=\"return confirm('Excluir país?')\">Excluir</button>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
