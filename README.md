RSSNewsFeed
===========

<p>
	<a href="https://github.com/doness/RSSNewsFeed/blob/master/UNLICENSE">
		<img src="https://camo.githubusercontent.com/5951551724a202929aa49ea19d5f6a1723ed63c4/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f6c6963656e73652d554e4c4943454e53452d626c75652e737667" alt="LICENSE" data-canonical-src="https://img.shields.io/badge/license-UNLICENSE-blue.svg" style="max-width:100%;">
	</a>
</p>

A simple RSS News Feed

Demo : <a href="https://ylp.runsas.com" target="_blank">Runsas News</a>

Supported
==========
<ul>
	<li><code>TheVerge</code></li>
	<li><code>TechCrunch</code></li>
	<li><code>GeekWire</code></li>
	<li><code>CNN</code></li>
	<li><code>Google News</code></li>
	<li><code>BBC</code></li>
	<li><code>CBN</code></li>
	<li><code>INQUISITR</code></li>
	<li><code>NASA</code></li>
	<li><code>Space</code></li>
	<li><code>CNET</code></li>
	<li><code>gHack</code></li>
	<li><code>Bloomberg</code></li>
	<li><code>TechinAsia</code></li>
	<li><code>more....</code></li>
</ul>

Requirements
============
<ul>
	<li>PHP 5.2 or higher</li>
	<li>MySQLi Support</li>
	<li>CURL Library</li>
	<li>multibyte functions mb_ functions</li>
</ul>

Setup CronJob
=============
<ol>
	<li>Cronjob login to your cpanel.</li>
	<li>Select the period from common setting for example (Twice Per Day) which means that the cron job will work two times every day.
Then Insert the Command that is responsible for Importing news from feed sources.</li>
	<li><code>php -q /home/YOUR-ACCOUNT/cron.php</code></li>
	<li>Finish</li>
</ol>