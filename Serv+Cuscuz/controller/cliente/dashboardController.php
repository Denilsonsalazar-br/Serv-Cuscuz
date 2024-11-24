<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../../model/DAO/clienteDAO.php"; 

class ClienteDashboardController {

    public function mostrarDashboardCliente() {
        $clienteDAO = new ClienteDAO();

        // Dados de clientes em diferentes períodos
        $dadosDashboard = [
            'mes' => $clienteDAO->contarClientesPorPeriodo('MONTH', date('Y'), date('m')),
            'trimestre' => $clienteDAO->contarClientesPorPeriodo('QUARTER'),
            'semestre' => $clienteDAO->contarClientesPorSemestre(),
            'ano' => $clienteDAO->contarClientesPorPeriodo('YEAR'),
        ];

        // Calculando diferenças para cada período
        foreach ($dadosDashboard as $periodo => $dados) {
            if ($dados['anterior'] > 0) {
                $dadosDashboard[$periodo]['diferenca'] = (($dados['atual'] - $dados['anterior']) / $dados['anterior']) * 100;
            } else {
                $dadosDashboard[$periodo]['diferenca'] = 0;
            }
        }

        // Armazena os dados na sessão para serem usados na visualização
        $_SESSION['dadosClientes'] = $dadosDashboard;
        
        // Carrega a visualização do dashboard de clientes
        require_once __DIR__ . "../../../view/admin/adminPainelController.php";
    }
}