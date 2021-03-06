<?php
/**
 * Copyright 2013-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category   Horde
 * @copyright  2013 Horde LLC
 * @license    http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package    Pack
 * @subpackage UnitTests
 */

/**
 * Test for the base Horde_Pack object.
 *
 * @author     Michael Slusarz <slusarz@horde.org>
 * @category   Horde
 * @copyright  2013 Horde LLC
 * @ignore
 * @license    http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package    Pack
 * @subpackage UnitTests
 */
class Horde_Pack_PackTest extends Horde_Test_Case
{
    /**
     * @expectedException LogicException
     */
    public function testExpectedExceptionOnSerialize()
    {
        $pack = new Horde_Pack();
        serialize($pack);
    }

    /**
     * @dataProvider buggyDriverBackendsProvider
     */
    public function testBuggyDriverBackends($data)
    {
        $pack = new Horde_Pack();

        $p = $pack->pack($data, array(
            'drivers' => array(
                'Horde_Pack_Driver_Json',
                'Horde_Pack_Driver_Serialize'
            )
        ));

        $this->assertEquals(
            $data,
            $pack->unpack($p)
        );
    }

    public function buggyDriverBackendsProvider()
    {
        return array(
            // Bug #13275
            // ISO-8859-1 string
            array(base64_decode('VORzdA==')),
            // JSON-C does not correctly handle null characters
            array(array("A\0B" => "A\0B"))
        );
    }

}
