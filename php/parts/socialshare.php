<div class="share">
	<p>Share on:</p>
	<span class="twitter" data-url="https://twitter.com/share?text=<?php echo urlencode($page->title()) ?>&amp;url=<?php echo urlencode ($page->permalink()) ?>" rel="nofollow noreferrer" title="Share on Twitter">
		<i class="icon-twitter"></i>
	</span>
	<span class="facebook" data-url="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode ($page->permalink()) ?>" data-toggle="tooltip" data-placement="top" rel="nofollow noreferrer" data-original-title="Share on Facebook">
		<i class="icon-facebook"></i>
	</span>	
	<span data-url="https://www.reddit.com/submit?url=<?php echo urlencode ($page->permalink()) ?>&amp;title=<?php echo urlencode($page->title()) ?>" data-toggle="tooltip" data-placement="top" class="reddit" rel="nofollow noreferrer" data-original-title="Share on Reddit">
		<i class="icon-reddit"></i>
	</span>
	<a href="mailto:?subject=<?php echo rawurlencode($page->title()) ?>&amp;body=<?php echo urlencode ($page->permalink()) ?>" data-toggle="tooltip" data-placement="top" class="email" rel="nofollow noreferrer" data-original-title="Share by Email">
		<i class="icon-envelope"></i>
	</a>
</div>