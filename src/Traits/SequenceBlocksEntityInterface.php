<?php

namespace App\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Entity\CurriculumInventorySequenceBlockInterface;

/**
 * Interface SequenceBlocksEntityInterface
 */
interface SequenceBlocksEntityInterface
{
    /**
     * @param Collection $sequenceBlocks
     */
    public function setSequenceBlocks(Collection $sequenceBlocks);

    /**
     * @param CurriculumInventorySequenceBlockInterface $sequenceBlock
     */
    public function addSequenceBlock(
        CurriculumInventorySequenceBlockInterface $sequenceBlock
    );

    /**
     * @param CurriculumInventorySequenceBlockInterface $sequenceBlock
     */
    public function removeSequenceBlock(
        CurriculumInventorySequenceBlockInterface $sequenceBlock
    );

    /**
    * @return CurriculumInventorySequenceBlockInterface[]|ArrayCollection
    */
    public function getSequenceBlocks();
}
