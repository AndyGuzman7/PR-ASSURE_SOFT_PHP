<?php
    //Class connection contains with mysql
    class DBConnection{
        //Method getConnection()
        //Obtiene la conexion a la BD
        public static function GetConnection(){
            $server = 'localhost';
            $username = 'root';
            $password = 'Univalle';



            $database = 'id17644419_dbtaxisegurito';

            
            $conn = "mysql:host=$server;dbname=$database";
            $options=[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            try{
                $pdo = new PDO($conn, $username, $password, $options);
            } catch(PDOException $e){
                throw new PDOException($e->getMessage(),(int)$e->getCode());
            }
            return $pdo;
        }
    }
?>
