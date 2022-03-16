<?php
namespace App\Controller\Component;
require_once(ROOT . DS . 'src' . DS . "vendor". DS . "autoload.php");
use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;


//https://github.com/KnpLabs/php-github-api/blob/master/doc/repo/contents.md
class GitComponent extends Component
{
    public $components = ['Workflow', 'Auth'];
    private $client;
    private $owner;

    /**
     * Initialize and authenticate the Git Client object
     */
    private function init(){
        $this->client =  new \Github\Client();
        $token = '6a029e9a0032a7c2bb2a47888127b8b9be019ba9';

        $this->owner = "commenticode";
        //$token = 'ad4c32f2e50acd9799e46d4608c8d126365aca0f';
        //$this->owner = "Githubprojectapp";
        $this->client->authenticate($this->owner, $token, \Github\Client::AUTH_HTTP_PASSWORD);
    }

    /**
     * Create Github Repo
     * @param $name
     * @param $desc
     * @return mixed
     */
    function createRepo($name, $desc){
        $this->init();
        $desc = trim(preg_replace('/\s\s+/', ' ', $desc));//Remove enter from the string.

        $repo = $this->client->api('repo')->create(
            $name,
            $desc,
            null, true
        );
        return $repo;
    }

    /**
     * Delete Github repo
     * @param $repoName
     * @return mixed
     */
    function deleteRepo($repoName){
        $this->init();
        $token = $this->client->api('repo')->remove(
            $this->owner,
            $repoName
        ); // Get the deletion token
        return $token;
    }

    /**
     * Upload file to github
     * @param $repo
     * @param $file
     * @param array $committer
     * @return mixed
     */
    function uploadFile($repo, $file, $oldFile=''){
        $this->init();
        if(empty($committer)){
            $committer = array('name' => $this->Auth->user('username'), 'email' => $this->Auth->user('email'));
        }
        $content = file_get_contents($file['tmp_name']);
        $commitMessage = 'Auto Committed';
        $branch='master';

        if($oldFile == ''){
            //Create file
            $fileInfo = $this->client->api('repo')->contents()->create(
                $this->owner,
                $repo,
                $file['name'],
                $content,
                $commitMessage,
                $branch,
                $committer
            );
        }else{
            //Update file
            $fileInfo = $this->client->api('repo')->contents()->update(
                $this->owner,
                $repo,
                $file['name'],
                $content,
                $commitMessage,
                $oldFile['content']->sha,
                $branch,
                $committer
            );
        }

        return $fileInfo;
    }


}