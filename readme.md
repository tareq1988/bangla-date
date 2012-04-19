# Bangla Date PHP Class #
******************

A PHP Class to convert English dates to equivalent Bangla date.

e.g: 02-03-2012 converts to ১৯ ফাল্গুন ১৪১৮

> According to Bangla culture, the date changes not after 12'o clock at night, but it changes after sun rise at morning.

## Class Constructor
***
It has 2 parameter. The first parameter is a **date timestamp**. If you want to change the date after 12 AM (just like English dates), you have to pass the second as **0**. The default is **6**.

so if you don't pass anything as 2nd parameter, the date will change at 6'o clock at morning.

# Usage
***

### Current Date
    $bn_date = new BanglaDate( time() );
    $date = $bn_date->get_date();


### A particular Date
    $bn_date = new BanglaDate( strtotime('18-03-1988') );
    $date = $bn_date->get_date();

### Single object, multiple convert
    $bn = new BanglaDate(time());
    $date = $bn->get_date();
    var_dump( $date );

    //another
    $bn->set_time(time(), 0);
    $date = $bn->get_date();
    var_dump( $date );

    //another
    $bn->set_time(strtotime('18-03-1988'), 0);
    $date = $bn->get_date();
    var_dump( $date );

## On PHPClasses.org
The class is also in [phpclasses.org](http://www.phpclasses.org/browse/package/6120.html)

## Blog Post
Original link to the [release post](http://tareq.wedevs.com/2010/04/bangla-date-as-a-php-class/)
