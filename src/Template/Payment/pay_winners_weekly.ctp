

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
 </table>   
 </body> 
 </html>
   
 
