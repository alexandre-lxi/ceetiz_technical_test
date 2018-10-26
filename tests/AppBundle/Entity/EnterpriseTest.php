<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 26/10/18
 * Time: 13:10
 */

namespace AppBundle\Entity;

use PHPUnit\Framework\TestCase;

class EnterpriseTest extends TestCase
{
    public function testcreateEnterprise(){
        $juridicForm = new JuridicForm();
        $juridicForm
            ->setName('SAS')
            ->setTax(33)
            ->setAddressMandatory(true);

        $address = new Address();
        $address->setAddress1('test1');

        $enterprise = new Enterprise();
        $enterprise
            ->setDenomination('SAS')
            ->setJuridicForm($juridicForm)
            ->setAddress($address);

        //Test de la création réussi
        $control = $enterprise->enterpriseControlData();
        $this->assertTrue($control['result']);

    }

    public function testcreateEnterpriseKO(){
        $juridicForm = new JuridicForm();
        $juridicForm
            ->setName('SAS')
            ->setTax(33)
            ->setAddressMandatory(true);

        $address = new Address();
        $address->setAddress1('test1');

        $enterprise1 = new Enterprise();
        $enterprise1
            ->setDenomination('SAS')
            ->setAddress($address);

        $control = $enterprise1->enterpriseControlData();
        $this->assertFalse($control['result']);


        $enterprise2 = new Enterprise();
        $enterprise2
            ->setDenomination('SAS')
            ->setJuridicForm($juridicForm);

        $control = $enterprise2->enterpriseControlData();
        $this->assertFalse($control['result']);
    }

    public function testcalcTaxAutoentreprise(){
        $juridicForm = new JuridicForm();
        $juridicForm
            ->setName('auto-entreprises')
            ->setTax(25);
        $enterprise = new Enterprise();
        $enterprise
            ->setDenomination('auto-entreprises')
            ->setJuridicForm($juridicForm);

        $turnover = 185233;

        $this->assertSame($turnover*.25, $enterprise->calculationTax($turnover));
    }

    public function testcalcTaxSAS(){
        $juridicForm = new JuridicForm();
        $juridicForm
            ->setName('SAS')
            ->setTax(33);
        $enterprise = new Enterprise();
        $enterprise
            ->setDenomination('SAS')
            ->setJuridicForm($juridicForm);

        $turnover = 185233;

        $this->assertSame($turnover*.33, $enterprise->calculationTax($turnover));
    }

    public function testSirenKO(){
        $this->expectException('LogicException');
        $enterprise = new Enterprise();
        $enterprise
            ->setSiret('12345678');
    }

    public function testSiren(){
        $enterprise = new Enterprise();
        $siren = '123456789';
        $nic = '00014';
        $siret = $siren.$nic;

        $enterprise
            ->setSiret($siret);

        $this->assertSame($siren, $enterprise->getSiren());
        $this->assertSame($siret, $enterprise->getSiret());
        $this->assertSame($nic, $enterprise->getNic());
    }
}