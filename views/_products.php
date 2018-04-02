<div class="banner">
  </br></br></br></br>
  <h1>Your Pokedex Market</h1>
  <h2>Select your favorite Pokemon</h2>
</div>
<div class="sort">
	<ul>
    <li class="choice" id="0"><img src="" alt="pokemon"></li>
    <li class="choice" id="1"><img src="" alt="pokemon"></li>
    <li class="choice" id="2"><img src="" alt="pokemon"></li>
	</ul>
</div>
<div class="product-cntnr">
  <?php foreach($products as $p): ?>
    <div class='product'>
      <div class="img-cntnr">
        <img src=<?php echo $p['image']; ?> />
      </div>
      <div class="txt-cntnr">
        <h3><?php echo strtoupper($p['name']); ?></h3>
        <p><?php echo $p['description']; ?></p>
        <form action="card_crud.php" method="POST">
          <div class="btn-cntnr">
          <input type="hidden" name='product_id' value="<?php echo $p['id'];?>">
          <input type="hidden" name='action' value="add">
            <button class="add-to-cart">ADD TO CART</button>
          </div>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<div id="video_container">
	<video id="video" width="640" height="480" autoplay></video>
	<!-- <div class="img_container"></div> -->
</div>
<button id="snap" class="anim btn hide"><img src="Public/img/snap.png" alt="snap pokemon"> </button>
<canvas id="canvas" width="640" height="480"></canvas>
<script>
(function ()
{
	var canvas = document.getElementById('canvas'),
    context = canvas.getContext('2d'),
    choice_list = document.getElementsByClassName('choice'),
    choice_list_len = choice_list.length,
    snap = document.getElementById('snap'),

    i = 0,
    j = 0,
    choice = false,
		txt;


	// Get access to the camera!
	if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
	{
	    // Not adding `{ audio: true }` since we only want video now
	    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream)
	    {
	        video.src = window.URL.createObjectURL(stream);
	        video.play();
	    });
	}

  for (; i < choice_list_len; i++)
  {
    choice_list[i].addEventListener("click", function()
    {
        choice = this.id;
        for (j = 0; j < choice_list_len; j++)
          choice_list[j].classList.remove('selected');

        document.getElementById(choice).classList.add('selected');
        snap.classList.remove('hide');

    })
  }

  document.getElementById("snap").addEventListener("click", function()
	{
		context.drawImage(video, 0, 0, 640, 480);
		txt = canvas.toDataURL("image/png") || null;

		if (choice && txt)
		{
      let  form = document.createElement("form"),
        element1 = document.createElement("input"),
        element2 = document.createElement("input");

      form.method = "POST";
      form.action = "";

      element1.name="image";
      element1.value = txt;
      form.appendChild(element1);

      element2.value=choice;
      element2.name="filter";
      form.appendChild(element2);

      document.body.appendChild(form);

      form.submit();
      console.log(txt)
      return ;
    }
  })

})()

</script>
