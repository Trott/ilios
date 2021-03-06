<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\IlmSessionsEntity;
use App\Traits\InstructorGroupsEntity;
use App\Traits\InstructorsEntity;
use App\Traits\UsersEntity;
use App\Annotation as IS;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use App\Traits\IdentifiableEntity;
use App\Traits\TitledEntity;
use App\Traits\StringableIdEntity;
use App\Traits\OfferingsEntity;

/**
 * Class LearnerGroup
 *
 * @ORM\Table(name="`group`")
 * @ORM\Entity(repositoryClass="App\Entity\Repository\LearnerGroupRepository")
 *
 * @IS\Entity
 */
class LearnerGroup implements LearnerGroupInterface
{
    use IdentifiableEntity;
    use TitledEntity;
    use StringableIdEntity;
    use OfferingsEntity;
    use UsersEntity;
    use InstructorsEntity;
    use InstructorGroupsEntity;
    use IlmSessionsEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Assert\Type(type="integer")
     *
     * @IS\Expose
     * @IS\Type("integer")
     * @IS\ReadOnly
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 1,
     *      max = 60
     * )
     *
     * @IS\Expose
     * @IS\Type("string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=100, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 1,
     *      max = 100
     * )
     *
     * @IS\Expose
     * @IS\Type("string")
     */
    protected $location;

    /**
     * @var CohortInterface
     * @Assert\NotNull()
     *
     * @ORM\ManyToOne(targetEntity="Cohort", inversedBy="learnerGroups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cohort_id", referencedColumnName="cohort_id", onDelete="CASCADE", nullable=false)
     * })
     *
     * @IS\Expose
     * @IS\Type("entity")
     */
    protected $cohort;

    /**
     * @var LearnerGroupInterface
     *
     * @ORM\ManyToOne(targetEntity="LearnerGroup", inversedBy="children")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_group_id", referencedColumnName="group_id", onDelete="CASCADE")
     * })
     *
     * @IS\Expose
     * @IS\Type("entity")
     */
    protected $parent;

    /**
     * @var LearnerGroupInterface
     *
     * @ORM\ManyToOne(targetEntity="LearnerGroup", inversedBy="descendants")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ancestor_id", referencedColumnName="group_id")
     * })
     *
     * @IS\Expose
     * @IS\Type("entity")
     */
    protected $ancestor;

    /**
     * @var LearnerGroupInterface[]
     *
     * @ORM\OneToMany(targetEntity="LearnerGroup", mappedBy="ancestor")
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @IS\Expose
     * @IS\Type("entityCollection")
     */
    protected $descendants;

    /**
     * @var ArrayCollection|LearnerGroupInterface[]
     *
     * @ORM\OneToMany(targetEntity="LearnerGroup", mappedBy="parent")
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @IS\Expose
     * @IS\Type("entityCollection")
     */
    protected $children;

    /**
     * @var ArrayCollection|IlmSessionInterface[]
     *
     * @ORM\ManyToMany(targetEntity="IlmSession", mappedBy="learnerGroups")
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @IS\Expose
     * @IS\Type("entityCollection")
     */
    protected $ilmSessions;

    /**
     * @var ArrayCollection|OfferingInterface[]
     *
     * @ORM\ManyToMany(targetEntity="Offering", mappedBy="learnerGroups")
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @IS\Expose
     * @IS\Type("entityCollection")
     */
    protected $offerings;

    /**
     * @var ArrayCollection|InstructorGroupInterface[]
     *
     * @ORM\ManyToMany(targetEntity="InstructorGroup", inversedBy="learnerGroups")
     * @ORM\JoinTable(name="group_x_instructor_group",
     *   joinColumns={
     *     @ORM\JoinColumn(name="group_id", referencedColumnName="group_id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="instructor_group_id", referencedColumnName="instructor_group_id", onDelete="CASCADE")
     *   }
     * )
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @IS\Expose
     * @IS\Type("entityCollection")
     */
    protected $instructorGroups;

    /**
     * @var ArrayCollection|UserInterface[]
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="learnerGroups")
     * @ORM\JoinTable(name="group_x_user",
     *   joinColumns={
     *     @ORM\JoinColumn(name="group_id", referencedColumnName="group_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     *   }
     * )
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @IS\Expose
     * @IS\Type("entityCollection")
     */
    protected $users;

    /**
     * @var UserInterface
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="instructedLearnerGroups")
     * @ORM\JoinTable(name="group_x_instructor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="group_id", referencedColumnName="group_id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="user_id", onDelete="CASCADE")
     *   }
     * )
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @IS\Expose
     * @IS\Type("entityCollection")
     */
    protected $instructors;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users            = new ArrayCollection();
        $this->ilmSessions      = new ArrayCollection();
        $this->offerings        = new ArrayCollection();
        $this->children         = new ArrayCollection();
        $this->instructorGroups = new ArrayCollection();
        $this->instructors      = new ArrayCollection();
        $this->descendants      = new ArrayCollection();
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param CohortInterface $cohort
     */
    public function setCohort(CohortInterface $cohort)
    {
        $this->cohort = $cohort;
    }

    /**
     * @return CohortInterface
     */
    public function getCohort()
    {
        return $this->cohort;
    }

    /**
     * @param IlmSessionInterface $ilmSession
     */
    public function addIlmSession(IlmSessionInterface $ilmSession)
    {
        if (!$this->ilmSessions->contains($ilmSession)) {
            $this->ilmSessions->add($ilmSession);
            $ilmSession->addLearnerGroup($this);
        }
    }

    /**
     * @param IlmSessionInterface $ilmSession
     */
    public function removeIlmSession(IlmSessionInterface $ilmSession)
    {
        if ($this->ilmSessions->contains($ilmSession)) {
            $this->ilmSessions->removeElement($ilmSession);
            $ilmSession->removeLearnerGroup($this);
        }
    }

    /**
     * @param LearnerGroupInterface $parent
     */
    public function setParent(LearnerGroupInterface $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * @return LearnerGroupInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param LearnerGroupInterface $ancestor
     */
    public function setAncestor(LearnerGroupInterface $ancestor = null)
    {
        $this->ancestor = $ancestor;
    }

    /**
     * @return LearnerGroupInterface
     */
    public function getAncestor()
    {
        return $this->ancestor;
    }

    /**
     * If the objective has no ancestor then we need to objective itself
     *
     * @return LearnerGroupInterface
     */
    public function getAncestorOrSelf()
    {
        $ancestor = $this->getAncestor();

        return $ancestor?$ancestor:$this;
    }

    /**
     * @param Collection $descendants
     */
    public function setDescendants(Collection $descendants)
    {
        $this->descendants = new ArrayCollection();

        foreach ($descendants as $descendant) {
            $this->addDescendant($descendant);
        }
    }

    /**
     * @param LearnerGroupInterface $descendant
     */
    public function addDescendant(LearnerGroupInterface $descendant)
    {
        if (!$this->descendants->contains($descendant)) {
            $this->descendants->add($descendant);
            $descendant->setAncestor($this);
        }
    }

    /**
     * @param LearnerGroupInterface $descendant
     */
    public function removeDescendant(LearnerGroupInterface $descendant)
    {
        $this->descendants->removeElement($descendant);
    }

    /**
     * @return ArrayCollection|LearnerGroupInterface[]
     */
    public function getDescendants()
    {
        return $this->descendants;
    }

    /**
     * @param Collection $children
     */
    public function setChildren(Collection $children = null)
    {
        $this->children = new ArrayCollection();
        if (is_null($children)) {
            return;
        }

        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

    /**
     * @param LearnerGroupInterface $child
     */
    public function addChild(LearnerGroupInterface $child)
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
        }
    }

    /**
     * @param LearnerGroupInterface $child
     */
    public function removeChild(LearnerGroupInterface $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * @return ArrayCollection|LearnerGroupInterface[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @inheritdoc
     */
    public function addOffering(OfferingInterface $offering)
    {
        if (!$this->offerings->contains($offering)) {
            $this->offerings->add($offering);
            $offering->addLearnerGroup($this);
        }
    }

    /**
     * @inheritdoc
     */
    public function removeOffering(OfferingInterface $offering)
    {
        if ($this->offerings->contains($offering)) {
            $this->offerings->removeElement($offering);
            $offering->removeLearnerGroup($this);
        }
    }

    /**
     * @inheritdoc
     */
    public function getSchool()
    {
        if ($cohort = $this->getCohort()) {
            return $cohort->getSchool();
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getProgram()
    {
        if ($cohort = $this->getCohort()) {
            return $cohort = $cohort->getProgram();
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getProgramYear()
    {
        if ($cohort = $this->getCohort()) {
            return $cohort->getProgramYear();
        }
        return null;
    }
}
