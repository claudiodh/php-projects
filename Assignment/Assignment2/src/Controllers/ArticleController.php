<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\ArticleRepository;

class ArticleController extends Controller
{
    /**
     * Display a list of articles or a landing page.
     */
    public function index(Request $request): void
    {

        $articleRepo = new ArticleRepository();
        // $articles = $articleRepo->getArticles(/* optional filters */);

        $this->render('index', [
            // 'articles' => $articles
        ]);
    }

    /**
     * Show the form for creating a new article.
     */
    public function create(Request $request): void
    {
        $this->startSession();

        // If user is not logged in, redirect to login
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
            return;
        }

        // Render the "new_article" form (already exists in your project)
        $this->render('new_article');
    }

    /**
     * Process the storing of a new article.
     */
    public function store(Request $request): void
    {
        $this->startSession();

        if ($request->method() !== 'POST') {
            $this->redirect('/articles/create');
            return;
        }

        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
            return;
        }

        // Grab form data
        $title = trim($request->input('title') ?? '');
        $url   = trim($request->input('url') ?? '');

        // Basic validation
        if (empty($title) || empty($url)) {
            $_SESSION['flash'] = "The title and URL are required.";
            $this->redirect('/articles/create');
            return;
        }

        // Use ArticleRepository to save the article
        $articleRepo = new ArticleRepository();
        $authorId = (int) $_SESSION['user_id'];

        $newArticle = $articleRepo->saveArticle($title, $url, $authorId);

        if (!$newArticle) {
            $_SESSION['flash'] = "Could not create the article. Please try again.";
            $this->redirect('/articles/create');
            return;
        }

        $_SESSION['flash'] = "Article successfully posted!";
        $this->redirect('/');
    }

    /**
     * Show the form for editing an article.
     */
    public function edit(Request $request): void
    {
        $this->startSession();

        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
            return;
        }

        $articleId = (int) ($request->input('id') ?? 0);
        $articleRepo = new ArticleRepository();
        $article = $articleRepo->getArticleById($articleId);

        if (!$article) {
            $_SESSION['flash'] = "Article not found.";
            $this->redirect('/');
            return;
        }

        if ($article->getAuthorId() !== (int) $_SESSION['user_id']) {
            $_SESSION['flash'] = "Unauthorized access.";
            $this->redirect('/');
            return;
        }

        // Render the update form (update_article.view.php) with the current article values.
        $this->render('update_article', [
            'articleId'    => $article->getId(),
            'articleTitle' => $article->getTitle(),
            'articleUrl'   => $article->getUrl()
        ]);
    }


    /**
     * Process the editing of an article.
     */
    public function update(Request $request): void
    {
        $this->startSession();

        // Only allow POST requests
        if ($request->method() !== 'POST') {
            $this->redirect('/');
            return;
        }

        // Ensure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = "You must be logged in to update an article.";
            $this->redirect('/login');
            return;
        }

        // Retrieve data from POST
        $articleId = (int) ($request->input('id') ?? 0);
        $title = trim($request->input('title') ?? '');
        $url = trim($request->input('url') ?? '');

        // Basic validation for empty fields
        if ($articleId <= 0 || empty($title) || empty($url)) {
            $_SESSION['flash'] = "Invalid form data. Please change the title or URL.";
            $this->redirect("/articles/edit?id=" . $articleId);
            return;
        }

        // Validate URL: it must be a valid URL and begin with "https://"
        if (!filter_var($url, FILTER_VALIDATE_URL) || !preg_match('/^https:\/\//', $url)) {
            $_SESSION['flash'] = "Invalid URL: Please enter a valid and secure URL (must begin with https://).";
            $this->redirect("/articles/edit?id=" . $articleId);
            return;
        }

        // Fetch the existing article from the DB
        $articleRepo = new ArticleRepository();
        $article = $articleRepo->getArticleById($articleId);

        if (!$article) {
            $_SESSION['flash'] = "Article not found.";
            $this->redirect('/');
            return;
        }

        // Check if the current user is the author
        if ($article->getAuthorId() !== (int) $_SESSION['user_id']) {
            $_SESSION['flash'] = "Unauthorized access.";
            $this->redirect('/');
            return;
        }

        // Check if changes have been made; if not, prompt the user
        if ($title === $article->getTitle() && $url === $article->getUrl()) {
            $_SESSION['flash'] = "No changes detected. Please change the title or URL before updating.";
            $this->redirect("/articles/edit?id=" . $articleId);
            return;
        }

        // Attempt to update the article in the database
        if ($articleRepo->updateArticle($articleId, $title, $url)) {
            $_SESSION['flash'] = "Article updated successfully.";
        } else {
            $_SESSION['flash'] = "Could not update the article.";
        }

        // Redirect back to the homepage (or articles list) after updating
        $this->redirect('/');
    }

    /**
     * Process the deletion of an article.
     */
    public function delete(Request $request): void
    {
        $this->startSession();

        error_log("Delete request received with method: " . $_SERVER['REQUEST_METHOD']);

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = "You must be logged in to delete an article.";
            $this->redirect('/');
            return;
        }

        $articleId = (int) ($request->input('id') ?? 0);
        error_log("Article ID to delete: " . $articleId);

        if ($articleId <= 0) {
            $_SESSION['flash'] = "Invalid article ID.";
            $this->redirect('/');
            return;
        }

        $articleRepo = new ArticleRepository();
        $article = $articleRepo->getArticleById($articleId);

        if (!$article) {
            $_SESSION['flash'] = "Article not found.";
            $this->redirect('/');
            return;
        }

        // Ensure the logged-in user is the author (cast session user_id to int)
        if ($article->getAuthorId() !== (int)$_SESSION['user_id']) {
            $_SESSION['flash'] = "Unauthorized action.";
            $this->redirect('/');
            return;
        }

        // Additional verification: Check that the provided title matches the article's title
        $providedTitle = trim($request->input('title') ?? '');
        if ($article->getTitle() !== $providedTitle) {
            $_SESSION['flash'] = "Article title does not match.";
            $this->redirect('/');
            return;
        }

        if ($articleRepo->deleteArticleById($articleId)) {
            $_SESSION['flash'] = "Article deleted successfully.";
        } else {
            $_SESSION['flash'] = "Could not delete the article.";
        }

        header("Location: /");
        exit();
    }
}
