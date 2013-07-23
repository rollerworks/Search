<?php

/*
 * This file is part of the RollerworksRecordFilterBundle package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rollerworks\Bundle\RecordFilterBundle\Tests\Doctrine\Orm;

use Rollerworks\Bundle\RecordFilterBundle\Doctrine\Orm\WhereBuilder;
use Rollerworks\Bundle\RecordFilterBundle\Metadata\Loader\AnnotationDriver;
use Metadata\MetadataFactory;

class WhereBuilderTest extends OrmTestCase
{
    public function testEntityManager()
    {
        $formatter = $this->getMock('Rollerworks\Bundle\RecordFilterBundle\Formatter\FormatterInterface');
        $formatter->expects($this->atLeastOnce())->method('getFilters')->will($this->returnValue(array()));

        $container       = $this->createContainer();
        $metadataFactory = new MetadataFactory(new AnnotationDriver($this->newAnnotationsReader()));
        $whereBuilder    = new WhereBuilder($metadataFactory, $container);

        $whereBuilder->setEntityManager($this->em);
        $this->assertSame($this->em, $whereBuilder->getEntityManager());

        $this->cleanSql($whereBuilder->getWhereClause($formatter, array('Rollerworks\Bundle\RecordFilterBundle\Tests\Fixtures\BaseBundle\Entity\ECommerce\ECommerceInvoice' => 'I')));
    }
}