<?php /* Smarty version 2.6.26, created on 2014-08-13 20:40:36
         compiled from manage/_intervalData.html */ ?>
<?php $_from = $this->_tpl_vars['suspect_records']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
<?php if ($this->_tpl_vars['k']%2 == 0): ?>
<tr class='even'>
    <?php else: ?>
<tr class='odd'>
    <?php endif; ?>
    <td><?php echo $this->_tpl_vars['v']['phone_number']; ?>
</td>
    <td><?php echo $this->_tpl_vars['v']['start_time']; ?>
</td>
    <td><?php echo $this->_tpl_vars['v']['end_time']; ?>
</td>
    <td><?php echo $this->_tpl_vars['v']['call_times']; ?>
</td>
    <td id="numstate-<?php echo $this->_tpl_vars['v']['stream_number']; ?>
"><?php echo $this->_tpl_vars['v']['num_state']; ?>
</td>
    <td id="illegalType-<?php echo $this->_tpl_vars['v']['stream_number']; ?>
"><?php echo $this->_tpl_vars['v']['illegal_type']; ?>
</td>
    <td>
        <a class="opt-edit opt" href="javascript:auditionRecord('<?php echo $this->_tpl_vars['v']['stream_number']; ?>
')" title="编辑">试听</a>
    </td>
    <td id="notesFor-<?php echo $this->_tpl_vars['v']['stream_number']; ?>
"><?php echo $this->_tpl_vars['v']['susdesc']; ?>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>