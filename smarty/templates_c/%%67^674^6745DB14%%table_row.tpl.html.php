<?php /* Smarty version 2.6.28, created on 2016-06-23 12:28:08
         compiled from table_row.tpl.html */ ?>
          <tr>
              <td><?php echo $this->_tpl_vars['ad']->getId(); ?>
</td>
              <td><?php echo $this->_tpl_vars['ad']->getTitle(); ?>
</td>
              <td><?php echo $this->_tpl_vars['ad']->getDesc(); ?>
</td>
              <td><?php echo $this->_tpl_vars['ad']->getPrice(); ?>
</td>
              <td>
              
              <a data-toggle="tooltip" title="Редактировать объявление" href=./<?php echo $this->_tpl_vars['current_php_script']; ?>
?edit=1&id=<?php echo $this->_tpl_vars['ad']->getId(); ?>
><span class='glyphicon glyphicon-edit'></span></a>
              
              <a class="delete " data-toggle="tooltip" title="Удалить объявление" 
                                   ><span class='btn glyphicon glyphicon-remove-circle'></span></a>
              
              
              </td>
          </tr>