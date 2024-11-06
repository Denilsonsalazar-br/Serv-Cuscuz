<?php
// Verifica se a classe Conexao já foi definida para evitar declaração duplicada
if (!class_exists('Conexao')) {
    class Conexao {
        private static $conexao;

        private function __construct() {
            // Log para verificar quando a classe é instanciada
            error_log("Classe Conexao instanciada");
        }

        public static function getInstance(){
            if (!isset(self::$conexao)) {
                try {
                    $options = array(
                        PDO::ATTR_PERSISTENT => true,
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4', // Melhor para UTF-8
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    );
                    self::$conexao = new PDO("mysql:host=localhost;dbname=Serv+Cuscuz", "root", "", $options);
                } catch (PDOException $exc) {
                    echo "Erro ao conectar ao banco: " . $exc->getMessage();
                }
            }
            return self::$conexao;
        }
    }
}