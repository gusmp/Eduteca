<?php

namespace Eduteca\EdutecaBundle\Repository\impl;

use Doctrine\ORM\QueryBuilder;

class BaseRepository
{
    protected function addConstrain(QueryBuilder $qb, $value, $field, $placeHolder, $criteriaOption)
    {
        if (isset($value) == TRUE)
        {
            $qb->andWhere($field . ' ' . $criteriaOption . ' :' . $placeHolder);

            if ($criteriaOption == CriteriaOption::LIKE)
            {
                $qb->setParameter($placeHolder, '%'.$value.'%');
            }
            else
            {
                $qb->setParameter($placeHolder, $value);
            }
        }

        return $qb;
    }
}

class CriteriaOption
{
    const LIKE  = 'LIKE';
    const EQUAL = '=';
    const STRICT_LESS = '<';
    const STRICT_GREAT = '>';
    const LESS_OR_EQUAL = '<=';
    const GREAT_OR_EQUAL = '>=';
}

?>
