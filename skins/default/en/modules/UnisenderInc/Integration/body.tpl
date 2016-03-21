<widget class="\XLite\Module\UnisenderInc\Integration\View\Model\UnisenderForm" name="UnisenderSubscribe" />
<div class="unisenderSubscribe">
	<widget
			class="\XLite\View\FormField\Input\Text\Email"
			fieldName="email"
			placeholder="{t(#email#)}"
			fieldOnly="true"/>
	<widget
			class="\XLite\View\FormField\Input\Text\Phone"
			fieldName="phone"
			placeholder="{t(#phone#)}"
			fieldOnly="true"/>
	<widget
			class="\XLite\View\FormField\Input\Text"
			fieldName="name"
			placeholder="{t(#name#)}"
			fieldOnly="true"/>
	<widget
			class="\XLite\View\Button\Submit"
			label="{t(#subscribe#)}"
			style="main"/>
</div>
<widget name="UnisenderSubscribe" end/>