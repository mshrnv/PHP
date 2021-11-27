<?php

// Написать класс Library, который представляет собой хранилище объектов класса Book

// Класс Library должен содержать:

//     Конструктор __construct();
//     Методы addBook($book), deleteBook($title), добавляющие/удаляющие книгу в библиотеку;
//     Метод getBook($title), возвращающий объект - книгу, если она найдена,
//         и false в противном случае;
//     Свойство $__books - массив книг;

// Класс Book должен содержать:

//     Конструктор __construct($author, $title, $year);
//     Методы getAuthor(), getTitle(), getYear(), добавляющие/удаляющие книгу в библиотеку;
//     Методы setAuthor($author), setTitle($title), setYear($year)
//     Свойства $__author, $__title, $__year;

// К свойствам можно обращаться только через методы

class Book
{
    private $__author, $__title, $__year;

    function __construct($author, $title, $year)
    {
        $this -> __author = $author;
        $this -> __title  = $title;
        $this -> __year   = $year;
    }

    function getAuthor()
    {
        return $this -> __author;
    }

    function getTitle()
    {
        return $this -> __title;
    }

    function getYear()
    {
        return $this -> __year;
    }

    function setAuthor($author)
    {
        $this -> __author = $author;
    }

    function setTitle($title)
    {
        $this -> __title = $title;
    }

    function setYear($year)
    {
        $this -> __year = $year;
    }
}

class Library
{
    private $__books;

    function __construct($books = array())
    {
        $this -> __books = $books;
    }

    function addBook($book)
    {
        $this -> __books[] = $book;
    }

    function deleteBook($title)
    {
        foreach ($this -> __books as $key => $book) {
            if ($book -> getTitle() == $title) {
                $index = $key;
            }
        }

        unset($this -> __books[$index]);
    }

    function getBook($title)
    {
        foreach ($this -> __books as $book) {
            if ($book -> getTitle() == $title) {
                return $book;
            }
        }

        return false;
    }
}