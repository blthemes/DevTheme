<header>
	<div class="container">
		<div class="row">
			<div class="col-lg-10 col-xl-9 mr-auto ml-auto">
				<div class="wrap">
					<div class="blog-logo">
						<a href="<?php echo $site->url(); ?>" rel="home">
							<?php if( method_exists($site, 'logo') &&  $site->logo() ):?>
							<img src="<?php echo $helper->cdn_that_image($site->logo(), 130); ?>" alt="<?php echo $site->title()?>"/>
							<?php else: ?>
							<?php echo $site->title(); ?>							
							<span>
								<svg viewBox="0 0 20 20" width="14" height="14" xmlns="http://www.w3.org/2000/svg">
									<path d="M2.3 9.2C4.1 9.1 4 7.2 4 6c.071-1.4-.2-3.5 1.6-4 .337-.088.6-.084 1-.084h.47v1.3h-.26c-1.4 0-1.3.449-1.4 1.7-.179 1.9.374 4-1.7 5 1.6.674 1.6 2.2 1.7 3.7.054 1.3-.419 2.9 1.4 2.9h.26V18H6.6c-.4 0-.817 0-1.1-.134-1.6-.603-1.3-2.5-1.4-3.8-.077-1.2.148-3.3-1.7-3.3V9.2" fill="#27b3ff"></path>
									<path d="M17.6 9.2v1.3c-1.8.047-1.6 1.9-1.7 3.2-.071 1.4.202 3.5-1.6 4-.337 0-.693 0-1 .092h-.471v-1.3h.261c1.4 0 1.3-.453 1.4-1.7.16-1.8-.373-4.1 1.7-5-1.6-.766-1.6-2.1-1.7-3.7-.055-1.3.412-2.9-1.4-2.9h-.261V1.8h.471c.4 0 .816-.002 1.1.135 1.6.6 1.3 2.5 1.4 3.8.078 1.2-.145 3.3 1.7 3.3" fill="#57595b"></path>
								</svg>
							</span>
							<?php endif; ?>
						</a>
					</div>
					<div class="wrap">
						<nav class="nav">
							<ul>
								<?php foreach ($categories->db as $key=>$fields):
										  if($fields['list']):  ?>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo DOMAIN_CATEGORIES.$key; ?>">
										<?php echo $fields['name']; ?>
									</a>
								</li>
								<?php
										  endif;
									  endforeach; ?>
								<?php if($site->homepage()):?>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo DOMAIN_BASE.$url->filters('blog').'/'; ?>">
										<?php echo $L->get('Blog'); ?>
									</a>
								</li>
								<?php endif;?>
							</ul>
						</nav>
						<a href="#" class="drawer-trigger" data-toggle="modal" data-target="#drawer">
							<span class="drawer-svg"></span>
							<span class="counter hidden"></span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>

