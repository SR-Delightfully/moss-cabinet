# BaseController Usage Guide

This guide demonstrates how to use the BaseController class methods in your Slim MVC application controllers.

## Overview

The `BaseController` class provides foundational functionality for all controllers in the application. It handles dependency injection, view rendering, and HTTP redirects with a focus on educational clarity and simplicity.

## Class Structure

```php
<?php

namespace App\Controllers;

use App\Helpers\Core\AppSettings;
use Slim\Views\PhpRenderer;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class BaseController
{
    protected PhpRenderer $view;
    protected AppSettings $settings;
    protected Container $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->settings = $container->get(AppSettings::class);
        $this->view = $container->get(PhpRenderer::class);
    }
    
    // Methods...
}
```

## Creating a Controller

Extend BaseController to create your own controllers:

```php
<?php

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }
    
    // Your controller methods here...
}
```

## Available Methods

### render() - Render View Templates

The `render()` method processes view templates and returns HTTP responses with proper headers.

**Method Signature:**
```php
protected function render(Response $response, string $view_name, array $data = []): Response
```

**Parameters:**
- `$response` - PSR-7 response object to modify
- `$view_name` - Name of the view template file
- `$data` - Associative array of data to pass to the template

**Examples:**

#### Basic View Rendering
```php
public function index(Request $request, Response $response, array $args): Response
{
    return $this->render($response, 'home/index.php');
}
```

#### Passing Data to Views
```php
public function show(Request $request, Response $response, array $args): Response
{
    $userId = (int) $args['id'];
    
    $data = [
        'user' => [
            'id' => $userId,
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ],
        'title' => 'User Profile'
    ];
    
    return $this->render($response, 'user/profile.php', $data);
}
```

#### Complex Data Structures
```php
public function dashboard(Request $request, Response $response, array $args): Response
{
    $data = [
        'page_title' => 'Dashboard',
        'user' => [
            'name' => 'Jane Smith',
            'role' => 'Administrator'
        ],
        'stats' => [
            'total_users' => 1250,
            'active_sessions' => 89,
            'recent_logins' => 45
        ],
        'notifications' => [
            ['message' => 'System update completed', 'type' => 'success'],
            ['message' => 'New user registered', 'type' => 'info']
        ]
    ];
    
    return $this->render($response, 'dashboard/index.php', $data);
}
```

#### Conditional Rendering
```php
public function profile(Request $request, Response $response, array $args): Response
{
    $user = $this->getCurrentUser(); // Assume this method exists
    
    if (!$user) {
        return $this->render($response, 'errors/unauthorized.php', [
            'message' => 'Please log in to view your profile'
        ]);
    }
    
    $data = [
        'user' => $user,
        'title' => 'My Profile'
    ];
    
    return $this->render($response, 'user/profile.php', $data);
}
```

### redirect() - HTTP Redirects

The `redirect()` method creates HTTP redirect responses to named routes with support for parameters and query strings.

**Method Signature:**
```php
protected function redirect(
    Request $request, 
    Response $response, 
    string $route_name, 
    array $uri_args = [], 
    array $query_params = []
): Response
```

**Parameters:**
- `$request` - PSR-7 request object for route context
- `$response` - PSR-7 response object to modify
- `$route_name` - Named route to redirect to (e.g., 'user.profile', 'articles.index')
- `$uri_args` - Associative array for route placeholders (e.g., ['id' => 123] for /users/{id})
- `$query_params` - Query string parameters

**Important:** Understanding `$uri_args` vs `$query_params`

- **`$uri_args`** - Replaces route placeholders like `{id}` in route patterns (e.g., `/users/{id}` becomes `/users/123`)
- **`$query_params`** - Adds query string parameters to any URL (e.g., `?tab=settings&page=2`)
- **Only use `$uri_args`** when your target route has `{placeholders}` - otherwise use empty array `[]`

**Examples:**

#### Basic Redirect (No Parameters)
```php
public function logout(Request $request, Response $response, array $args): Response
{
    // Clear session data
    session_destroy();
    
    // Redirect to home page (no parameters needed)
    return $this->redirect($request, $response, 'home.index');
}
```

#### Redirect with Route Parameters
```php
// For route: /users/{id}
public function updateProfile(Request $request, Response $response, array $args): Response
{
    $userId = (int) $args['id'];
    
    // Process form data
    $this->updateUserData($userId, $request->getParsedBody());
    
    // Redirect to user profile with ID parameter (replaces {id} placeholder)
    return $this->redirect($request, $response, 'user.profile', ['id' => $userId]);
}
```

#### Redirect with Query Parameters Only
```php
// For route: /search (no placeholders)
public function search(Request $request, Response $response, array $args): Response
{
    $searchTerm = $request->getQueryParams()['q'] ?? '';
    $category = $request->getQueryParams()['category'] ?? 'all';
    
    if (empty($searchTerm)) {
        // Redirect back to search form (use flash messages for errors instead)
        return $this->redirect($request, $response, 'search.index');
    }
    
    // Redirect to results with search parameters
    return $this->redirect($request, $response, 'search.results', [], [
        'q' => $searchTerm,
        'category' => $category,
        'page' => 1
    ]);
}
```

#### Redirect with Both Route Parameters and Query Strings
```php
// For route: /users/{id}/edit
public function editUser(Request $request, Response $response, array $args): Response
{
    $userId = (int) $args['id'];
    $currentTab = $request->getQueryParams()['tab'] ?? 'general';
    
    // Validate user exists
    if (!$this->userExists($userId)) {
        // Redirect to user list (use flash messages for errors instead)
        return $this->redirect($request, $response, 'user.list');
    }
    
    // Process form submission
    if ($request->getMethod() === 'POST') {
        $this->updateUser($userId, $request->getParsedBody());
        
        // Redirect back to same tab: ['id' => $userId] replaces {id}, query params add ?tab=...
        return $this->redirect($request, $response, 'user.edit', ['id' => $userId], [
            'tab' => $currentTab
        ]);
    }
    
    // Show edit form
    return $this->render($response, 'user/edit.php', [
        'user' => $this->getUser($userId),
        'active_tab' => $currentTab
    ]);
}
```

#### Post-Redirect-Get Pattern
```php
public function createUser(Request $request, Response $response, array $args): Response
{
    if ($request->getMethod() === 'POST') {
        $userData = $request->getParsedBody();
        
        try {
            // Create user
            $userId = $this->userService->create($userData);
            
            // Redirect to prevent form resubmission (PRG pattern)
            // Use flash messages for success notifications
            return $this->redirect($request, $response, 'user.profile', ['id' => $userId]);
            
        } catch (ValidationException $e) {
            // Redirect back to form (use flash messages for errors)
            return $this->redirect($request, $response, 'user.create');
        }
    }
    
    // Show create form
    return $this->render($response, 'user/create.php');
}
```

## Complete Controller Examples

### Simple CRUD Controller
```php
<?php

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ArticleController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }
    
    // List all articles
    public function index(Request $request, Response $response, array $args): Response
    {
        $articles = $this->getArticles(); // Assume this method exists
        
        return $this->render($response, 'articles/index.php', [
            'title' => 'All Articles',
            'articles' => $articles
        ]);
    }
    
    // Show single article
    public function show(Request $request, Response $response, array $args): Response
    {
        $articleId = (int) $args['id'];
        $article = $this->getArticle($articleId);
        
        if (!$article) {
            // Use flash messages for errors instead
            return $this->redirect($request, $response, 'articles.index');
        }
        
        return $this->render($response, 'articles/show.php', [
            'title' => $article['title'],
            'article' => $article
        ]);
    }
    
    // Create new article
    public function create(Request $request, Response $response, array $args): Response
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $articleId = $this->createArticle($data);
            
            return $this->redirect($request, $response, 'articles.show', ['id' => $articleId]);
        }
        
        return $this->render($response, 'articles/create.php', [
            'title' => 'Create Article'
        ]);
    }
    
    // Update existing article
    public function update(Request $request, Response $response, array $args): Response
    {
        $articleId = (int) $args['id'];
        
        if ($request->getMethod() === 'POST') {
            $this->updateArticle($articleId, $request->getParsedBody());
            
            // Use flash messages for success notifications
            return $this->redirect($request, $response, 'articles.show', ['id' => $articleId]);
        }
        
        $article = $this->getArticle($articleId);
        
        return $this->render($response, 'articles/edit.php', [
            'title' => 'Edit Article',
            'article' => $article
        ]);
    }
    
    // Delete article
    public function delete(Request $request, Response $response, array $args): Response
    {
        $articleId = (int) $args['id'];
        $this->deleteArticle($articleId);
        
        // Use flash messages for success notifications
        return $this->redirect($request, $response, 'articles.index');
    }
}
```

## Best Practices

### 1. Data Validation
Always validate data before passing to views:

```php
public function userProfile(Request $request, Response $response, array $args): Response
{
    $userId = filter_var($args['id'], FILTER_VALIDATE_INT);
    
    if (!$userId) {
        // Use flash messages for errors instead
        return $this->redirect($request, $response, 'user.list');
    }
    
    // Continue with valid ID...
}
```

### 2. Error Handling
Handle errors gracefully with appropriate redirects:

```php
public function processForm(Request $request, Response $response, array $args): Response
{
    try {
        $this->processUserData($request->getParsedBody());
        return $this->redirect($request, $response, 'success.page');
        
    } catch (ValidationException $e) {
        // Use flash messages for errors instead
        return $this->redirect($request, $response, 'form.page');
    }
}
```

### 3. Consistent Naming
Use descriptive view names that match your controller actions:

```php
// Good - clear mapping
return $this->render($response, 'user/profile.php', $data);
return $this->render($response, 'articles/edit.php', $data);

// Avoid - unclear purpose
return $this->render($response, 'page1.php', $data);
```

### 4. Data Structure
Organize view data logically:

```php
$data = [
    'meta' => [
        'title' => 'Page Title',
        'description' => 'Page description'
    ],
    'user' => $currentUser,
    'content' => $pageContent,
    'sidebar' => $sidebarData
];
```

## Route Integration

Register your controllers in the route files (`app/Routes/web-routes.php`):

```php
use App\Controllers\UserController;
use App\Controllers\ArticleController;

return static function (Slim\App $app): void {
    // User routes
    $app->get('/users', [UserController::class, 'index'])->setName('user.list');
    $app->get('/users/{id}', [UserController::class, 'show'])->setName('user.profile');
    $app->get('/users/{id}/edit', [UserController::class, 'edit'])->setName('user.edit');
    $app->post('/users/{id}', [UserController::class, 'update']);
    
    // Article routes
    $app->get('/articles', [ArticleController::class, 'index'])->setName('articles.index');
    $app->get('/articles/{id}', [ArticleController::class, 'show'])->setName('articles.show');
};
```
