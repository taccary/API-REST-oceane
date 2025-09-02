<?php
    function handleBateaux(PDO $pdo, string $method) : void
    {
        switch($method)
        {
            case 'GET':
                // Récupère les bateaux
                if(!empty($_GET["id"]))
                {
                    $id=intval($_GET["id"]);
                    getBateau($id);
                }
                else
                {
                    getBateaux();
                }
                break;
            default:
                // Invalid Request Method
                header("HTTP/1.0 405 Method Not Allowed");
                break;
        }
    }
