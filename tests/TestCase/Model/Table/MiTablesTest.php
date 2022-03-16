<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MiTables;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MiTables Test Case
 */
class MiTablesTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MiTables
     */
    public $MiTables;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Mis') ? [] : ['className' => 'App\Model\Table\MiTables'];
        $this->MiTables = TableRegistry::get('Mis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MiTables);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
