<?php
/*
Plugin Name: PriyoLahiri Keyboard Nav and Ajax Load
Plugin URI: http://www.priyolahiri.co.cc
Description: Previous-Next scroll of blog post/posts with the Pageup/Leftarrow and Pagedown/Rightarrow keys and preloading of content by ajax
Version: 1.0
Author: priyolahiri
*/
//add_action('wp_footer','keyboard_shortcut_navigation');
add_action('wp_enqueue_scripts', 'latestJquery');
add_action('wp_head', 'contentLoad');
//add_action('wp_head', 'keybShort');
function latestJquery() {
wp_deregister_script( 'jquery' );
wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
wp_enqueue_script( 'jquery' );
}
function contentLoad() {
if (is_single()) {
global $id;
$prev_link = get_permalink(get_adjacent_post(true, '', true));
$next_link = get_permalink(get_adjacent_post(true, '', false));
$curr_link = get_permalink(get_post($id));
if ($prev_link != $curr_link && $prev_link != "") {
echo '<link rel="prerender" href="'.$prev_link.'" />
<link rel="preload" href="'.$prev_link.'" />
';
}
if ($next_link != $curr_link && $next_link != "") {
echo '<link rel="prerender" href="'.$next_link.'" />
<link rel="preload" href="'.$next_link.'" />
';
}
?>
<!-- jQuery ScrollTo Plugin -->
<script src="http://balupton.github.com/jquery-scrollto/scripts/jquery.scrollto.min.js"></script>
<!-- History.js -->
<script src="http://balupton.github.com/history.js/scripts/bundled/html4+html5/jquery.history.js"></script>
<script type="text/javascript">
	(function(window, undefined) {
		// Prepare our Variables
		var History = window.History, $ = window.jQuery, document = window.document;
		// Check to see if History.js is enabled for our Browser
		if(!History.enabled) {
			return false;
		}
		// Wait for Document
		$(function() {
			// Prepare Variables
			var
			/* Application Specific Variables */ contentSelector = '#page', $content = $(contentSelector), contentNode = $content.get(0),
			//$menu = $('#menu,#nav,nav:first,.nav:first').filter(':first'),
			//activeClass = 'active selected current youarehere',
			//activeSelector = '.active,.selected,.current,.youarehere',
			//menuChildrenSelector = '> li,> ul > li',
			/* Application Generic Variables */
			$body = $(document.body), rootUrl = History.getRootUrl(), scrollOptions = {
				duration : 800,
				easing : 'swing'
			};

			// Ensure Content
			if($content.length === 0) {
				$content = $body;
			}

			// Internal Helper
			$.expr[':'].internal = function(obj, index, meta, stack) {
				// Prepare
				var $this = $(obj), url = $this.attr('href') || '', isInternalLink;

				// Check link
				isInternalLink = url.substring(0, rootUrl.length) === rootUrl || url.indexOf(':') === -1;

				// Ignore or Keep
				return isInternalLink;
			};
			// HTML Helper
			var documentHtml = function(html) {
				// Prepare
				var result = String(html).replace(/<\!DOCTYPE[^>]*>/i, '').replace(/<(html|head|body|title|meta|script)([\s\>])/gi, '<div class="document-$1"$2').replace(/<\/(html|head|body|title|meta|script)\>/gi, '</div>');

				// Return
				return result;
			};
			// Ajaxify Helper
			$.fn.ajaxify = function() {
				// Prepare
				var $this = $(this);

				// Ajaxify
				$this.find('nav#nav-single a').click(function(event) {
					// Prepare
					var $this = $(this), url = $this.attr('href'), title = $this.attr('title') || null;

					// Continue as normal for cmd clicks etc
					if(event.which == 2 || event.metaKey) {
						return true;
					}
					// Ajaxify this link
					History.pushState(null, title, url);
					event.preventDefault();
					return false;
				});
				// Chain
				return $this;
			};
			// Ajaxify our Internal Links
			$body.ajaxify();
			document.onkeydown = chang_page;
			// Hook into State Changes
			$(window).bind('statechange', function() {
				// Prepare Variables
				var State = History.getState(), url = State.url, relativeUrl = url.replace(rootUrl, '');

				// Set Loading
				$body.addClass('loading');

				// Start Fade Out
				// Animating to opacity to 0 still keeps the element's height intact
				// Which prevents that annoying pop bang issue when loading in new content
				$content.animate({
					opacity : 0
				}, 800);

				// Ajax Request the Traditional Page
				$.ajax({
					url : url,
					success : function(data, textStatus, jqXHR) {
						// Prepare
						var $data = $(documentHtml(data)), $dataBody = $data.find('.document-body:first'), $dataContent = $dataBody.find(contentSelector).filter(':first'), contentHtml, $scripts;

						// Fetch the scripts
						$scripts = $dataContent.find('.document-script');
						if($scripts.length) {
							$scripts.detach();
						}

						// Fetch the content
						contentHtml = $dataContent.html() || $data.html();
						if(!contentHtml) {
							document.location.href = url;
							return false;
						}

						// Update the menu
						//$menuChildren = $menu.find(menuChildrenSelector);
						//$menuChildren.filter(activeSelector).removeClass(activeClass);
						//$menuChildren = $menuChildren.has('a[href^="'+relativeUrl+'"],a[href^="/'+relativeUrl+'"],a[href^="'+url+'"]');
						//if ( $menuChildren.length === 1 ) { $menuChildren.addClass(activeClass); }

						// Update the content
						$content.stop(true, true);
						$content.html(contentHtml).ajaxify().css('opacity', 100).show();
						/* you could fade in here if you'd like */

						// Update the title
						document.title = $data.find('.document-title:first').text();
						try {
							document.getElementsByTagName('title')[0].innerHTML = document.title.replace('<', '&lt;').replace('>', '&gt;').replace(' & ', ' &amp; ');
						} catch ( Exception ) {
						}

						// Add the scripts
						$scripts.each(function() {
							var $script = $(this), scriptText = $script.text(), scriptNode = document.createElement('script');
							scriptNode.appendChild(document.createTextNode(scriptText));
							contentNode.appendChild(scriptNode);
						});
						// Complete the change
						if($body.ScrollTo || false) {
							$body.ScrollTo(scrollOptions);
						}/* http://balupton.com/projects/jquery-scrollto */
						$body.removeClass('loading');

						// Inform Google Analytics of the change
						if( typeof window.pageTracker !== 'undefined') {
							window.pageTracker._trackPageview(relativeUrl);
						}

						// Inform ReInvigorate of a state change
						if( typeof window.reinvigorate !== 'undefined' && typeof window.reinvigorate.ajax_track !== 'undefined') {
							reinvigorate.ajax_track(url);
							// ^ we use the full url here as that is what reinvigorate supports
						}
					},
					error : function(jqXHR, textStatus, errorThrown) {
						document.location.href = url;
						return false;
					}
				});
				// end ajax

			});
    		function chang_page(e) {
    			var e = e || event,
    			keycode = e.which || e.keyCode;
				var obj = e.target || e.srcElement;
				if(obj.tagName.toLowerCase()=="textarea"){return;}
				if(obj.tagName.toLowerCase()=="input"){return;}
				if (keycode == 33 || keycode == 37) {
					var url = $('span.nav-previous a').attr('href');
					History.pushState(null, null, url);
				}
				if (keycode == 34 || keycode == 39) {
					var url = $('span.nav-next a').attr('href');
					History.pushState(null, null, url);
				}
			}
		});
		// end onDomLoad

	})(window);
</script>
<?php
}
}
