<?php

/**
 * The class create a connection to database
 */

class DBConnection
{
    /**
     * Return a db connection
     *
     * @param string $dbHost
     * @param string $dbName
     * @param string $dbUser
     * @param string $dbPass
     * @return PDOobj
     */
    static public function getDBConnection ($dbHost, $dbName, $dbUser, $dbPass)
    {
        try {
            $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            return $dbh;
        } catch (PDOException $e) {
            die('Error of connection to database: ' . $e->getMessage());
        }
    }
}

