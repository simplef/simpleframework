{* Smarty *}
{* Besoin de :
-pageName
-pageHead
-filArianeActive
-filAriane (Name => Url)
*}
{include file="include/header.tpl"}
		<div class="corps">
			<h1>{$pageHead}</h1>
				{if $filArianeActive == true}
				<hr />
					<em>Navigation : </em>
					{foreach from=$filAriane key=fil_name item=fil_url name=filArianeLoop}
						{if $smarty.foreach.filArianeLoop.first}
							<strong>[</strong>
						{else}
							<strong>-></strong>
						{/if}
						<a href="{$fil_url}" title="{$fil_name}">{$fil_name}</a>
						
						{if $smarty.foreach.filArianeLoop.last}
							<strong>]</strong>
						{/if}
					{/foreach}
				<hr />
				{/if}
			
			{include file=$pageName}
		</div>
{include file="include/footer.tpl"}