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
    
        // Validação da imagem enviada
        if ($imagem['name']) { // Verifica se uma nova imagem foi enviada
            $maxSize = 5000000; // 5MB
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $uploadDirectory = 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/';
    
            // Verifica o tamanho do arquivo
            if ($imagem['size'] > $maxSize) {
                $_SESSION['msg'] = [
                    'tipo' => 'erro',
                    'mensagem' => 'O tamanho da imagem não pode exceder 5MB.'
                ];
                return false; // Interrompe a execução
            }
    
            // Verifica a extensão do arquivo
            $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
            if (!in_array($extensao, $allowedExtensions)) {
                $_SESSION['msg'] = [
                    'tipo' => 'erro',
                    'mensagem' => 'Tipo de arquivo não permitido. Use JPG, JPEG, PNG ou GIF.'
                ];
                return false; // Interrompe a execução
            }
    
            // Nome do arquivo tratado
            $nomeArquivo = str_replace(' ', '_', basename($imagem['name']));
            $imagemUrl = $uploadDirectory . $nomeArquivo;
    
            // Move o arquivo para o diretório especificado
            if (move_uploaded_file($imagem['tmp_name'], $imagemUrl)) {
                $item->setImagemUrl('assets/img/' . $nomeArquivo);
            } else {
                $_SESSION['msg'] = [
                    'tipo' => 'erro',
                    'mensagem' => 'Erro ao fazer upload da imagem. Tente novamente.'
                ];
                return false;
            }
        }
    
        // Atualiza os outros campos do item
        $item->setTitulo($titulo);
        $item->setDescricao($descricao);
    
        // Atualiza o item no banco de dados
        if ($this->carrosselDAO->atualizarItem($item)) {
            $_SESSION['msg'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Imagem do carrossel atualizada com sucesso!'
            ];
            return true;
        } else {
            $_SESSION['msg'] = [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao atualizar o item no banco de dados.'
            ];
            return false;
        }
    }

    public function adicionarItem($titulo, $descricao, $imagem) {
        $item = new CarrosselDTO(); // Presumo que você tenha um DTO para o carrossel.
    
        // Validação e upload da imagem
        if ($imagem['name']) { 
            $maxSize = 5000000; // 5MB
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $uploadDirectory = 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/';
    
            if ($imagem['size'] > $maxSize) {
                $_SESSION['msg'] = [
                    'tipo' => 'erro',
                    'mensagem' => 'O tamanho da imagem não pode exceder 5MB.'
                ];
                return false;
            }
    
            $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
            if (!in_array($extensao, $allowedExtensions)) {
                $_SESSION['msg'] = [
                    'tipo' => 'erro',
                    'mensagem' => 'Tipo de arquivo não permitido. Use JPG, JPEG, PNG ou GIF.'
                ];
                return false;
            }
    
            $nomeArquivo = str_replace(' ', '_', basename($imagem['name']));
            $imagemUrl = $uploadDirectory . $nomeArquivo;
    
            if (move_uploaded_file($imagem['tmp_name'], $imagemUrl)) {
                $item->setImagemUrl('assets/img/' . $nomeArquivo);
            } else {
                $_SESSION['msg'] = [
                    'tipo' => 'erro',
                    'mensagem' => 'Erro ao fazer upload da imagem. Tente novamente.'
                ];
                return false;
            }
        } else {
            $_SESSION['msg'] = [
                'tipo' => 'erro',
                'mensagem' => 'Nenhuma imagem foi enviada.'
            ];
            return false;
        }
    
        // Configura os outros campos
        $item->setTitulo($titulo);
        $item->setDescricao($descricao);
    
        // Insere o novo item no banco de dados
        if ($this->carrosselDAO->adicionarImagemCarrossel($item)) {
            $_SESSION['msg'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Nova imagem adicionada ao carrossel com sucesso!'
            ];
            return true;
        } else {
            $_SESSION['msg'] = [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao adicionar o item no banco de dados.'
            ];
            return false;
        }
    }
    
     // Método para deletar uma imagem do carrossel (apenas do banco de dados)
     public function deletarImagem($id) {
        if ($this->carrosselDAO->deletarImagem($id)) {
            $_SESSION['msg'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Imagem excluída com sucesso!'
            ];
            return true;
        } else {
            $_SESSION['msg'] = [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao excluir a imagem.'
            ];
            return false;
        }
    }
    
    
    // Método para recuperar os itens do banco de dados
    public function recuperarItensDoBanco() {
        return $this->carrosselDAO->listarItens(); 
    }
}