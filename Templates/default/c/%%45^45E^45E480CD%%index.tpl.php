<?php /* Smarty version 2.6.26, created on 2010-02-17 08:44:50
         compiled from index.tpl */ ?>

<h3><?php echo $this->_tpl_vars['site_short_name']; ?>
 - Installation réussie !</h3>
<p>
Simple Framework a été <span class="ok">correctement installé</span> !<br />
Vous pouvez maintenant :
<ul>
	<li><span class="ok">Modifier la configuration</span> située dans <em>Config/config.class.php</em></li>
	<li>... y modifier le design par défaut et <span class="ok">créer votre propre template</span>, dans <em>Template/NomDuTemplate</em> et <em>Template/css/NomDuTemplate</em></li>
	<li>Commencer à coder chaque page dans un environnement <span class="ok">sain et rapide</span> avec à votre disposition :
			<ul>
				<li><span class="ok">JQuery</span></li>
				<li>Le gestionnaire de templates <span class="ok">Smarty</span></li>
			</ul>
		</li>
</ul>
</p>
<div id="jquery-test-click">
    Cliquez ici pour tester JQuery ! <em>(vous devez voir l'image ci dessous apparaitre et disparaitre en fondu)</em>
	<noscript class="error">Vous devez activer javascript dans votre navigateur pour profiter de JQuery</noscript>
<br /><img id="jquery-test" src="http://www.jarodxxx.com/public/logos/jquery-logo.gif" alt="" height="64"/>
</div>

<h3>Changements</h3>
<p class="center"><a href="#" id="showChangelog">Afficher</a> - <a href="#" id="hideChangelog">Réduire</a></p>
<div id="changelog">
	<ul>
	<?php $_from = $this->_tpl_vars['changelog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['versionLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['versionLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['versionTxt'] => $this->_tpl_vars['version']):
        $this->_foreach['versionLoop']['iteration']++;
?>
			<li><strong><?php echo $this->_tpl_vars['versionTxt']; ?>
</strong>
				<ul id="detail_<?php echo $this->_foreach['versionLoop']['iteration']; ?>
">
				<?php $_from = $this->_tpl_vars['version']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['versionLoopSub'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['versionLoopSub']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['changeText'] => $this->_tpl_vars['subChanges']):
        $this->_foreach['versionLoopSub']['iteration']++;
?>
					<li><?php echo $this->_tpl_vars['changeText']; ?>

					<ul>
					<?php $_from = $this->_tpl_vars['subChanges']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['versionLoopSub'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['versionLoopSub']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['subChange']):
        $this->_foreach['versionLoopSub']['iteration']++;
?>
							<li><?php echo $this->_tpl_vars['subChange']; ?>

							</li>
					<?php endforeach; endif; unset($_from); ?>
					</ul>
					</li>
				<?php endforeach; endif; unset($_from); ?>
				</ul>
			</li>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
</div>

<h3>Exemples</h3>
<p class="center"><a href="#" id="showExamples">Afficher</a> - <a href="#" id="hideExamples">Cacher</a></p>
<div id="examples">
<?php echo '
<p>
Vous vous demandez surement à quoi ressemble une page avec ce framework ?<br />
Voici quelques exemples de codes commentés :<br />
<pre name="code" class="php">
define(\'_IN\',true);
include(\'init.php\'); //initialisation
include(\'changes.php\'); //Array du changelog ($changelog)
$pr = Site::instance()->getNewRender(); //Objet pour la génération de la sortie
$pr->useCache(\'index\',100); //On active le cache de cette page, sous le nom de index et pour 100 sec.
if(!$pr->afficherSiCache()) //Affiche la page si elle est en cache
{
	//Sinon on définit les variables et le template fait tout le travail.
	$pr->setVar(\'changelog\',$changelog);
	$pr->afficher(\'index\');
}
</pre>
'; ?>

Les templates sont gérés via <a href="http://www.smarty.net/">Smarty</a>, un gestionnaire rapide et efficace de templates.
<br />Le code du template ressemble à ca (<a href="#" id="afficherHtml">Afficher</a>);<br />
<div id="codeHtml">
	<pre name="code" class="html">
	<?php echo $this->_tpl_vars['templateHtml']; ?>

	</pre>
</div>
</p>
<?php echo '
<script language="javascript">
dp.SyntaxHighlighter.ClipboardSwf = \'/flash/clipboard.swf\';
dp.SyntaxHighlighter.HighlightAll(\'code\');
</script>
'; ?>

</div>

<?php echo '
<script>
	$(\'#jquery-test-click\').click(function() 
		{
		/*$(\'#jquery-test\').resizable();*/
		$(\'#jquery-test\').fadeTo(\'slow\', 0.5);
		$(\'#jquery-test\').fadeTo(\'slow\', 0.7);
		$(\'#jquery-test\').fadeTo(\'slow\', 0.2);
		$(\'#jquery-test\').fadeTo(\'slow\', 1);
		});
	$(\'#changelog\').hide("slow");
	$(\'#examples\').hide("slow");
	$(\'#codeHtml\').hide("slow")
	$(\'#showChangelog\').click(function(event) 
		{
		$(\'#changelog\').show("slow");
		event.preventDefault();
		});
	$(\'#showExamples\').click(function(event) 
		{
		$(\'#examples\').show("slow");
		event.preventDefault();
		});
	$(\'#hideChangelog\').click(function(event) 
		{
		$(\'#changelog\').hide("slow");
		event.preventDefault();
		});
	$(\'#hideExamples\').click(function(event) 
		{
		$(\'#examples\').hide("slow");
		event.preventDefault();
		});
	$(\'#afficherHtml\').click(function(event)
		{
		$(\'#codeHtml\').show("slow");
		event.preventDefault();		
		});
</script>
'; ?>