<div class="modal fade" id="drawer" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<a href="#" data-dismiss="modal" aria-label="Close" class="close">
					<i class="icon-cancel-circle"></i>
				</a>
				<div class="widget widget-menu">
					<h3 class="title"><?php echo $L->get('Menu') ?></h3>
				</div>
				<div class="widget">
					<h3 class="title"><?php echo $L->get('Search') ?> </h3>
					<form class="search" method="get" action="<?php echo DOMAIN_PAGES.'dtsearch';?>">
						<input id="search-field" name="search" placeholder="Search" autocomplete="off" />
					</form>
				</div>
				<div class="widget">
					<h3 class="title">Bookmarks</h3>
					<div class="loop bookmark-container">
						<p class="no-bookmarks">
							<?php  echo $L->get("You haven't yet saved any bookmarks. To bookmark a post just click") ?>
							<i class='icon-bookmark'></i>.
						</p>
					</div>
					<?php echo '<script>var domainPages="'.DOMAIN_PAGES.'" ;</script>'.PHP_EOL; ?>
				</div>
				 <?php if ($site->twitter()) : ?>
				 <div class="widget">
                    <h3 class="title"><?php echo $L->get('Latest Tweets') ?></h3>
                    <div class="tweets" data-twitter="<?php echo basename($site->twitter()) ?>"></div>
                </div>				<?php endif; ?>
				<?php Theme::plugins('siteSidebar'); ?>
				<span class="modal-inner-backdrop"></span>
			</div>
		</div>
	</div>
</div>
<footer>
	<div class="container">

		<div class="footer-content">
			<div class="row">
				<div class="col-md-4">					
					<?php if(!empty(Theme::socialNetworks())):?>
					<h3 class="title"><?php echo $L->get('Find us on') ?></h3>
					<ul class="social">
						<?php foreach (Theme::socialNetworks() as $key=>$label): ?>
						<li class="nav-item">
							<a class="<?php echo $key?>" href="<?php echo $site->{$key}(); ?>" target="_blank" rel="nofollow noreferrer" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo $label ?>">
								<i class="icon-<?php echo $key?>" aria-hidden="true"></i>
							</a>
						</li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
					<p class="site-description-footer">
						<?php echo $site->description() ?>
					</p>
				</div>
				<div class="col-md">
					<h3 class="title"><?php echo $L->get('Latest posts') ?></h3>
					<ul class="posts-list">
						<?php

						$listOfKeys = $pages->getList(1, 4);
						if ($listOfKeys) :
							foreach ($listOfKeys as $key) :
								$lPage = new Page($key);
                        ?>
						<li>
							<a href="<?php echo $lPage->permalink() ?>">
								<?php echo $lPage->title() ?>
							</a>
						</li>
						<?php endforeach ?>
						<?php endif ?>

					</ul>
				</div>
				<div class="col-md-3">
					<h3>
						<?php echo $L->get('Pages'); ?>
					</h3>
					<ul class="posts-list">
						<?php foreach ($staticContent as $staticPage) :
						  if(Text::stringContains($staticPage->key(),'404')) continue;
						?>
						<li>
							<a href="<?php echo $staticPage->permalink(); ?>">
								<?php echo $staticPage->title(); ?>
							</a>
						</li>
						<?php endforeach ?>
					</ul>
				</div>

			</div>
		</div>

	</div>
	<div class="container-fluid copyright">
		<div class="row">
			<div class="col-md-12 text-center">
				Copyright &copy; <?php echo date("Y"); ?> ,
				<span>
					<?php echo $L->get('Powered by'); ?>
					<a target="_blank" href="https://www.bludit.com">Bludit</a> &amp;
					<a target="_blank" href="https://blthemes.pp.ua">DevTheme</a>
				</span>
			</div>
		</div>
	</div>
	<a href="#" class="go-up">		
		<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 16 16">
		  <path d="M8.524 5.996l2.735 2.722.741-.737L8 4 4 7.981l.741.737 2.735-2.722V12h1.048V5.996" class="goup-arrow"/>
		  <path d="M8 .5c4.114 0 7.5 3.386 7.5 7.5s-3.386 7.5-7.5 7.5S.5 12.114.5 8 3.886.5 8 .5" class="goup-progress-path"/>
		</svg>
	</a>
</footer>

