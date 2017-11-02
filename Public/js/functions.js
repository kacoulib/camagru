function ajax(data, fn)
{
	let xhr = new XMLHttpRequest(),
	txt = '',
	tmp,
	i;

	if (!data || !data['method'] || !data['url'] || !data['data'])
	 	return ;
	xhr.open(data['method'], data['url'], true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onload = function ()
	{
		if (xhr.status == 200)
		{
			if (!fn || !({}.toString.call(fn) === '[object Function]'))
				return ;
			fn(xhr.responseText);
		}
		else
			console.log("Connection error. Status: " + xhr.status);
	}
	if (Object.prototype.toString.call(data['data']))
	{
		i = Object.keys(data['data']).length;
		for (tmp in data['data'])
		{
			if (data['data'].hasOwnProperty(tmp))
			{
				txt += tmp + '=' + data['data'][tmp];
				if (--i > 0)
					txt += '&';
			}
		}
	}
	else
		txt = data['data'];
	xhr.send(txt);
}
