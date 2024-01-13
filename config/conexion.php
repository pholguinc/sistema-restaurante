<?php
session_start();
class Conectar
{
    protected $dbh;
    public function Conexion()
    {
        try {
            $conectar = $this->dbh = new PDO("mysql:host=localhost;dbname=bd_restaurante", "root", "12345678");


            return $conectar;
        } catch (Exception $e) {
            print "¡Error BD!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8'");
    }

    public static function ruta()
    {
        return "http://localhost:82/sistema_restaurante/";
    }
}
