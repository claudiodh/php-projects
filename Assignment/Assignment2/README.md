# Assignment 2

## Setup

Ensure you create the database schema with the `database/schema.sql` file. The credentials for the database can be added within the Repository.php file.

## Set up autoloading:

```
composer install
```

## Running the application

You can run the application using the built-in PHP web server.

For example:

```
php -S localhost:7777 -t public/
```

### Install Node dependencies:

```
npm i
```

### Compile and hot-reload CSS assets

```
npm run dev
```
The COMP3015 Assignment 2 project is a PHP-based web application that allows users to create, edit, and delete articles. It follows an MVC (Model-View-Controller) architecture to separate concerns and ensure clean code structure.

Tech Stack & Frameworks Used
	•	PHP 8.4 (Core Language)
	•	DaisyUI & Tailwind CSS (Frontend Styling)
	•	MySQL (Database)
	•	PDO (PHP Data Objects) (Database Interaction)
	•	PHP Built-in Web Server (php -S localhost:8001)

Main Components
	1.	Controllers (Handles requests & business logic)
	•	ArticleController.php → Manages article operations (CRUD)
	•	LoginController.php → Handles user authentication
	•	SettingsController.php → Manages user profile updates
	2.	Repositories (Handles database operations)
	•	ArticleRepository.php → Fetches & updates article data
	•	UserRepository.php → Manages user-related queries
	3.	Views (Frontend templates)
	•	index.view.php → Displays article list dynamically
	•	new_article.view.php → Form for posting a new article
	•	update_article.view.php → Editing an existing article
	•	settings.view.php → User profile management

Core Logic
	•	Authentication: Users login via LoginController, and session management ensures access control.
	•	Article Management: Articles are stored in MySQL, with ArticleController handling creation, updating, and deletion.
	•	Routing: The app routes requests via Router.php, mapping URLs to controllers.
	•	Dynamic Rendering: index.view.php loads articles dynamically from ArticleRepository.php, ensuring up-to-date content.

This structure allows a scalable and secure article posting system.
