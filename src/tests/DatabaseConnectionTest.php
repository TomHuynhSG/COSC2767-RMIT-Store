<?php

use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase {
    public function testDatabaseConnection() {
        $link = mysqli_connect(
            "localhost",
            "db_admin",
            "rmit_password",
            "rmit_store_db"
        );

        $this->assertInstanceOf(mysqli::class, $link);
        // Checks if $link is an instance of the mysqli class,
        // which implies a successful database connection.
    }
}