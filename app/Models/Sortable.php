<?php

namespace Medlib\Models;

/**
 * Trait Sortable
 * @package Medlib
 */
trait Sortable
{
    /**
     * @param $query
     * @param null $sort string property to sort on
     * @param null $direction string sort direction
     * @return mixed
     */
    public function scopeSortable($query, $sort = null, $direction = null)
    {
        if ($sort && $direction) {
            return $query->orderBy($sort, $direction);
        }
        return $query;
    }
}