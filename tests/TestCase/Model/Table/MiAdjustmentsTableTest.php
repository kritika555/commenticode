<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MiAdjustmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MiAdjustmentsTable Test Case
 */
class MiAdjustmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MiAdjustmentsTable
     */
    public $MiAdjustments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mi_adjustments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MiAdjustments') ? [] : ['className' => 'App\Model\Table\MiAdjustmentsTable'];
        $this->MiAdjustments = TableRegistry::get('MiAdjustments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MiAdjustments);

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
}
