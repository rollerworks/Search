<?php

/**
 * This file is part of the RollerworksSearch Component package.
 *
 * (c) 2012-2014 Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\Search\Doctrine\Dbal;

/**
 * SqlFieldConversionInterface provides a field conversion for the SQL generating process.
 *
 * The $hints parameter always receives the following information.
 *
 * * search_field: Rollerworks\Component\Search\FieldConfigInterface
 * * connection: Doctrine\DBAL\Connection
 * * db_type: Doctrine\DBAL\Types\Type
 *
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
interface SqlFieldConversionInterface
{
    /**
     * Should return the $field wrapped inside an SQL statement
     * like: MY_FUNCTION(column)
     *
     * Caution: The result of this method is used as-is, so its important
     * to properly escape any values used in the returned statement.
     *
     * @param string $column  Resolved Query column
     * @param array  $options Options of the Field configuration
     * @param array  $hints   Special information for the conversion process (search_field, connection, db_type)
     *
     * @return string
     */
    public function convertSqlField($column, array $options, array $hints);
}