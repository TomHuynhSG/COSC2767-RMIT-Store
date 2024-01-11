<?php

use PHPUnit\Framework\TestCase;

class PHPQueryTest extends TestCase
{
    public function testDatabaseConnection()
    {
        $dsn = 'localhost';
        $username = 'db_admin';
        $password = 'rmit_password';
        $database="rmit_store_db";

        $dbConnection = mysqli_connect($dsn, $username, $password,$database);

        $query = "SELECT * FROM store";
        $result = mysqli_query($dbConnection,$query);

        $this->assertNotEmpty($result);
    }


    public function testInvalidQueryThrowsException()
    {
        $this->expectException(PDOException::class);

        $dsn = 'localhost';
        $username = 'db_admin';
        $password = 'rmit_password';

        $dbConnection = new PDO($dsn, $username, $password);

        $invalidQuery = "SELECT * FROM non_existing_table";
        $dbConnection->query($invalidQuery);
    }


    public function testNoDataFoundReturnsEmptyArray()
    {
        $dsn = 'localhost';
        $username = 'db_admin';
        $password = 'rmit_password';
        $database="rmit_store_db";

        $dbConnection = mysqli_connect($dsn, $username, $password,$database);

        $query = "SELECT * FROM store WHERE id = 999";
        $userData = $dbConnection->query($query);

        $this->assertNotEmpty($userData);
    }
}
