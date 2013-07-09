/*

Title: Bible Bookmarklet
Author: Andrew Meyer
Description: A bookmarklet that lets you look up Bible references quickly and easily.
Date: 20110720

*/

I am a huge fan of bookmarklets. In fact, I’m sort of passionate about them. I have a whole folder of bookmarks in my browser that is just filled with bookmarklets. Recently, I’ve come across a need for a new bookmarklet that looks up Bible references on web pages and I thought I’d try my hand at creating one of my own. So I did.

Here’s what it does: If you see a Bible reference that you want to look up, you can select it and click the bookmarklet and it will open up the passage on Bible Gateway. If you don’t have anything selected, it will ask you what you want to look up. Pretty simple.

Here it is (drag the link to your bookmarks toolbar to save):

<p><a href="javascript:(function(){ref=document.getSelection();if (ref!=''){window.location='http://www.biblegateway.com/quicksearch/?quicksearch='+ref;}else{ref=prompt('What do you want to look up?'); if (ref!=null &amp;&amp; ref!=''){window.location='http://www.biblegateway.com/quicksearch/?quicksearch='+ref;}}})()">Bible Link</a> (opens in the same window/tab)</p>

<p><a href="javascript:(function(){ref=document.getSelection();if (ref!=''){window.open('http://www.biblegateway.com/quicksearch/?quicksearch='+ref,'','');}else{ref=prompt('What do you want to look up?'); if (ref!=null &amp;&amp; ref!=''){window.open('http://www.biblegateway.com/quicksearch/?quicksearch='+ref,'','');}}})()">Bible Link</a> (opens in new window/tab)</p>


It works only in Firefox and the webkit browsers (Chrome and Safari). Sorry IE users :(.
For a test, you can highlight this passage and click the bookmarklet: John 3:16