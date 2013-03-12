Timeboard
=========

Display the time in multiple timezones.

Demo: [http://mikeeverhart.net/timeboard](http://mikeeverhart.net/timeboard)

![Screenshot](http://mikeeverhart.net/timeboard/screenshot.png)


Setup and Configuration
=======================

1. Clone this repository: `git clone git@github.com:plasticbrain/timeboard.git`
2. Edit `config.php`:
	* Change `define('HOME', 'http://domain.com/timeboard/')` to the correct URL
3. Make sure that `assets/cache/` is writable 
	* If your permissions are correct you should be able to `chmod` to [no more than] 775
	* If that doesn't work, and you're totally careless, then `chmod 777`
4. Define your clocks in `clocks.xml` (see below)


Adding Clocks
=====================	

**Prototype**

	<clock>
		<location>Memphis</location>
		<timezone>America/Chicago</timezone>
		<showseconds>false</showseconds>
		<showmeridiem>true</showmeridiem>
	</clock>

* `<location>` - The name of the location (this is the name that gets displayed)
* `<timezone>` - The timezone of the location according to [http://php.net/manual/en/timezones.php](http://php.net/manual/en/timezones.php)
* `<showseconds>` - [true/false] show seconds?
* `<showmeridiem>` - [true/false] show AM/PM?


Credits
======================

[Bootstrap](http://twitter.github.com/bootstrap/)

[jQuery Clock](http://joaquinnunez.cl/jquery-clock-plugin/) (Modified)

Timeboard was inspired by a good [friend and business associate](http://spinikr.com) 

