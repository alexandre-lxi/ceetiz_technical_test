<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enterprise
 *
 * @ORM\Table(name="enterprise")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnterpriseRepository")
 */
class Enterprise
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
     * @ORM\Column(name="siret", type="string", length=14, unique=true)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="denomination", type="string", length=100)
     */
    private $denomination;

    /**
     *
     * @ORM\ManyToOne(targetEntity="JuridicForm", inversedBy="enterprises")
     */
    private $juridicForm;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Address", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $address;

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
     * Set siret
     *
     * @param string $siret
     *
     * @return Enterprise
     */
    public function setSiret($siret)
    {
        if (strlen($siret) != 14){
            throw new \LogicException('SIREN must have 14 caracters');
        }

        $this->siret = $siret;

        return $this;

    }

    /**
     * Get siret
     *
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Get nic
     *
     * @return string
     */
    public function getNic()
    {
        return substr($this->siret,9);
    }

    /**
     * Get SIREN
     *
     * @return string
     */
    public function getSiren()
    {
        return substr($this->siret,0,9);
    }


    /**
     * Set denomination
     *
     * @param string $denomination
     *
     * @return Enterprise
     */
    public function setDenomination($denomination)
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * Get denomination
     *
     * @return string
     */
    public function getDenomination()
    {
        return $this->denomination;
    }

    /**
     * Set juridicForm
     *
     * @param \AppBundle\Entity\JuridicForm $juridicForm
     *
     * @return Enterprise
     */
    public function setJuridicForm(\AppBundle\Entity\JuridicForm $juridicForm = null)
    {
        $this->juridicForm = $juridicForm;
        $juridicForm->addEnterprise($this);

        return $this;
    }

    /**
     * Get juridicForm
     *
     * @return \AppBundle\Entity\JuridicForm
     */
    public function getJuridicForm()
    {
        return $this->juridicForm;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\Address $address
     *
     * @return Enterprise
     */
    public function setAddress(\AppBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }


    /**
     * Calculateur de taxe
     *
     * @param $turnover int
     * @return float
     */
    public function calculationTax($turnover){
        if ($this->getJuridicForm()->getTax() < 0) {
            throw new \LogicException('The TAX cannot be negative.');
        }

        return $turnover*$this->getJuridicForm()->getTax()/100;
    }

    /**
     * Methode de controle des données nécessaire au type d'entreprise.
     *
     * @return array
     */
    public function enterpriseControlData(){
        if ($this->getJuridicForm() === null){
            return array('result'=>false, 'message'=>'Forme juridique obligatoire');
        }

        if ($this->getJuridicForm()->getAddressMandatory() &&
            $this->getAddress() === null
                ){
            return array('result'=>false, 'message'=>'Addresse obligatoire pour les entreprises de type '.$this->getJuridicForm()->getName());
        }

        return array('result'=>true);
    }

}
