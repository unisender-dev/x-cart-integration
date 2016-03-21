{if:!isConnected()}
<br>
<div class="alert alert-warning">
		{t(#wrongApiKey#)}
	</div>
{end:}

<div class="settings general-settings settings-unisender">
	<widget class="\XLite\Module\UnisenderInc\Integration\View\Model\Settings" useBodyTemplate="1" />
</div>

<div class="helpBlock">
    <a target="_blank" href="{getHelpUrl()}">{t(#unisenderHelpUrlTitle#)}</a>
</div>