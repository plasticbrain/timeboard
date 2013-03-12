/* Copyright (c) 2009 José Joaquín Núñez (josejnv@gmail.com) http://joaquinnunez.cl/blog/
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-2.0.php)
 * Use only for non-commercial usage.
 *
 * Version : 0.1
 *
 * Requires: jQuery 1.2+
 */

(function(jQuery) {
  jQuery.fn.clock = function(options) {
    var defaults = {
      offset: '+0',
      type: 'analog',
      showSeconds: true,
      showMeridiem: true
    };
    var _this = this;
    var opts = jQuery.extend(defaults, options);

    if( !opts.showSeconds ) {
      jQuery(_this).find(".sec, .separator.seconds").remove();
    }

    if( !opts.showMeridiem ) {
      jQuery(_this).find(".meridiem").remove();
    }

    setInterval( function() {
      var seconds = jQuery.calcTime(opts.offset).getSeconds();
      seconds = ('0' + seconds).slice(-2);
      if(opts.type=='analog')
      {
        var sdegree = seconds * 6;
        var srotate = "rotate(" + sdegree + "deg)";
        jQuery(_this).find(".sec").css({"-moz-transform" : srotate, "-webkit-transform" : srotate});
      }
      else if( opts.showSeconds )
      {
        jQuery(_this).find(".sec").html( seconds);
      }
    }, 1000 );

    setInterval( function() {
      var hours = jQuery.calcTime(opts.offset).getHours();
      var origHours = hours;
      var mins = jQuery.calcTime(opts.offset).getMinutes();
      if(opts.type=='analog')
      {
        var hdegree = hours * 30 + (mins / 2);
        var hrotate = "rotate(" + hdegree + "deg)";
        jQuery(_this).find(".hour").css({"-moz-transform" : hrotate, "-webkit-transform" : hrotate});
      }
      else
      {
        hours=(hours > 12) ? hours-12 : hours;
        hours=(hours == 0) ? 12 : hours;
        jQuery(_this).find(".hour").html(hours);
      }
      var meridiem = origHours < 12 ? 'AM' : 'PM';
      jQuery(_this).parents('div.module').removeClass('AM').removeClass('PM').addClass(meridiem)
      if( opts.showMeridiem ) {
        jQuery(_this).find('.meridiem').html(meridiem);
      }
    }, 1000 );

    setInterval( function() {
      var mins = jQuery.calcTime(opts.offset).getMinutes();
      if(opts.type=='analog')
      {
        var mdegree = mins * 6;
        var mrotate = "rotate(" + mdegree + "deg)";        
        jQuery(_this).find(".min").css({"-moz-transform" : mrotate, "-webkit-transform" : mrotate});                
      }
      else
      {
        jQuery(_this).find(".min").html( ('0' + mins).slice(-2) );
      }
    }, 1000 );
  }
})(jQuery);


jQuery.calcTime = function(offset) {

  // create Date object for current location
  d = new Date();

  // convert to msec
  // add local time zone offset
  // get UTC time in msec
  utc = d.getTime() + (d.getTimezoneOffset() * 60000);

  // create new Date object for different city
  // using supplied offset
  nd = new Date(utc + (3600000*offset));

  // return time as a string
  return nd;
};
