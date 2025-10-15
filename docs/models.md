# Model Usage Guide

This guide demonstrates how to use the BaseModel class and its PDO wrapper methods in your application.

## Overview

The `BaseModel` class provides a set of convenient methods for database operations using prepared statements. All methods use named or positional parameters for security against SQL injection.

## Basic Model Creation

Create a model class by extending `BaseModel`:

```php
<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class UserModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }
    
    // Your custom methods here...
}
```

## Available Methods

### selectAll() - Retrieve Multiple Records

```php
// Get all users.
public function getAllUsers(): array
{
    return $this->selectAll('SELECT * FROM users ORDER BY created_at DESC');
}

// Get users with conditions using named parameters.
public function getUsersByStatus(string $status): array
{
    return $this->selectAll(
        'SELECT * FROM users WHERE status = :status ORDER BY name',
        ['status' => $status]
    );
}

// Get users with multiple conditions.
public function getUsersByRoleAndStatus(string $role, string $status): array
{
    return $this->selectAll(
        'SELECT * FROM users WHERE role = :role AND status = :status',
        ['role' => $role, 'status' => $status]
    );
}
```

### selectOne() - Retrieve Single Record

```php
// Find user by ID using positional parameter.
public function findById(int $id): array|false
{
    return $this->selectOne('SELECT * FROM users WHERE id = ?', [$id]);
}

// Find user by email using named parameter.
public function findByEmail(string $email): array|false
{
    return $this->selectOne(
        'SELECT * FROM users WHERE email = :email',
        ['email' => $email]
    );
}

// Get user with related data.
public function getUserWithProfile(int $userId): array|false
{
    return $this->selectOne(
        'SELECT u.*, p.bio, p.avatar 
         FROM users u 
         LEFT JOIN profiles p ON u.id = p.user_id 
         WHERE u.id = :user_id',
        ['user_id' => $userId]
    );
}
```

### count() - Count Records

```php
// Count all users.
public function getTotalUsers(): int
{
    return $this->count('SELECT COUNT(*) FROM users');
}

// Count users by status.
public function countUsersByStatus(string $status): int
{
    return $this->count(
        'SELECT COUNT(*) FROM users WHERE status = :status',
        ['status' => $status]
    );
}

// Count active users registered this month.
public function countActiveUsersThisMonth(): int
{
    return $this->count(
        'SELECT COUNT(*) FROM users 
         WHERE status = :status 
         AND created_at >= :start_date',
        [
            'status' => 'active',
            'start_date' => date('Y-m-01')
        ]
    );
}
```

### execute() - Insert, Update, Delete Operations

```php
// Insert new user.
public function createUser(array $userData): int
{
    $rowsAffected = $this->execute(
        'INSERT INTO users (name, email, password, status, created_at) 
         VALUES (:name, :email, :password, :status, :created_at)',
        [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => password_hash($userData['password'], PASSWORD_DEFAULT),
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ]
    );
    
    return $rowsAffected;
}

// Update user information.
public function updateUser(int $id, array $userData): int
{
    return $this->execute(
        'UPDATE users 
         SET name = :name, email = :email, updated_at = :updated_at 
         WHERE id = :id',
        [
            'id' => $id,
            'name' => $userData['name'],
            'email' => $userData['email'],
            'updated_at' => date('Y-m-d H:i:s')
        ]
    );
}

// Soft delete user.
public function deleteUser(int $id): int
{
    return $this->execute(
        'UPDATE users SET status = :status, deleted_at = :deleted_at WHERE id = :id',
        [
            'id' => $id,
            'status' => 'deleted',
            'deleted_at' => date('Y-m-d H:i:s')
        ]
    );
}
```

### lastInsertId() - Get Last Inserted ID

```php
public function createUserAndGetId(array $userData): string
{
    $this->execute(
        'INSERT INTO users (name, email, password, created_at) 
         VALUES (:name, :email, :password, :created_at)',
        [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => password_hash($userData['password'], PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ]
    );
    
    return $this->lastInsertId();
}
```

### Transaction Methods

```php
public function transferUserData(int $fromUserId, int $toUserId): bool
{
    try {
        // Start transaction.
        $this->beginTransaction();
        
        // Get source user data.
        $sourceUser = $this->selectOne('SELECT * FROM users WHERE id = :id', ['id' => $fromUserId]);
        if (!$sourceUser) {
            throw new Exception('Source user not found');
        }
        
        // Update target user.
        $this->execute(
            'UPDATE users SET name = :name, updated_at = :updated_at WHERE id = :id',
            [
                'id' => $toUserId,
                'name' => $sourceUser['name'],
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );
        
        // Delete source user.
        $this->execute(
            'UPDATE users SET status = :status WHERE id = :id',
            ['id' => $fromUserId, 'status' => 'deleted']
        );
        
        // Commit transaction.
        $this->commit();
        return true;
        
    } catch (Exception $e) {
        // Rollback on error.
        $this->rollback();
        throw $e;
    }
}
```

## Complete Model Example

Here's a complete example of a UserModel with various operations:

```php
<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use Exception;

class UserModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }
    
    public function findById(int $id): array|false
    {
        return $this->selectOne('SELECT * FROM users WHERE id = :id', ['id' => $id]);
    }
    
    public function findByEmail(string $email): array|false
    {
        return $this->selectOne('SELECT * FROM users WHERE email = :email', ['email' => $email]);
    }
    
    public function getAllActiveUsers(): array
    {
        return $this->selectAll(
            'SELECT * FROM users WHERE status = :status ORDER BY name',
            ['status' => 'active']
        );
    }
    
    public function getTotalActiveUsers(): int
    {
        return $this->count('SELECT COUNT(*) FROM users WHERE status = :status', ['status' => 'active']);
    }
    
    public function createUser(array $userData): string
    {
        $this->execute(
            'INSERT INTO users (name, email, password, status, created_at) 
             VALUES (:name, :email, :password, :status, :created_at)',
            [
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => password_hash($userData['password'], PASSWORD_DEFAULT),
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        
        return $this->lastInsertId();
    }
    
    public function updateUser(int $id, array $userData): bool
    {
        $affected = $this->execute(
            'UPDATE users SET name = :name, email = :email, updated_at = :updated_at WHERE id = :id',
            [
                'id' => $id,
                'name' => $userData['name'],
                'email' => $userData['email'],
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );
        
        return $affected > 0;
    }
    
    public function deactivateUser(int $id): bool
    {
        $affected = $this->execute(
            'UPDATE users SET status = :status, updated_at = :updated_at WHERE id = :id',
            [
                'id' => $id,
                'status' => 'inactive',
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );
        
        return $affected > 0;
    }
}
```

## Best Practices

### 1. Use Named Parameters
Prefer named parameters over positional parameters for better readability:

```php
// Good - clear and readable.
$this->selectOne('SELECT * FROM users WHERE email = :email AND status = :status', [
    'email' => $email,
    'status' => 'active'
]);

// Avoid - harder to read and maintain.
$this->selectOne('SELECT * FROM users WHERE email = ? AND status = ?', [$email, 'active']);
```

### 2. Validate Input
Always validate input before using in queries:

```php
public function findById(int $id): array|false
{
    if ($id <= 0) {
        throw new InvalidArgumentException('User ID must be positive');
    }
    
    return $this->selectOne('SELECT * FROM users WHERE id = :id', ['id' => $id]);
}
```

### 3. Use Transactions for Multiple Operations
Wrap related database operations in transactions:

```php
public function registerUserWithProfile(array $userData, array $profileData): string
{
    try {
        $this->beginTransaction();
        
        // Create user
        $this->execute('INSERT INTO users ...', $userData);
        $userId = $this->lastInsertId();
        
        // Create profile
        $profileData['user_id'] = $userId;
        $this->execute('INSERT INTO profiles ...', $profileData);
        
        $this->commit();
        return $userId;
        
    } catch (Exception $e) {
        $this->rollback();
        throw $e;
    }
}
```

### 4. Handle Errors Gracefully
Always handle potential database errors:

```php
public function safeCreateUser(array $userData): array
{
    try {
        $userId = $this->createUser($userData);
        return ['success' => true, 'user_id' => $userId];
    } catch (Exception $e) {
        error_log('User creation failed: ' . $e->getMessage());
        return ['success' => false, 'error' => 'Failed to create user'];
    }
}
```

## Using Models in Controllers

Use in your controller:

```php
class UserController extends BaseController
{
    public function __construct(Container $container, private UserModel $userModel)
    {
        parent::__construct($container);
    }
    
    public function show(Request $request, Response $response, array $args): Response
    {
        $userId = (int) $args['id'];
        $user = $this->userModel->findById($userId);
        
        if (!$user) {
            throw new HttpNotFoundException($request, 'User not found');
        }
        
        return $this->render($response, 'user/show.php', ['user' => $user]);
    }
}
```
