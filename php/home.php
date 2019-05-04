<main id="content" class="container" role="main">
	<div class="row">
		<div class="col-lg-10 col-xl-8 mr-auto ml-auto">
			<section class="intro">
				<div class="intro-meta">
					<div class="inner">
						<?php if ($site->slogan()): ?>
						<h1><?php echo $helper->slogan(); ?></h1>
						<?php endif ?>
						<?php if ($site->description()): ?>
						<p>
							<?php echo $helper->description(); ?>
						</p>
						<?php endif ?>
					</div>					
				</div>
			</section>

			<h4 class="title"><?php echo $L->get('Latest posts') ?></h4>
			<div class="loop">
				<!-- Print all the content -->
				<?php foreach ($content as $page): ?>
				<article class="post item <?php echo $page->sticky() ? 'featured':''; ?>">
					<div class="post-inner-content">

						<a href="<?php echo $page->permalink(); ?>" class="post-title" title="<?php echo $page->title(); ?>">
							<h2>
								<?php echo $page->title(); ?>
							</h2>
						</a>
						<p>
							<?php if(strlen($page->description())>0 ){
									  echo  $page->description();
								  }
								  else{
									  echo  $helper->content2excerpt($page->content(false), 250);
								  }
                            ?>
						</p>
					</div>
					<div class="post-meta">
						<time datetime="<?php echo $page->dateRaw('c') ?>">
							<?php echo $page->date() ?>
						</time>
						<?php if ($page->category()):?>
						<span class="tags">
							<span class="entry-terms category">
								<a href="<?php echo DOMAIN_CATEGORIES.$page->categoryKey() ?>" rel="tag">
									<?php echo $page->category() ?>
								</a>
							</span>
						</span>
						<?php endif?>
						<div class="inner">
							<a href="https://twitter.com/share?text=<?php echo urlencode($page->title()) ?>&amp;url=<?php echo urlencode ($page->permalink()) ?>" class="twitter" onclick="window.open(this.href, 'share-twitter', 'width=550,height=235');return false;"
								data-toggle="tooltip" data-placement="top" title="" data-original-title="Share on Twitter">
								<i class="icon-twitter"></i>
							</a>
							<a href="#" class="read-later" data-toggle="tooltip" data-placement="top" data-id="<?php echo $page->slug() ?>" data-title="<?php echo $page->title() ?>" data-original-title="Read Later">
								<i></i>
							</a>
						</div>
					</div>
				</article>
				<?php endforeach ?>
			</div>

			<!-- Pagination -->
			<?php if (Paginator::numberOfPages()>1): ?>
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<nav class="pagination" role="navigation">
							<div class="row">
								<div class="col-4 text-left">
									<?php if (Paginator::showPrev()):?>
									<a class="newer-posts btn" href="<?php echo Paginator::previousPageUrl() ?>">
										<?php echo $L->get('Newer'); ?>
									</a>
									<?php endif; ?>
								</div>
								<div class="col-4">
									<span class="page-number">
										<?php echo Paginator::currentPage() ?> / <?php echo Paginator::numberOfPages() ?>
									</span>
								</div>
								<div class="col-4 text-right">
									<?php if (Paginator::showNext()):?>
									<a class="older-posts btn" href="<?php echo Paginator::nextPageUrl() ?>">
										<?php echo $L->get('Older'); ?>
									</a>
									<?php endif; ?>
								</div>

							</div>
						</nav>
					</div>
				</div>
			</div>
			<?php endif ?>
		</div>
	</div>
</main>
