(function ()
{
	let data = '',
	tmp = location.search;
	if (tmp && tmp.indexOf('confirm_id'))
	{
		tmp.split('&').forEach((data) =>
		{
			data = data.split('=');
			if (data[0] == 'confirm_id' && data[1].length > 0)
				;
		})
	}
	console.log(data.split('='))

})()