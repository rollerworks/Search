<?php

/**
 * This file is part of the RollerworksSearch Component package.
 *
 * (c) 2012-2014 Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\Search;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
interface FieldTypeInterface
{
    /**
     * Returns the name of the type.
     *
     * @return string The type name.
     */
    public function getName();

    /**
     * Returns the name of the parent type.
     *
     * @return string|null The name of the parent type if any, null otherwise.
     */
    public function getParent();

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolverInterface $resolver The resolver for the options.
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver);

    /**
     * This configures the {@link FieldConfigInterface}.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the field.
     *
     * @param FieldConfigInterface $config
     * @param array                $options
     */
    public function buildType(FieldConfigInterface $config, array $options);

    /**
     * Configures the SearchFieldView instance.
     *
     * @param SearchFieldView      $view
     * @param FieldConfigInterface $config
     * @param array                $options
     */
    public function buildFieldView(SearchFieldView $view, FieldConfigInterface $config, array $options);

    /**
     * Returns whether ranges are supported by this type.
     *
     * @return boolean
     */
    public function hasRangeSupport();

    /**
     * Returns whether comparisons are supported by this type.
     *
     * @return boolean
     */
    public function hasCompareSupport();

    /**
     * Returns whether pattern-matchers are supported by this type.
     *
     * @return boolean
     */
    public function hasPatternMatchSupport();
}