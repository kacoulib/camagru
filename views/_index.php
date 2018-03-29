<div class="index-ban">
  <div class="bck">
    <div>
      <h1>The new standard in online rockets</h1><br/>
      <p>RocketMarket is the best platform for running a rocket business. We handle billions of rockets every year for forward-thinking businesses around the world.</p>
      <a href="products.php" action='get'><p class="btn">BUY NOW →</p></a>
    </div>
  </div>
</div>
<div class="product-cntnr">
  <h1>Our Ariane Rockets</h1>
  <?php 
      if ($products):
        foreach($products as $p): ?>
    <?php if ($i < 6): ?>
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
      <?php $i++; ?>
    <?php endif;?>
  <?php endforeach;
    endif;
  ?>
</div>
<div class="sell-products">
  <div>
    <img src="img/process.png"/>
    <h2>ALWAYS IMPROVING</h2>
    <p>Rocketmarket is an always-improving toolchain that gains new features every month.</p>
    <p>Our world-class engineering team constantly iterates upon every facet of the Rocketmarket stack.</p>
    <p>And from Apple Pay to Bitcoin, buying with Rocketmarket means you get early access to the latest technologies.</p>
  </div>
  <div>
    <img src="img/global.png"/>
    <h2>GLOBAL SCALE</h2>
    <p>We help power 100,000+ businesses in 100+ countries and across nearly every industry.</p>
    <p>Headquartered in Paris, Rocketmarket has 9 global offices and hundreds of people working to help transform how modern businesses are built and run.</p>
  </div>
</div>
<div class="last-sell-div">
  <div>
    <h2>THE COMPLETE TOOLKIT FOR ROCKET BUSINESS</h2>
    <p>RocketMarket builds the most powerful and flexible rockets.</p>
    <p>Whether you’re creating a travel service, an on-demand rocketplace, an rocket store, or a rocket crowdfunding platform,
      RocketMarket’s meticulously-designed rockets and unmatched functionality help you create the best possible services for your users.</p>
    <p>Hundreds of thousands of the world’s most innovative technology rockets are scaling faster and more efficiently by building their businesses on RocketMarket.</p>
  </div>
  <div><img src="img/rocketman.png"/></div>
</div>
