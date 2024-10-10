<?php
class Conexao {
    public static function getConexao() {
        try {
            return new PDO("mysql:host=localhost;dbname=serv+cuscuz", "root", "");
        } catch (\PDOException $e) {
            echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
            return null;
        }
    }
}

