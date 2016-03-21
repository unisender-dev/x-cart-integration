<div class="tabbed-content-wrapper">
	<div class="page-tabs clearfix">
		<ul>
			<li FOREACH="getTabs(),tabPage" class="tab{if:tabPage.isActive}-current{end:}">
				<a href="{tabPage.url:h}">{t(tabPage.title)}</a>
			</li>
		</ul>
	</div>
	<div class="clear"></div>
</div>