function subscribeUnisenderForm(form) {
	core.post(
		URLHandler.buildURL({ target: 'unisender', action: 'subscribe' }),
		function (XMLHttpRequest, textStatus, data, isValid) {
			data = JSON.parse(data);
			if (data.status == 'error') {
				core.showError(data.message);
			} else {
				core.trigger(
					'message',
					{type: 'success', message: data.message}
				);
				form.reset();
			}
		},
		jQuery(form).serialize(),
		{ rpc: true }
	);
	return false;
}