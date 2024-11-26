<?php
require_once __DIR__ . "../../../model/DAO/carrosselHomeDAO.php";

class CarrosselController {
    private $carrosselDAO;

    public function __construct() {
        $this->carrosselDAO = new CarrosselDAO();
    }

    // Método para listar os itens do carrossel
    public function listarItens() {
        return $this->carrosselDAO->listarItens();
    }

    // Método para atualizar um item do carrossel
    public function atualizarItem($id, $titulo, $descricao, $imagem) {
        $item = $this->carrosselDAO->buscarItemPorId($id);
    
        if ($imagem['name']) { // Se uma nova imagem foi enviada
            // Caminho completo para salvar a imagem
            $uploadDirectory = 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/';

            // Nome do arquivo enviado, substituindo espaços por sublinhados
            $nomeArquivo = str_replace(' ', '_', basename($imagem['name']));
            
            // Nome do arquivo enviado
            $nomeArquivo = basename($imagem['name']);
            
            // Caminho completo do arquivo
            $imagemUrl = $uploadDirectory . $nomeArquivo;
    
            // Move o arquivo para o diretório especificado
            if (move_uploaded_file($imagem['tmp_name'], $imagemUrl)) {
                // Armazena o caminho relativo para o banco de dados
                $item->setImagemUrl('assets/img/' . $nomeArquivo);
            } else {
                throw new Exception("Falha no upload da imagem.");
            }
        }
    
        $item->setTitulo($titulo);
        $item->setDescricao($descricao);
    
        return $this->carrosselDAO->atualizarItem($item);
    }    
    // Método para recuperar os itens do banco de dados
    public function recuperarItensDoBanco() {
        return $this->carrosselDAO->listarItens(); 
    }
}