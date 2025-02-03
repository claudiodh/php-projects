<?php

/**
 * Fetch the top 3 articles from the article repository.
 * If there are less than 3 articles, return only available ones.
 *
 * @param ArticleRepository $articleRepository
 * @return Article[]
 */
function getTopArticles(ArticleRepository $articleRepository): array {
    $articles = $articleRepository->getAllArticles();
    usort($articles, fn($a, $b) => $b->getId() <=> $a->getId()); // Sort by newest first
    return array_slice($articles, 0, 3); // Return top 3 articles
}

/**
 * Fetch all articles except the top 3 for listing below the carousel.
 *
 * @param ArticleRepository $articleRepository
 * @return Article[]
 */
function getRemainingArticles(ArticleRepository $articleRepository): array {
    $articles = $articleRepository->getAllArticles();
    usort($articles, fn($a, $b) => $b->getId() <=> $a->getId()); // Sort by newest first
    return array_slice($articles, 3); // Return remaining articles
}

/**
 * Check if there are any articles available.
 *
 * @param ArticleRepository $articleRepository
 * @return bool
 */
function hasArticles(ArticleRepository $articleRepository): bool {
    return count($articleRepository->getAllArticles()) > 0;
}

/**
 * Validate if the given URL is properly formatted.
 *
 * @param string $url
 * @return bool
 */
function isValidUrl(string $url): bool {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

/**
 * Sanitize user input to prevent XSS attacks.
 *
 * @param string $input
 * @return string
 */
function sanitizeInput(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate the article input fields.
 *
 * @param string $title
 * @param string $url
 * @return string|null Returns an error message if invalid, otherwise null.
 */
function validateArticleInput(string $title, string $url): ?string {
    if (empty($title)) {
        return "Title cannot be empty.";
    }
    if (!isValidUrl($url)) {
        return "Invalid URL format.";
    }
    return null; // No errors
}