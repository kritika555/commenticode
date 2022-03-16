<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Applications
 * @property \Cake\ORM\Association\HasMany $Buyers
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Applications', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Buyers', [
            'foreignKey' => 'user_id'
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
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator->add('username', [
            'unique' => [
                'rule' => ['validateUnique'],
                'provider' => 'table',
                'message' => 'Username already in use.'
            ]
        ]);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator->add('email', [
            'unique' => [
                'rule' => ['validateUnique'],
                'provider' => 'table',
                'message' => 'Email already in use.'
            ]
        ]);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator->add('password', [
            'minLength' => [
                'rule' => ['minLength', 8],
                'message' => 'Password should have minimum 8 characters.'
            ],
            'passLength' => [
                'rule' => function ($value) {
                        return (preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/', $value)=== 1);
                    },
                'message' => 'Password should have at least 1 alphabet, 1 number and 1 special character.'
            ]
        ]);

        $validator->add('ethereum_public_address', [
            'unique' => [
                'rule' => ['validateUnique'],
                'provider' => 'table',
                'message' => 'Ethereum address already in use.'
            ]
        ]);

//        $validator->requirePresence('confirm_password', 'create');
//
//        $validator->add('confirm_password', [
//            'passEqual'=> [
//                'rule' => function ($value, $context) {
//                        return  (isset($context['data']['password']) && ($context['data']['password'] === $value));
//                    },
//                'message' => 'Confirm password should match with new password.'
//            ]
//        ]);


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

    /**
     * Reset Password validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationEditProfile(Validator $validator)
    {
        $validator = $this->validationDefault($validator);
        $validator->remove('current_password');
        $validator->remove('password');
        $validator->remove('confirm_password');
        return $validator;
    }


}
