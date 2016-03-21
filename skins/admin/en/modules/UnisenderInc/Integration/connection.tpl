<div class="settings general-settings settings-unisender">

    {if:!isConnected()}
        <h3>{t(#unisenderRegistration#)}</h3>
        <div class="">{t(#getNewAffiliateAccountInfo#,_ARRAY_(#X#^getNewAffiliateAccountUrl())):h}</div>
        <div class="clear" style="height: 20px;"></div>
        <h3>{t(#existingAccount#)}</h3>
        {t(#getApiKeyInfo#,_ARRAY_(#X#^getApiConfigUrl())):h}<br>
    {end:}

    <widget class="\XLite\Module\UnisenderInc\Integration\View\Model\Settings" useBodyTemplate="1" />

</div>

<div class="helpBlock">
    <a target="_blank" href="{getHelpUrl()}">{t(#unisenderHelpUrlTitle#)}</a>
</div>