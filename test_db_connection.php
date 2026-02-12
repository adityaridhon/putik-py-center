<?php

// Test database connection
try {
    $pdo = new PDO(
        "mysql:host=127.0.0.1;port=3306",
        "root",
        ""
    );
    
    echo "✅ MySQL Connection: SUCCESS\n";
    
    // Check if database exists
    $databases = $pdo->query("SHOW DATABASES LIKE 'putik_py_center'")->fetchAll();
    
    if (count($databases) > 0) {
        echo "✅ Database 'putik_py_center': EXISTS\n";
        
        // Try to connect to the database
        $pdo->exec("USE putik_py_center");
        
        // Check users table
        $tables = $pdo->query("SHOW TABLES LIKE 'users'")->fetchAll();
        if (count($tables) > 0) {
            echo "✅ Table 'users': EXISTS\n";
            
            // Count users
            $result = $pdo->query("SELECT COUNT(*) as count FROM users")->fetch();
            echo "📊 Total users in database: " . $result['count'] . "\n";
        } else {
            echo "❌ Table 'users': NOT FOUND\n";
            echo "   Run: php artisan migrate\n";
        }
    } else {
        echo "❌ Database 'putik_py_center': NOT FOUND\n";
        echo "   Creating database...\n";
        $pdo->exec("CREATE DATABASE putik_py_center");
        echo "✅ Database created successfully!\n";
        echo "   Now run: php artisan migrate\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database Connection FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nPossible solutions:\n";
    echo "1. Make sure MySQL is running\n";
    echo "2. Check .env file credentials\n";
    echo "3. Verify MySQL port (default: 3306)\n";
}
