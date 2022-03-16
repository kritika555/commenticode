<?php
namespace App\Model\Table;

use App\Model\Entity\Admin;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\Rule\IsUnique;
use Cake\Validation\Validator;

/**
 * Videos Model
 *
 */
class AdminsTable extends Table
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

        $this->table('admins');
        $this->displayField('first_name');
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
            ->requirePresence('first_name')
            ->notEmpty('first_name');

        $validator
            ->requirePresence('last_name')
            ->notEmpty('last_name');

        $validator
            ->requirePresence('email')
            ->notEmpty('email');

        $validator
            ->requirePresence('email')
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => 'E-mail must be valid'
            ]);

        $validator
            ->requirePresence('password')
                ->notEmpty('password')
                ->requirePresence('confirm_password')
                ->notEmpty('confirm_password')
            ;

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

        $validator->add('confirm_password', [
            'passEqual'=> [
                'rule' => function ($value, $context) {
                        return  (isset($context['data']['password']) && ($context['data']['password'] === $value));
                    },
                'message' => 'Confirm password should match with new password.'
            ]
        ]);

        return $validator;
    }


    /**
     * Reset Password validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationResetPass(Validator $validator)
    {
        $validator = $this->validationDefault($validator);
        $validator->remove('current_password');
        $validator->remove('first_name');
        $validator->remove('last_name');
        $validator->remove('email');
        return $validator;
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
        $validator->remove('first_name');
        $validator->remove('last_name');
        $validator->remove('email');
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
