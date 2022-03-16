<?php
namespace App\Model\Table;

use App\Model\Entity\Configuration;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Configurations Model
 *
 */
class ConfigurationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('configurations');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('conf_value', 'create')
            ->notEmpty('conf_value');

        /*$validator->add('conf_key', [
            'unique' => [
                'rule' => ['validateUnique'],
                'provider' => 'table',
                'message' => 'Key already in use.'
            ],
            'alphanumeric' => [
                'rule' => function ($value) {
                        return (preg_match('/^[a-zA-Z0-9_]*$/', $value)=== 1);
                    },
                'message' => 'Only characters, numbers and underscore are allowed'
            ]
        ]);*/
        ///^[a-zA-Z ]*$/
        return $validator;
    }
}
