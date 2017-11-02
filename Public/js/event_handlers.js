(function()
{
	let img_container = document.querySelectorAll('#video_container .img_container')[0],
		video = document.getElementById('video'),
		context = canvas.getContext('2d'),
		checked = false,
		choice = false,
		tmp,
		tmp2,
		img;

	// Btn click
	tmp = document.getElementsByClassName('btn');
	for (var i = tmp.length - 1; i >= 0; i--)
	{
		tmp[i].addEventListener('click', function(e)
		{
			e.preventDefault();
		})
	}

	// Login form btn click
	tmp = document.querySelectorAll('form .btn');
	for (var i = tmp.length - 1; i >= 0; i--)
	{
		tmp[i].addEventListener('click', function(e)
		{
			let data,
			login 		= document.forms['login_form']['login'].value,
			password	= document.forms['login_form']['password'].value,
			email 		= document.forms['login_form']['email'].value,
			action		= 'login';

			if (login.length < 4 || password.length < 4)
				return ;
			if (this.id == 'sub_register')
			{
				if (!(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/.test(email)))
					return ;
				action	= 'register';
			}
			data =
			{
				'url' : '/camagru/Controllers/index.php',
				'method' : 'POST',
				'data' :
				{
					'login' : login,
					'password' : password,
					'email' : email,
					'action' : action
				}
			};
			ajax(data, function (el)
			{
				console.log(el)
			})
		})
	}

	// Filter on click
	tmp = document.querySelectorAll('#filter div');
	for (var i = tmp.length - 1; i >= 0; i--)
	{
		tmp[i].addEventListener('click', function ()
		{
			tmp = this.children;
			if (tmp && tmp[0] && tmp[1])
			{
				img_container.innerHTML = '<img src="'+tmp[0].src+'"/>';
				choice = tmp[1].value;
				checked = true;
			}
		})
	}

	// Snap click
	document.getElementById("snap").addEventListener("click", function()
	{
		context.drawImage(video, 0, 0, 640, 480);
		txt = canvas.toDataURL("image/png") || null;

		console.log(txt)
		return ;
		if (checked && choice && txt)
		{
			ajax({
				'url' : '/camagru/Controllers/index.php',
				'method' : 'POST',
				'data' : {'img' : txt, 'filter' : choice}
			},
			function (el)
			{

				img = document.querySelector('aside img');
				tmp = img.src.split('?');
				if (tmp.length == 2)
				{
					if ((tmp2 = tmp[1].split('=')))
						tmp = tmp[0] + '?v=' + (++tmp2[1]);
					else
						tmp = img.src;
					console.log('sdf')
				}
				else
					tmp = img.src;
				img.src = tmp;
			})
		}
	});
})()