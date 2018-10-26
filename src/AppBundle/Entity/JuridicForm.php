<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JuridicForm
 *
 * @ORM\Table(name="juridic_form")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JuridicFormRepository")
 */
class JuridicForm
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=15, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="tax", type="integer")
     */
    private $tax;

    /**
     * @ORM\OneToMany(targetEntity="Enterprise", mappedBy="juridicForm")
     */
    private $enterprises;

    /**
     * @var boolean
     *
     * @ORM\Column(name="address_mandatory", type="boolean")
     */
    private $addressMandatory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enterprises = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return JuridicForm
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set taux
     *
     * @param integer $tax
     *
     * @return JuridicForm
     */
    public function setTax($tax)
    {
        if ($tax < 0){
            throw new \LogicException('Tax cannot be negative');
        }

        $this->tax = $tax;

        return $this;
    }

    /**
     * Get taux
     *
     * @return int
     */
    public function getTax()
    {
        return $this->tax;
    }


    /**
     * Add entreprise
     *
     * @param \AppBundle\Entity\Enterprise $enterprise
     *
     * @return JuridicForm
     */
    public function addEnterprise(\AppBundle\Entity\Enterprise $enterprise)
    {
        $this->enterprises[] = $enterprise;

        return $this;
    }

    /**
     * Remove enterprise
     *
     * @param \AppBundle\Entity\Enterprise $enterprise
     */
    public function removeEntreprise(\AppBundle\Entity\Enterprise $enterprise)
    {
        $this->enterprises->removeElement($enterprise);
    }

    /**
     * Get enterprises
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnterprises()
    {
        return $this->enterprises;
    }

    /**
     * Remove enterprise
     *
     * @param \AppBundle\Entity\Enterprise $enterprise
     */
    public function removeEnterprise(\AppBundle\Entity\Enterprise $enterprise)
    {
        $this->enterprises->removeElement($enterprise);
    }

    /**
     * Set addressMandatory
     *
     * @param boolean $addressMandatory
     *
     * @return JuridicForm
     */
    public function setAddressMandatory($addressMandatory)
    {
        $this->addressMandatory = $addressMandatory;

        return $this;
    }

    /**
     * Get addressMandatory
     *
     * @return boolean
     */
    public function getAddressMandatory()
    {
        return $this->addressMandatory;
    }


}
