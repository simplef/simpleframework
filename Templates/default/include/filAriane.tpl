{* Smarty *}
{* Besoin de :
-pageName
-
-
*}
{* Fonctionnement : Inclu le header et le footer*}
{include file="include/header.tpl"}
		<div class="corps">
			{include file=$pageName}
		</div>
{include file="include/footer.tpl"}