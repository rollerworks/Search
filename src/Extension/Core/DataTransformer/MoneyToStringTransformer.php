<?php

declare(strict_types=1);

/*
 * This file is part of the RollerworksSearch package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\Search\Extension\Core\DataTransformer;

use Rollerworks\Component\Search\Exception\TransformationFailedException;
use Rollerworks\Component\Search\Extension\Core\Model\MoneyValue;

/**
 * Transforms between a normalized format and a money string.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 * @author Florian Eckerstorfer <florian@eckerstorfer.org>
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
class MoneyToStringTransformer extends NumberToStringTransformer
{
    private $divisor;
    private $defaultCurrency;

    /**
     * @param int    $scale
     * @param int    $roundingMode
     * @param int    $divisor
     * @param string $defaultCurrency
     */
    public function __construct(int $scale = null, int $roundingMode = null, int $divisor = null, string $defaultCurrency = null)
    {
        parent::__construct($scale ?? 2, $roundingMode, \NumberFormatter::TYPE_CURRENCY);

        $this->divisor = $divisor ?? 1;
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * Transforms a normalized format into a localized money string.
     *
     * @param MoneyValue $value Normalized number
     *
     * @throws TransformationFailedException If the given value is not numeric or
     *                                       if the value can not be transformed
     *
     * @return string Normalized money string
     */
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        if (!$value instanceof MoneyValue) {
            throw new TransformationFailedException('Expected a MoneyValue object.');
        }

        $amountValue = $value->value;
        $amountValue /= $this->divisor;
        $amountValue = parent::transform($amountValue);

        return $value->currency.' '.$amountValue;
    }

    /**
     * Transforms a localized money string into a normalized format.
     *
     * @param string $value Localized money string
     *
     * @throws TransformationFailedException If the given value is not a string
     *                                       or if the value can not be transformed
     *
     * @return MoneyValue Normalized number
     */
    public function reverseTransform($value, &$currency = null)
    {
        if (!is_string($value)) {
            throw new TransformationFailedException('Expected a string value.');
        }

        $value = parent::reverseTransform($value, $currency);

        if (null !== $value) {
            $value *= $this->divisor;
        }

        if (false === $currency) {
            $currency = $this->defaultCurrency;
        }

        return new MoneyValue($currency, (string) $value);
    }
}
