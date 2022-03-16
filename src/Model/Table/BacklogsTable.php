<?php
namespace App\Model\Table;

use App\Model\Entity\Repo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Backlogs Model
 *
 * @property \Cake\ORM\Association\HasMany $Applications
 * @property \Cake\ORM\Association\HasMany $Buyers
 */
class BacklogsTable extends Table
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

        $this->table('backlogs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Projects', [
            'foreignKey' => 'backlog_id'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'created_by_id',
            'propertyName' => 'created_by'
        ]);
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

//        $validator
//            ->requirePresence('start_date', 'create')
//            ->notEmpty('start_date');
//
//        $validator
//            ->requirePresence('end_date', 'create')
//            ->notEmpty('end_date');
//
//        $validator
//            ->requirePresence('vote_start_date', 'create')
//            ->notEmpty('vote_start_date');
//
//        $validator
//            ->requirePresence('vote_end_date', 'create')
//            ->notEmpty('vote_end_date');

        $validator->add('title', [
            'unique' => [
                'rule' => ['validateUnique'],
                'provider' => 'table',
                'message' => 'Title already in use.'
            ]
        ]);
		$validator->add('repository_name', [
            'unique' => [
                'rule' => ['validateUnique'],
                'provider' => 'table',
                'message' => 'Repository name already in use.'
            ]
        ]);

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }

    /**
     * Change Password validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationChangePass(Validator $validator)
    {
        $validator = $this->validationDefault($validator);
        $validator->remove('email');
        $validator->remove('confirm_email');

        $validator
            ->requirePresence('current_password')
            ->notEmpty('current_password');

        $validator->add('current_password', 'custom', [
            'rule' =>  function ($value, $context){
                    $query = $this->find('all', [
                        'conditions' => [
                            'id'=>$context['data']['id'],
                            'password'=>md5($value),
                        ]
                    ]);
                    return $query->count() ? true : false;
                },
            'message' => 'Incorrect current password.'
        ]);

        return $validator;
    }

    /**
     * Change Password validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationResetPass(Validator $validator)
    {
        $validator = $this->validationDefault($validator);
        $validator->remove('email');
        $validator->remove('confirm_email');
        return $validator;
    }
}
