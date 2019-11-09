<?php

namespace App\Search;

use App\Article;

class ArticleSearch extends Searchable
{
    protected static $allowedFilters = ['Series', 'Author'];
    protected static $defaultFilters = ["Published" => true];

    public static function returnModelInstance()
    {
        return (new Article)->newQuery();
    }
}