<?php

require_once 'Book.php';

class BookRepository
{
    private string $filename;

    /**
     * @param string $theFilename
     */
    public function __construct(string $theFilename)
    {
        $this->filename = $theFilename;
    }

    /**
     * @return array of Book objects
     */
    public function getAllBooks(): array
    {
        // If the file doesn't exist, we have no books to read!
        if (!file_exists($this->filename)) {
            return [];
        }

        // If we get a falsy value back from file_get_contents, we won't have anything to parse to JSON
        $fileContents = file_get_contents($this->filename);
        if (!$fileContents) {
            return [];
        }

        // The string happens to be in JSON format, so pass it to json_decode
        // The 2nd parameter requests an associative array return value
        $decodedBooks = json_decode($fileContents, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return []; // A JSON error occurred in our parsing attempt -- return empty to the caller
        }

        // Create an empty list and fill the Book objects with the JSON
        $books = [];
        foreach ($decodedBooks as $bookData) {
            $books[] = (new Book())->fill($bookData);
        }

        // Return the array of Books back to the caller
        return $books;
    }

    /**
     * @param Book $book
     */

    /**
     * Saves a valid Book (all fields must be non-empty).
     */
    public function saveBook(Book $book): void
    {
        // Check if this book has all required fields
        if (
            empty($book->getName()) ||
            empty($book->getAuthor()) ||
            empty($book->getInternationalStandardBookNumber())
        ) {
            // If any field is missing, do NOT save
            return;
        }

        // Add to existing collection
        $books = $this->getAllBooks();
        $books[] = $book;
        // Save everything back to disk
        $this->saveAllBooks($books);
    }

    /**
     * Retrieves the book with the given ISBN, or null if no book with the specified ISBN is found.
     * Note: for the purposes of this lab you may return the first occurrence if there are multiple books with the same ISBN in the file.
     *
     * @param string $isbn
     * @return Book|null
     */
    public function getBookByISBN(string $isbn): ?Book
{
    // Get all existing books
    $books = $this->getAllBooks();

    // Search for the book with the specified ISBN
    foreach ($books as $book) {
        if ($book->getInternationalStandardBookNumber() === $isbn) {
            return $book;
        }
    }
    // Return null if no book with the specified ISBN is found
    return null;
}

    /**
     * Retrieves the book with the given title, or null if no book of that title is found.
     * Note: for the purposes of this lab you may return the first occurrence if there are multiple books of the same title.
     *
     * @param string $title
     * @return Book|null
     */
   public function getBookByTitle(string $title): ?Book
{
    // Get all existing books
    $books = $this->getAllBooks();

    // Search for the book with the specified title
    foreach ($books as $book) {
        if ($book->getName() === $title) {
            return $book;
        }
    }

    // Return null if no book with the specified title is found
    return null;
}

    /**
     * Updates the book in the file with the given $isbn (the contents of that book is replaced by $newBook in the file)
     * Hint: are you seeing the file have indexes added to the JSON? Look into https://www.php.net/manual/en/function.array-values.php
     * @param string $isbn
     * @param Book $newBook
     */
    public function updateBook(string $isbn, Book $newBook): void
    {
        $books = $this->getAllBooks();
        foreach ($books as &$book) {
            if ($book->getInternationalStandardBookNumber() === $isbn) {
                // Only update if the newBook is valid
                if (
                    !empty($newBook->getName()) &&
                    !empty($newBook->getAuthor()) &&
                    !empty($newBook->getInternationalStandardBookNumber())
                ) {
                    $book = $newBook;
                }
                break;
            }
        }
        $this->saveAllBooks($books);
    }
    /**
     * Deletes the book in the file with the given $isbn.
     * Seeing indexes be added to the JSON? Look into https://www.php.net/manual/en/function.array-values.php
     * @param string $isbn
     */
    public function deleteBookByISBN(string $isbn): void
    {
        $books = $this->getAllBooks();

        $filtered = array_filter($books, function (Book $book) use ($isbn) {
            return $book->getInternationalStandardBookNumber() !== $isbn;
        });

        // Re-index to avoid numeric keys in JSON
        $filtered = array_values($filtered);

        $this->saveAllBooks($filtered);
    }


    /**
     * Private helper to write the entire list of Books to the JSON file.
     */
    private function saveAllBooks(array $books): void
    {
        $data = array_map(function (Book $b) {
            return $b->jsonSerialize();
        }, $books);

        file_put_contents($this->filename, json_encode($data, JSON_PRETTY_PRINT));
    }
}
