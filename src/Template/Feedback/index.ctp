<!DOCTYPE html>
<html>
<head>
</head>
<body>
<table border="1" align="center">
    <tr >
    <th colspan="4"><h1>Blog Articles</h1></br>
    
    <p><?= $this->Html->link("Add New Article", ['controller'=>'Articles','action' => 'add']) ?></p></br></br>
    <span style="color:red"><?= $this->Flash->render('flash') ?></span></br>
    </th>
    </tr>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Created</th>
        <th>Action</th>
    </tr>
    
    <!-- Here is where we iterate through our $articles query object, printing out article info -->
    <?php foreach ($articles as $article): ?>
    <tr>
        <td><?= $article->id ?></td>
        <td>
            <?= $this->Html->link($article->title, ['controller' => 'Articles','action' => 'view', $article->id]) ?>
        </td>
        <td>
            <?= $article->created->format(DATE_RFC850) ?>
        </td>
         <td>
           
           <?= $this->Html->link('Edit', ['action' => 'edit', $article->id]) ?>
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $article->id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
add.ctp

Location:  "src/Template/Articles/add.ctp"

<h1>Add Article</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->input('title');
    echo $this->Form->input('body', ['rows' => '4']);
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>
 

view.ctp
Location:  "src/Template/Articles/view.ctp"

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<table border="1" align="center">
    <tr >
    <th colspan="3"><h1>Blog Articles Details</h1></th>
    </tr>
    <tr>      
        <th>Title</th>
        <th>Body</th>
        <th>Created</th>
    </tr>
    <tr>
        <td><?= h($article->title)  ?></td>
        <td>
            <?= h($article->body) ?>
        </td>
        <td>
            <?= $article->created->format(DATE_RFC850) ?>
        </td>
    </tr>
     <tr>
        <td colspan="3" align="center"> <?= $this->Html->link('Back', ['controller' => 'Articles','action' => 'index']) ?></td>       
    </tr>
</table>
</body>