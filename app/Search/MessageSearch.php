<?php

namespace App\Search;

use App\Message;

class MessageSearch extends Searchable
{
    protected static $allowedFilters = ['Series', 'Author', 'Speaker', 'HasMedia', 'SortByDate'];

    public static function returnModelInstance()
    {
        return (new Message)->newQuery();
    }
}
