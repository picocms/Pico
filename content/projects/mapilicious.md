/*

Title:	Mapilicious
Description: A jQuery plugin for automatically adding Google maps links to addresses.
Date:	20130321
Tags:	Project, Maps, jQuery

*/

## Overview

This plugin was created out of necessity. One day I decided I was sick of going to Google Maps, entering an address, clicking the little link icon, and copying the URL for a link whenever I added an address to something. This plugin automates that process. It finds the address tags and appends a link to the address on Google maps.

[See examples](http://www.rewdy.com/tools-files/mapilicious/examples.html) | [Download from Github](https://github.com/rewdy/mapilicious)

**Note:** Consider this "beta" and kindly report any issues you find. Thanks. :)

## Implementation

It's as easy as 1-2-3

### 01. Include the Javascript

You will need to include the jQuery and jQuery Mapilicious right before the closing body tag (or in the head if you prefer). Link to them where ever you have them stored.

	...
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="jquery.mapilicious.min.js"></script>
	</body>

### 02. Verify the Markup for Addresses in your Code

Mapilicious needs to know where the addresses in your code are. The semantic way to markup an address is to use the `<address>` tag. Ideally, you should wrap all your addresses in this tag. The default behavior for Mapilicious is to look for address tags and use them to insert the links.

If you are unable to format your addresses this way, however, you can select the addresses on your page with any other jQuery selector.

### 03. Fire up Mapilicious and enjoy

If you are using all the default behavior, all you need is the following code inserted after the scripts included in step 1. If you have markup for your addresses other than the standard address tag, just target your addresses with the jQuery selector like the second example.

	<script>
		// standard method, looks for <address> tags.
		$().mapilicious(); 
	</script>

	<script>
		// alternative method, not using <address> tags.
		$('p.address').mapilicious(); 
	</script>

And, of course, the `p.address` would be replaced with whatever selector you are using.

Voila!

## Options Reference

Here's the fun part. The options. Options can be sent to Mapilicious in the standard jQuery way. Here's an example:

	<script>
		$().mapilicious({
			placement: 'after',
			linkText: 'View a map'
		}); 
	</script>

<dl>
	<dt>range: <span class="default">&#39;address&#39;</span></dt>
	<dd>This sets where Mapilicious looks for addresses. This value gets set automatically (based on how Mapilicious is initiated) and doesn&#39;t ever really need to be used as an option.</dd>
	<dt>placement: <span class="default">&#39;append&#39;</span></dt>
	<dd><em>Options: &#39;append&#39;, &#39;prepend&#39;, &#39;after&#39;, &#39;before&#39;</em><br />
	append - puts the link inside selector&#160;at the end<br />
	prepend - puts the link inside the selector at the beginning<br />
	after - puts it outside the selector after<br />
	before puts it outside the selector before</dd>
	<dt>mapUrl: <span class="default">&#39;https://maps.google.com/maps?q=&#39;</span></dt>
	<dd>This is the base for the URL of the map link. Mapilicious is set to use Google maps by default, but if for some odd reason you want to use something else, you can enter the URL with this option. Note the <code>?q=</code> at the end of the URL. This is the query string for Google. Other services would probably use something slightly different.</dd>
	<dt>linkText: <span class="default">&#39;Map&#39;</span></dt>
	<dd>This is the text used for the map link. It can be set to something else if you prefer different verbiage.</dd>
	<dt>linkTemplate: <span class="default">&lt;div class=&#34;mapilicious_map_link&#34;&gt;{link}&lt;/div&gt;</span></dt>
	<dd>This is how the link is wrapped. The <code>{link}</code> will be replaced with the actual link. If you only want the link appended and no wrapping markup, this can be set to an empty string or <code>false</code>.</dd>
	<dt>linkAttr: <span class="default">&#39;&#39;&#160;&#160;&#160;&#8212;empty</span></dt>
	<dd>This option gives the ability to add a string to the map link. This can be used to add classes, a target, or other html attributes.</dd>
</dl>

That's all folks. Issues? [Github it](https://github.com/rewdy/mapilicious/issues).