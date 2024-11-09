<?php

require_once __DIR__ . "../../../model/DAO/produtoDAO.php";

class DashboardController {

    public function mostrarDashboard() {
        $produtoDAO = new ProdutoDAO();

        $totalP = $produtoDAO->contarProdutosPorTamanho('P');
        $totalM = $produtoDAO->contarProdutosPorTamanho('M');
        $totalG = $produtoDAO->contarProdutosPorTamanho('G');

          // Passar os dados para a view via sessão
        $_SESSION['totalP'] = $totalP;
        $_SESSION['totalM'] = $totalM;
        $_SESSION['totalG'] = $totalG;

        // Carrega a view
        require_once __DIR__ . "../../../view/funcionario/paginaHomeFuncionario.php";
    }
    public function mostrarDashboardAdmin() {
      $produtoDAO = new ProdutoDAO();

      $totalP = $produtoDAO->contarProdutosPorTamanho('P');
      $totalM = $produtoDAO->contarProdutosPorTamanho('M');
      $totalG = $produtoDAO->contarProdutosPorTamanho('G');

        // Passar os dados para a view via sessão
      $_SESSION['totalP'] = $totalP;
      $_SESSION['totalM'] = $totalM;
      $_SESSION['totalG'] = $totalG;

      // Carrega a view
      require_once __DIR__ . "../../../view/admin/adminPainelController.php";
  }
}
