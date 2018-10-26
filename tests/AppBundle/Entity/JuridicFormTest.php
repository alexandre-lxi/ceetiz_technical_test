<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 26/10/18
 * Time: 13:26
 */

namespace AppBundle\Entity;

use PHPUnit\Framework\TestCase;

class JuridicFormTest extends TestCase
{
    public function testNegativeTax()
    {
        $this->expectException('LogicException');
        $juridicForm = new JuridicForm();
        $juridicForm->setTax(-30);
    }
}