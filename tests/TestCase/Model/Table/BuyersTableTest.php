<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BuyersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BuyersTable Test Case
 */
class BuyersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BuyersTable
     */
    public $Buyers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.buyers',
        'app.users',
        'app.applications',
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
        'app.properties',
        'app.refinance_details',
        'app.refinance_loan_qual_tool',
        'app.buyer_addresses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Buyers') ? [] : ['className' => 'App\Model\Table\BuyersTable'];
        $this->Buyers = TableRegistry::get('Buyers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Buyers);

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
