<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CountiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CountiesTable Test Case
 */
class CountiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CountiesTable
     */
    public $Counties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.counties',
        'app.states',
        'app.properties',
        'app.applications',
        'app.users',
        'app.buyers',
        'app.assets',
        'app.buyer_credit_histories',
        'app.buyer_documents',
        'app.buyer_employments',
        'app.buyer_incomes',
        'app.buyer_liabilities',
        'app.buyer_payments',
        'app.buying_close_cash',
        'app.buying_details',
        'app.buying_loan_qual_tool',
        'app.current_mortgages',
        'app.refinance_details',
        'app.refinance_loan_qual_tool',
        'app.re_taxes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Counties') ? [] : ['className' => 'App\Model\Table\CountiesTable'];
        $this->Counties = TableRegistry::get('Counties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Counties);

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
