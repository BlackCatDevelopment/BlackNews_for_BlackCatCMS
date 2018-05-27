BlackNews for Black Cat CMS
===============================

This is a module for Black Cat CMS. It provides the opportunity to add a news page/ blog etc.
Branch 2.0:
* is already prepared to work with BC2 with little modification in future.
* You need to set a permalink in "General settings" and manually add the following lines to .htaccess (Replace #PATH TO YOUR PAGE# with the path to the page, where you use BlackNews and #PERMALINK# with the permalink you set in "General settings")
	
```
    # Redirection for BlackNews
    RewriteCond %{REQUEST_URI} !#PATH TO YOUR PAGE#\.php
	RewriteRule ^#PERMALINK#/(.*)$ /#PATH TO YOUR PAGE#.php?q=$1 [QSA,L]
```

Example:
	URL: http://mydomain.tdl/news.php
	Permlink: mynews
```
    # Redirection for BlackNews
    RewriteCond %{REQUEST_URI} !news\.php
	RewriteRule ^mynews/(.*)$ /news.php?q=$1 [QSA,L]
```

It supports permalinks, variants and RSS.

Please note that this is still work in progress!

# License

This module is distributed under the GPL.