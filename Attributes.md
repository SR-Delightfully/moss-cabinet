# Slim Framework Starter Template

A lightweight MVC web application starter template built on top of the Slim PHP microframework. Ideal for projects that require Slim's simplicity without sacrificing the benefits of a clean MVC architecture.

## Why Using this Template?

This template provides a starting point for building web applications with the Slim 4 framework using the classic MVC (Model–View–Controller) pattern. It includes everything you need to get started, without the extra complexity of larger frameworks.

## What's Included

This starter template follows best practices and adheres to industry standards:

- **Slim 4**: The "slim" PHP microframework
- **Routing**: Slim's custom routing based on [FastRoute](https://github.com/nikic/FastRoute)
- **Dependency injection container** (PSR-11)
- **HTTP message interfaces** (PSR-7)
- **HTTP Server Request Handlers**, Middleware (PSR-15)
- **Autoloader** (PSR-4)
- **Logger** (PSR-3)
- **Code styles** (PSR-12)
- **Composer** - Dependency management

## Requirements

- PHP 8.2 or higher
- Composer (for dependency management)
- A web server (Apache, Nginx)

## How Do I Use/Deploy this Template?

Follow the instructions below in the specified order:

1. Download this repository as `.zip` file.
2. Extract the downloaded `slim-mvc-main.zip` file locally.
3. Copy the `slim-mvc-main` folder into your Web server's **document root** (that is, `htdocs`)
4. Rename the `slim-mvc-main` folder to, for example, `[project_name]-app`. For example, `worldcup-app`
5. Open your `[project_name]-app` folder in VS Code
6. If you are using Wampoon, open a terminal window in VS Code (hit ``` Ctrl+` ```) and select `Command Prompt` dropdown menu in the upper-right corner. Then run `"../../composer.bat" update` (**NOTE**:  double quotes are required) command to install or update the required dependencies. 
   - If you are not using Wampoon to develop your app, just run composer from the command line.
7. In the `config` folder, make a copy of `env.example.php` and rename it to `env.php`.
8. Adjust your database credentials (**see below**).

**```NOTE:```** You can always clone this repository. However, if you do, you need to remove the ```.git``` ***hidden*** directory before you copy this template over to ```htdocs```

## How Do I Configure My Database Connection?

Follow the outlined instructions in [config/env.example.php](config/env.example.php)

* Change the value of the `database` variable to reflect the name of the database to be used by your slim app.
* You may also want to change the connection credentials in that file.

## On Using Environment Variables

Sensitive information used in app such as your database credentials, API key, etc. MUST not be pushed into your Git repo.

Do not use `.env` files for storing environment specific application settings/configurations. Dotenv [is not meant to be used in production](https://github.com/vlucas/phpdotenv/issues/76#issuecomment-87252126)

Just Google: "DB_PASSWORD" filetype:env
Alternatively, you can visit the following link: [Google env search](https://www.google.ch/search?q=%22DB_PASSWORD%22+filetype:env)

Instead, follow the instructions that are detailed in [config/env.example.php](config/env.example.php)

## Installation

1. **Clone this repository** or download this repository.
   ```bash
   git clone https://github.com/frostybee/slim-mvc.git your-project-name
   cd your-project-name
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```
   
   Or if you don't have Composer globally installed, use the included `composer.bat` (you might need to adjust the PHP path):
   ```bash
   composer.bat install
   ```

## Project Structure

Here's how everything is organized:

```plaintext
slim-mvc/
├── app/
│   ├── Controllers/    # Your controllers live here
│   ├── Domain/         # Domain logic and business rules
│   ├── Helpers/        # Utility classes and helpers
│   ├── Middleware/     # Custom middleware
│   ├── Models/         # Data models and entities
│   ├── Routes/         # Route definitions (web & API)
│   ├── Utils/          # General utility functions
│   └── Views/          # Your view templates
├── config/             # Configuration files and bootstrap
├── data/               # Database files, uploads, etc.
├── docs/               # Documentation
├── public/             # Web-accessible files
│   ├── assets/         # Static assets (CSS, JS, images)
│   │   ├── css/        # Stylesheets
│   │   └── js/         # JavaScript files
│   ├── index.php       # Application entry point
│   └── .htaccess       # Apache rewrite rules
├── var/                # Runtime files
│   └── logs/           # Application logs
└── vendor/             # Composer dependencies
```

## Quick Development Tips

### Adding Routes

Routes are defined in the `app/Routes/` directory. Check out the existing route files to see how it's done.

### Creating Controllers

Controllers go in `app/Controllers/`. They should extend the base controller class and follow PSR-4 autoloading.

### Views and Templates

Templates are stored in `app/Views/`. The template engine is already configured and ready to use.

### Configuration

App configuration lives in `config/`. Modify these files to customize your application settings.

### Logging

Logs are written to the `var/logs/` directory. Use the injected logger in your controllers to track what's happening.

## Need Help?

- Check out the [Slim documentation](https://www.slimframework.com/docs/v4/) for framework-specific questions.
- Look at the example controllers and routes to see how everything fits together.
- The code is pretty well commented, so don't hesitate to explore it well.

## Contributing

Got ideas for improvements? Found a bug? Pull requests are welcome!

- [Issues](https://github.com/frostybee/slim-mvc/issues)

## Acknowledgments

The application's bootstrap process and structure of this starter template is based on [slim4-skeleton](https://github.com/odan/slim4-skeleton) by [@odan](https://github.com/odan).  Many thanks to the original developers for their work!

## License

This project is open-sourced under the MIT License. See the `LICENSE` file for the full details.

---
