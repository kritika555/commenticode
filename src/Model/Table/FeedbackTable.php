<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class FeedbackTable extends Table {
    public function initialize(array $config) {
        $this->table('feedback'); //define table name
        $this->displayField('message'); // unique or other special field of users table
        $this->primaryKey('id'); // primary key of users table
      //  $this->tablePrefix('prefix_'); // if prefix set tablename should be prefix_users
       
    }    
}
?>