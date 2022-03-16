<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReTaxesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReTaxesTable Test Case
 */
class ReTaxesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ReTaxesTable
     */
    public $ReTaxes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.re_taxes',
        'app.states'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ReTaxes') ? [] : ['className' => 'App\Model\Table\ReTaxesTable'];
        $this->ReTaxes = TableRegistry::get('ReTaxes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ReTaxes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
