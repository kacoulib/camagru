

function ajax(data, fn)
{
	let xhr = new XMLHttpRequest(),
	tmp,
	that = this,
	outpout = false,
	i;

	this.get = function ($url)
	{

	}

	this.post = function (url, data, fn)
	{
		let txt = '';

		xhr.open('POST', url, true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		if (Object.prototype.toString.call(data))
		{
			i = Object.keys(data).length;
			for (tmp in data)
			{
				if (data.hasOwnProperty(tmp))
				{
					txt += tmp + '=' + data[tmp];
					if (--i > 0)
						txt += '&';
				}
			}
		}
		else
			txt = data;
		xhr.send(txt);
		get_response(fn)
		return (this);
	}

	function get_response(fn)
	{
		xhr.onload = function ()
		{
			if (!fn || !({}.toString.call(fn) === '[object Function]'))
				return ;
			tmp = xhr.status;
			fn(xhr.responseText, tmp);
		}
		return (that);
	}
}
var $ = new ajax();