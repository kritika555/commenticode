<?php
namespace App\Model\Table;

use App\Model\Entity\Project;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectComments Model
 *
 * @property \Cake\ORM\Association\HasMany $Applications
 * @property \Cake\ORM\Association\HasMany $Buyers
 */
class ProjectCommentsTable extends Table
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

        $this->table('project_comments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects',[
        'foreignKey' => 'project_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Users');
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
            ->requirePresence('comment', 'create')
            ->notEmpty('comment');

        return $validator;
    }

}
