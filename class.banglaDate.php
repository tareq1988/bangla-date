<?php
/*
 * BanglaDate - English to Bangla date converter
 * @package BanglaDate
 * @author Tareq Hasan
 * @link http://tareq.weDevs.com
 * @copyright 2010 Tareq Hasan
 *
 *
 * Example of Use:
 *
 * Initialize/set the time:
 * $bn = new BanglaDate(strtotime('18-03-1988'), 0);
 * or
 * $bn = new BanglaDate(time(), 6);
 * or
 * $bn = new BanglaDate(time());
 *
 * Get Output
 * $output = $bn->get_date();
 * print_r($output);
 */

#**********************************************************************
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# ( at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# ERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Online: http://www.gnu.org/licenses/gpl.txt
# *****************************************************************

class BanglaDate {

    private $timestamp; //timestamp as input
    private $morning; //when the date will change?
    private $engHour; //Current hour of English Date
    private $engDate; //Current date of English Date
    private $engMonth; //Current month of English Date
    private $engYear; //Current year of English Date
    private $bangDate; //generated Bangla Date
    private $bangMonth; //generated Bangla Month
    private $bangYear; //generated Bangla   Year

    private $bn_months = array("পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র", "বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন", "কার্তিক", "অগ্রহায়ণ");
    private $bn_month_dates = array(30,30,30,30,31,31,31,31,31,30,30,30);
	private $bn_month_middate = array(13,12,14,13,14,14,15,15,15,15,14,14);	
	private $lipyearindex = 3;

    /*
     * Set the initial date and time
     *
     * @param   int timestamp for any date
     * @param   int, set the time when you want to change the date. if 0, then date will change instantly.
     *          If it's 6, date will change at 6'0 clock at the morning. Default is 6'0 clock at the morning
     */

    function __construct( $timestamp, $hour = 6 ) {
        $this->BanglaDate( $timestamp, $hour );
    }

    /*
     * PHP4 Legacy constructor
     */

    /**
     * @param int $timestamp
     * @param type $hour
     */
    function BanglaDate( $timestamp, $hour = 6 ) {
        $this->engDate = date( 'd', $timestamp );
        $this->engMonth = date( 'm', $timestamp );
        $this->engYear = date( 'Y', $timestamp );
        $this->morning = $hour;
        $this->engHour = date( 'G', $timestamp );

        //calculate the bangla date
        $this->calculate_date();

        //now call calculate_year for setting the bangla year
        $this->calculate_year();

        //convert english numbers to Bangla
        $this->convert();
    }

    function set_time( $timestamp, $hour = 6 ) {
        $this->BanglaDate( $timestamp, $hour );
    }

    /**
     * Calculate the Bangla date and month
     *
     * @access private
     */
    private function calculate_date() {		
		$this->bangDate = $this->engDate - $this->bn_month_middate[$this->engMonth - 1];
		if ($this->engHour < $this->morning) 
			$this->bangDate -= 1;
        
		if (($this->engDate <= $this->bn_month_middate[$this->engMonth - 1]) || ($this->engDate == $this->bn_month_middate[$this->engMonth - 1] + 1 && $this->engHour < $this->morning) ) {
			$this->bangDate += $this->bn_month_dates[$this->engMonth - 1];
			if ($this->is_leapyear() && $this->lipyearindex == $this->engMonth) 
				$this->bangDate += 1;
			$this->bangMonth = $this->bn_months[$this->engMonth - 1];
		}
		else{
			$this->bangMonth = $this->bn_months[($this->engMonth)%12];		
		}
    }

    /*
     * Checks, if the date is leapyear or not
     *
     * @return boolen. True if it's leap year or returns false
     */

    function is_leapyear() {
        if ( $this->engYear % 400 == 0 || ($this->engYear % 100 != 0 && $this->engYear % 4 == 0) )
            return true;
        else
            return false;
    }

    /*
     * Calculate the Bangla Year
     */

    function calculate_year() {
        $this->bangYear = $this->engYear - 593;
        if (($this->engMonth < 4) || (($this->engMonth == 4) && (($this->engDate < 14) || ($this->engDate == 14 && $this->engHour < $this->morning))))
            $this->bangYear -= 1;
    }

    /*
     * Convert the English character to Bangla
     *
     * @param int any integer number
     * @return string as converted number to bangla
     */

    function bangla_number( $int ) {
        $engNumber = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0);
        $bangNumber = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');

        $converted = str_replace( $engNumber, $bangNumber, $int );
        return $converted;
    }

    /*
     * Calls the converter to convert numbers to equivalent Bangla number
     */

    function convert() {
        $this->bangDate = $this->bangla_number( $this->bangDate );
        $this->bangYear = $this->bangla_number( $this->bangYear );
    }

    /*
     * Returns the calculated Bangla Date
     *
     * @return array of converted Bangla Date
     */

    function get_date() {
        return array($this->bangDate, $this->bangMonth, $this->bangYear);
    }

}
