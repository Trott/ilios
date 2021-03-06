<?php

namespace App\Tests\DataFixtures\ORM;

use App\Entity\MeshDescriptorInterface;

/**
 * Class LoadMeshDescriptorDataTest
 */
class LoadMeshDescriptorDataTest extends AbstractDataFixtureTest
{
    /**
     * {@inheritdoc}
     */
    public function getEntityManagerServiceKey()
    {
        return 'App\Entity\Manager\MeshDescriptorManager';
    }

    /**
     * {@inheritdoc}
     */
    public function getFixtures()
    {
        return [
          'App\DataFixtures\ORM\LoadMeshDescriptorData',
        ];
    }

    /**
     * @covers \App\DataFixtures\ORM\LoadMeshDescriptorData::load
     * @group mesh_data_import
     */
    public function testLoad()
    {
        $this->runTestLoad('mesh_descriptor.csv', 10);
    }

    /**
     * @param array $data
     * @param MeshDescriptorInterface $entity
     */
    protected function assertDataEquals(array $data, $entity)
    {
        // `mesh_descriptor_uid`,`name`,`annotation`,`created_at`,`updated_at`
        $this->assertEquals($data[0], $entity->getId());
        $this->assertEquals($data[1], $entity->getName());
        $this->assertEquals($data[2], $entity->getAnnotation());
        $this->assertEquals(new \DateTime($data[3], new \DateTimeZone('UTC')), $entity->getCreatedAt());
        $this->assertEquals(new \DateTime($data[4], new \DateTimeZone('UTC')), $entity->getUpdatedAt());
        $this->assertEquals((boolean) $data[5], $entity->isDeleted());
    }
}
