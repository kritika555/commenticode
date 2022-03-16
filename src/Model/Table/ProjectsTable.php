<?php
namespace App\Model\Table;

use App\Model\Entity\Project;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Projects Model
 *
 * @property \Cake\ORM\Association\HasMany $Applications
 * @property \Cake\ORM\Association\HasMany $Buyers
 */
class ProjectsTable extends Table
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

        $this->table('projects');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Backlogs',[
        'foreignKey' => 'backlog_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('ProjectComments',[
            'foreignKey' => 'project_id',
            //'joinType' => 'INNER'
        ]);

        $this->hasMany('ProjectVotes',[
            'foreignKey' => 'project_id',
            //'joinType' => 'INNER'
        ]);

        $this->belongsTo('Users',[
            'propertyName' => 'created_by',
            'foreignKey' => 'created_by_id',
            'joinType' => 'INNER'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator->add('name', [
            'unique' => [
                'rule' => ['validateUnique'],
                'provider' => 'table',
                'message' => 'Title already in use.'
            ]
        ]);

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');


        return $validator;
    }

}
