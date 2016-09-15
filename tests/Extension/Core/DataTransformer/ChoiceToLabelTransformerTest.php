<?php

/*
 * This file is part of the RollerworksSearch package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\Search\Tests\Extension\Core\DataTransformer;

use Rollerworks\Component\Search\Extension\Core\DataTransformer\ChoiceToLabelTransformer;

final class ChoiceToLabelTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_transformers_label_to_choice()
    {
        $choices = $this->prophesize('Rollerworks\Component\Search\Extension\Core\ChoiceList\ChoiceListInterface');
        $choices->getLabelForChoice('active')->willReturn('1');
        $choices->getLabelForChoice('removed')->willReturn('2');

        $transformer = new ChoiceToLabelTransformer($choices->reveal());

        $this->assertEquals('1', $transformer->transform('active'));
        $this->assertEquals('2', $transformer->transform('removed'));
    }

    /**
     * @test
     */
    public function it_reverse_transformers_choice_to_label()
    {
        $choices = $this->prophesize('Rollerworks\Component\Search\Extension\Core\ChoiceList\ChoiceListInterface');
        $choices->getChoiceForLabel('1')->willReturn('active');
        $choices->getChoiceForLabel('2')->willReturn('removed');

        $transformer = new ChoiceToLabelTransformer($choices->reveal());

        $this->assertEquals('active', $transformer->reverseTransform('1'));
        $this->assertEquals('removed', $transformer->reverseTransform('2'));
    }
}