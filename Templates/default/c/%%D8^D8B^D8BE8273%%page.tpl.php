<?php /* Smarty version 2.6.26, created on 2010-01-23 22:30:11
         compiled from page.tpl */ ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "include/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<div class="corps">
			<h1><?php echo $this->_tpl_vars['pageHead']; ?>
</h1>
				<?php if ($this->_tpl_vars['filArianeActive'] == true): ?>
				<hr />
					<em>Navigation : </em>
					<?php $_from = $this->_tpl_vars['filAriane']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['filArianeLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['filArianeLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['fil_name'] => $this->_tpl_vars['fil_url']):
        $this->_foreach['filArianeLoop']['iteration']++;
?>
						<?php if (($this->_foreach['filArianeLoop']['iteration'] <= 1)): ?>
							<strong>[</strong>
						<?php else: ?>
							<strong>-></strong>
						<?php endif; ?>
						<a href="<?php echo $this->_tpl_vars['fil_url']; ?>
" title="<?php echo $this->_tpl_vars['fil_name']; ?>
"><?php echo $this->_tpl_vars['fil_name']; ?>
</a>
						
						<?php if (($this->_foreach['filArianeLoop']['iteration'] == $this->_foreach['filArianeLoop']['total'])): ?>
							<strong>]</strong>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				<hr />
				<?php endif; ?>
			
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['pageName'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "include/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>