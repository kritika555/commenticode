
<div class="card padding-new" style="min-height: 550px;">
<table border="1" align="center">
    <tr >
    <th colspan="3"><h1>Feedback Details</h1></th>
    </tr>
    <tr>      
        <th>ID</th>
        <th>Message</th>
        <th>Created By</th>
    </tr>
    <tr>
        <td><?= h($feedback->message)  ?></td>
        
        <td>
            <?= $feedback->user_id ?>
        </td>
    </tr>
     <tr>
        <td colspan="3" align="center"> <?= $this->Html->link('Back', ['controller' => 'Feedback','action' => 'index']) ?></td>       
    </tr>
</table>
</div>