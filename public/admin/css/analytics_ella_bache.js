
	<script type="text/javascript">

	var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '{$codeGA}']);
		_gaq.push(['_trackPageview']);

	{if $category->id != 45}

	{if isset($product)}
	_gaq.push(['_setPageGroup', '2', 'Fiche Produit']);
	{else}
		{if isset($category)}
			{if $category->id == 6 || $category->id == 4 || $category->id == 29 || $category->id == 10}
	_gaq.push(['_setPageGroup', '2', 'Rayons']);
			{else}
	_gaq.push(['_setPageGroup', '2', 'Etagère']);
			{/if}
		{else}
			{if isset($cms)}
	_gaq.push(['_setPageGroup', '1', 'Cms']);
			{else}
				{if $page_name == 'index'}
	_gaq.push(['_setPageGroup', '2', 'Home']);
				{else if $page_name == 'authentication'}
					{if $smarty.get.back && strpos($smarty.get.back, "order") !== false }
	_gaq.push(['_setPageGroup', '2', 'Retail Authentification']);
					{else}
	_gaq.push(['_setPageGroup', '1', 'Cms']);
					{/if}
				{else if $page_name == 'order'}
	_gaq.push(['_setPageGroup', '2', "Retail{if $page_name == 'order'} {$page_name|Capitalize}{if Tools::getValue('step')} Step {Tools::getValue('step')}{/if}{/if}"]);
				{else}
	_gaq.push(['_setPageGroup', '1', 'Cms']);
				{/if}
			{/if}
		{/if}
	{/if}

	{else}
	_gaq.push(['_setPageGroup', '3', 'Soins']);
	{/if}
	

	{literal}
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})(); {/literal}

	</script>



//Analytics

$("a.pageview").click(function() {
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		var uri = $(this).data("uri");
		var section = $(this).text();
		var title = $('title').first().text()+' '+section;
		ga('send', 'pageview', {
			'page': uri,
			'title': title
		});
	});

	$(".cart_analytics").click(function() {
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('send', {
		  'hitType': 'event',          // Required.
		  'eventCategory': 'button',   // Required.
		  'eventAction': 'click',      // Required.
		  'eventLabel': 'ajout_panier'
		});

	});
	$(".cart_analytics_del").click(function() {
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('send', {
		  'hitType': 'event',          // Required.
		  'eventCategory': 'button',   // Required.
		  'eventAction': 'click',      // Required.
		  'eventLabel': 'suppression_panier'
		});
	});