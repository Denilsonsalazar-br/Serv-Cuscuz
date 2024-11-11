<?php


require_once __DIR__ . "../../../model/DAO/produtoDAO.php";
require_once __DIR__ . "../../../controller/categoria/listagemCategoriaController.php"; 

class DashboardController {

    public function mostrarDashboard() {
        $produtoDAO = new ProdutoDAO();
        $categoriaListController = new CategoriaListController();

        // Busca todas as categorias usando CategoriaListController
        $categorias = $categoriaListController->execute();
        $tamanhos = ['P', 'M', 'G'];
        $dadosCategorias = [];

        foreach ($categorias as $categoria) {
            $categoriaId = $categoria['id'];
            $categoriaNome = $categoria['nome'];

            foreach ($tamanhos as $tamanho) {
                $total = $produtoDAO->contarProdutosPorCategoriaETamanho($categoriaId, $tamanho);
                $dadosCategorias[$categoriaNome][$tamanho] = $total;
            }
        }

        // Armazena os dados na sessão para a visualização
        $_SESSION['dadosCategorias'] = $dadosCategorias;

        // Carrega a visualização
        require_once __DIR__ . "../../../view/funcionario/paginaHomeFuncionario.php";
    }

    public function mostrarDashboardAdmin() {
        $produtoDAO = new ProdutoDAO();
        $categoriaListController = new CategoriaListController();

        // Busca todas as categorias usando CategoriaListController
        $categorias = $categoriaListController->execute();
        $tamanhos = ['P', 'M', 'G'];
        $dadosCategorias = [];

        foreach ($categorias as $categoria) {
            $categoriaId = $categoria['id'];
            $categoriaNome = $categoria['nome'];

            foreach ($tamanhos as $tamanho) {
                $total = $produtoDAO->contarProdutosPorCategoriaETamanho($categoriaId, $tamanho);
                $dadosCategorias[$categoriaNome][$tamanho] = $total;
            }
        }

        // Armazena os dados na sessão para a visualização
        $_SESSION['dadosCategorias'] = $dadosCategorias;
        //var_dump($_SESSION['dadosCategorias']);

        // Carrega a visualização para o administrador
        require_once __DIR__ . "../../../view/admin/adminPainelController.php";
    }
}
