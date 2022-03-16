<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BuyerIncomesFixture
 *
 */
class BuyerIncomesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'buyer_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'application_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'job_no' => ['type' => 'integer', 'length' => 2, 'unsigned' => true, 'null' => false, 'default' => '1', 'comment' => '1->Primary Job Income, 0->Secondary Job Income', 'precision' => null, 'autoIncrement' => null],
        'annual_base_income' => ['type' => 'decimal', 'length' => 15, 'precision' => 4, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => ''],
        'have_ot_bonus_commissions' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'ot_bonus_commissions' => ['type' => 'decimal', 'length' => 15, 'precision' => 4, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => ''],
        'have_alimony' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'alimony_per_year' => ['type' => 'decimal', 'length' => 15, 'precision' => 4, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => ''],
        'alimony_for_3_year' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'have_other_income' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'other_income_detail' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'other_annual_income' => ['type' => 'decimal', 'length' => 15, 'precision' => 4, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => ''],
        'rental_income_departure_residence' => ['type' => 'decimal', 'length' => 15, 'precision' => 4, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => 'Net Rental Income of Departure Residence'],
        'total_annual_income' => ['type' => 'decimal', 'length' => 15, 'precision' => 4, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'updated' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'buyer_id' => 1,
            'application_id' => 1,
            'job_no' => 1,
            'annual_base_income' => 1.5,
            'have_ot_bonus_commissions' => 1,
            'ot_bonus_commissions' => 1.5,
            'have_alimony' => 1,
            'alimony_per_year' => 1.5,
            'alimony_for_3_year' => 1,
            'have_other_income' => 1,
            'other_income_detail' => 'Lorem ipsum dolor sit amet',
            'other_annual_income' => 1.5,
            'rental_income_departure_residence' => 1.5,
            'total_annual_income' => 1.5,
            'created' => '2016-05-06 10:18:28',
            'updated' => '2016-05-06 10:18:28'
        ],
    ];
}
