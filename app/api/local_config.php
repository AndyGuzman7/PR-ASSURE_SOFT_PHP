<?php
    //Class connection contains with mysql
    class DBConnection{
        //Method getConnection()
        //Obtiene la conexion a la BD
        public static function GetConnection(){
            $server = 'localhost';
            $username = 'root';
            $password = 'Univalle';
<<<<<<< HEAD
            $database = 'dbtaxisegurito';
=======
            $database = 'id17644419_dbtaxisegurito';
>>>>>>> 1ce2967ca7e7a7feae1a07c6bbe54d1b7e542ef5
            
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
