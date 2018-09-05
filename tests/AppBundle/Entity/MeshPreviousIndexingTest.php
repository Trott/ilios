<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\MeshPreviousIndexing;
use Mockery as m;

/**
 * Tests for Entity MeshPreviousIndexing
 */
class MeshPreviousIndexingTest extends EntityBase
{
    /**
     * @var MeshPreviousIndexing
     */
    protected $object;

    /**
     * Instantiate a MeshPreviousIndexing object
     */
    protected function setUp()
    {
        $this->object = new MeshPreviousIndexing;
    }

    public function testNotBlankValidation()
    {
        $notBlank = array(
            'previousIndexing'
        );
        $this->validateNotBlanks($notBlank);

        $this->object->setPreviousIndexing('a big load of 
                stuff in here up to 65 K characters 
                too much for me to imagine');
        $this->validate(0);
    }
    /**
     * @covers \AppBundle\Entity\MeshPreviousIndexing::setPreviousIndexing
     * @covers \AppBundle\Entity\MeshPreviousIndexing::getPreviousIndexing
     */
    public function testSetPreviousIndexing()
    {
        $this->basicSetTest('previousIndexing', 'string');
    }

    /**
     * @covers \AppBundle\Entity\MeshPreviousIndexing::getDescriptor
     * @covers \AppBundle\Entity\MeshPreviousIndexing::setDescriptor
     */
    public function testSetDescriptor()
    {
        $this->entitySetTest('descriptor', "MeshDescriptor");
    }
}