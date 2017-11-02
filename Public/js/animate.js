(function ()
{
	let obj = {},
		i = 0;
	window.requestAnimationFrame =	window.requestAnimationFrame || window.mozRequestAnimationFrame ||
                             		window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
	
	obj.init = function ()
	{
		this.persos = [];
		this.added	= [];
	}

	obj.create = function (perso)
	{
		let key,
			persos = this.persos;

		if (Object.prototype.toString.call(perso) != '[object Object]')
			return ;
		if (!perso.hasOwnProperty('name'))
			return ;
		for (var i = persos.length - 1; i >= 0; i--)
			if (persos[i].name == perso.name)
				return ;
		this.persos.push(perso);
		return (this);
	}

	obj.get = function(name)
	{
		let key,
			persos = this.persos,
			i;

		i = persos.length - 1;
		if (!i || typeof name != 'string')
			return ;
		for (; i >= 0; i--)
			if (persos[i].name == name)
				return (persos[i]);
		return (null);
	}

	obj.get_perso_id = function(name)
	{
		let key,
			persos = this.persos,
			i;

		i = persos.length - 1;
		if (!i || typeof name != 'string')
			return ;
		for (; i >= 0; i--)
			if (persos[i].name == name)
				return (i);
		return (null);
	}

	obj.append = function(name)
	{
		let elem,
			perso,
			that;

		if (Array.isArray(name) && (that = this)) 
			name.forEach((el) => that.append(el));
		if (this.added.indexOf(name) > -1)
			return ;
		if (!(perso = this.get(name)))
			return ;
		if (!perso.img_url)
			return ;
		
		elem = document.createElement('img');
		elem.src = perso.img_url;
		elem.id = perso.name;
		elem.className = 'anim_perso';
		document.getElementById('gif_anim').appendChild(elem);
		this.added.push(name);
		return (this);
	}

	obj.animate = function (name)
	{
		var elem = document.getElementById(name),
			perso,
			pos = 0,
			start_poz,
			end_poz,
			WW = window.innerWidth,
			direction = 'right',
			change_direction = false,
			i,
			direction_x = ((Math.random() * WW) + 50) - 100,
			direction_y = ((Math.random() * WW) + 50) - 100,
			tmp_direction_x,
			tmp_direction_y,
			x = direction_x, 
			y,
			request_id = false;

		if (!elem)
			return ;
		request_id = requestAnimationFrame(frame);
		i = obj.get_perso_id(name);
		if (!obj.persos && !obj.persos[i])
			return ;
		obj.persos[i].animate_id = request_id;
		perso = obj.persos[i];
		WW = window.innerWidth;
		elem.style.display = 'block';
		if (perso.style)
			addStyle(elem, perso.style);
		else
			elem.style.width = (WW / 15) + 'px';
		WW = WW - (WW / 15);
		start_poz = !perso.animation ? 0 : perso.animation.start_poz;
		end_poz = !perso.animation ? WW : perso.animation.end_poz;
		pos = start_poz;
		function frame()
		{
			if (perso.fly)
				return (fly());
			if (direction == 'right')
			{
				pos++;
				if (pos >= end_poz)
				{
					elem.style.transform = 'rotateY(0deg)';
					direction = 'left';
				}
			}
			else if (direction == 'left')
			{
				pos--;
				if (pos <= start_poz)
				{
					elem.style.transform = 'rotateY(180deg)';
					direction = 'right';
				}
			}
			elem.style.left = pos + 'px';
			request_id = requestAnimationFrame(frame);
		}

		function addStyle(perso, styles)
		{
			let key;

			if (!styles)
				return ;
			for (key in styles)
				perso.style[key] = styles[key];
		}
		function fly()
		{
			setTimeout(function()
			{
				tmp_direction_x = ((Math.random() * WW) + 50) - 100;
				tmp_direction_y = ((Math.random() * WW) + 50) - 100;
				if (x <= tmp_direction_x)
					direction = 'left';
				else
					direction = 'right';

				move();
				console.log('direction changed', tmp_direction_x, tmp_direction_y)


			}, (Math.random() * 1500) + 100)

		}

		function move()
		{

			x = parseInt(elem.style.left) || parseInt(getComputedStyle(elem).left);
			y = parseInt(elem.style.bottom) || parseInt(getComputedStyle(elem).bottom);

			if (direction == 'left')
				elem.style.transform = 'rotateY(180deg)';
			else
				elem.style.transform = 'rotateY(0deg)';


			if ((x > tmp_direction_x - 10 && x < tmp_direction_x + 10) &&
				(y > tmp_direction_y - 10 && y < tmp_direction_y + 10))
			{
				if (request_id != false)
					cancelAnimationFrame(request_id);
				console.log('done')
				return (fly());
			}

			elem.style.left = (x < tmp_direction_x) ?  (x + 1) + 'px' : (x - 1) + 'px';
			elem.style.bottom = (y < tmp_direction_y) ?  (y + 1) + 'px' : (y - 1) + 'px';

			requestAnimationFrame(move);
		}
	}

	obj.init();
	obj.create({'name' : 'salameche', 'img_url' : '/camagru/Public/img/salameche.gif'});
	obj.create({'name' : 'bulbizard', 'img_url' : '/camagru/Public/img/bulbizard.gif'});
	obj.create({'name' : 'carapuce', 'img_url' : '/camagru/Public/img/carapuce.gif'});
	obj.create({'name' : 'fantominus', 'img_url' : '/camagru/Public/img/fantominus.gif'});
	// obj.create({'name' : 'fantominus', 'img_url' : '/camagru/Public/img/fantominus.gif'});
	obj.create({
		'name' : 'sulfura',
		'img_url'		: '/camagru/Public/img/sulfura.gif',
		'style'			:
		{
			'width' 	: 'auto',
			'height'	: 'auto'
		},
		'speed' 		: 2,
		'fly'			: true,
		'animation' 			: 
		{
			'start_poz'	: window.innerWidth - 350,
			'end_poz'	: window.innerWidth - 200
		}
	});
	obj.append(['salameche', 'sulfura']);
	// obj.append(['salameche', 'bulbizard', 'carapuce', 'fantominus', 'dragonfee']);

	obj.persos.forEach((el) =>
	{
		Math.floor((Math.random() * 100) + 1);
	})

	obj.animate(obj.persos[i].name);
	i++;
	(function animAll()
	{
		setTimeout(function ()
		{
			if (obj.persos[i])
			{
				obj.animate(obj.persos[i].name);
				i++;
				animAll();
			}
			
		}, Math.floor((Math.random() * 1500) + 100))
	})()


	// obj.animate('salameche');
	// setTimeout(function ()
	// {
	// 	obj.animate('bulbizard');
	// 	setTimeout(function ()
	// 	{
	// 		obj.animate('fantominus');
	// 		obj.animate('carapuce');
	// 	}, Math.floor((Math.random() * 15000) + 1000))
	// }, Math.floor((Math.random() * 15000) + 1000))
		
})()