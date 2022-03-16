<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Configurations Controller
 *
 * @property \App\Model\Table\ConfigurationsTable $Configurations
 */
class ConfigurationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $conditions = [];
        if(isset($this->request->query['title']) && $this->request->query['title'] !=''){
            $conditions['OR']['Configurations.title LIKE'] = '%'.$this->request->query['title'].'%';
            $conditions['OR']['Configurations.conf_key LIKE'] = '%'.$this->request->query['title'].'%';
            $conditions['OR']['Configurations.conf_value LIKE'] = '%'.$this->request->query['title'].'%';
        }
        $query = $this->Configurations->find('all')->where($conditions);
        $this->setDefaultOrdering($query,$this->Configurations->alias());
        $configurations = $this->paginate($query);
        $this->set(compact('configurations'));
        $this->set('_serialize', ['configurations']);
    }



    /**
     * addEdit method
     *
     * @param string|null $id Configuration id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function addEdit($id = null)
    {
        if($id != null){
            $configuration = $this->Configurations->get($id, [
                'contain' => []
            ]);
            $action = 'Edit';


            if ($this->request->is(['patch', 'post', 'put'])) {
                $this->request->data['title'] = trim($this->request->data['title']);               ;
                $configuration = $this->Configurations->patchEntity($configuration, $this->request->data);
                if ($this->Configurations->save($configuration)) {
                    $this->Flash->success(__('The configuration has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The configuration could not be saved. Please, try again.'));
                }
            }
            $this->set(compact('configuration','action','id'));
            $this->set('_serialize', ['configuration']);
        }else{
            $this->Flash->success(__('Invalid request.'));
            return $this->redirect(['action' => 'index']);
        }

    }


}
