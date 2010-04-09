{* Smarty *}
{* index.tpl *}

<h3>{$site_short_name} - Installation réussie !</h3>
<p>
Simple Framework a été <span class="ok">correctement installé</span> !<br />
Vous pouvez maintenant :
<ul>
	<li><span class="ok">Modifier la configuration</span> située dans <em>Config/config.class.php</em></li>
	<li>... y modifier le design par défaut et <span class="ok">créer votre propre template</span>, dans 
	<em>Template/NomDuTemplate</em> et <em>Template/css/NomDuTemplate</em></li>
	<li>Commencer à coder chaque page dans un environnement <span class="ok">sain et rapide</span> avec à votre 
	disposition :
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
</div>
 {literal}
  <img id="jquery-test" src="http://www.jarodxxx.com/public/logos/jquery-logo.gif" alt="" height="64"/>
  <script>
  $('#jquery-test-click').click(function() 
  {
	/*$('#jquery-test').resizable();*/
    $('#jquery-test').fadeTo('slow', 0.5);
	$('#jquery-test').fadeTo('slow', 0.7);
	$('#jquery-test').fadeTo('slow', 0.2);
	$('#jquery-test').fadeTo('slow', 1);
  });
  $('#changelog').hide("slow");
  </script>
  {/literal}
<h3>Changements</h3>
<div id="changelog">
	<ul>
	{foreach from=$changelog key=versionTxt item=version name=versionLoop}
			<li><strong>{$versionTxt}</strong>
				<ul id="detail_{$smarty.foreach.versionLoop.iteration}">
				{foreach from=$version key=changeText item=subChanges name=versionLoopSub}
					<li>{$changeText}
					<ul>
					{foreach from=$subChanges item=subChange name=versionLoopSub}
							<li>{$subChange}
							</li>
					{/foreach}
					</ul>
					</li>
				{/foreach}
				</ul>
			</li>
	{/foreach}
	</ul>
</div>