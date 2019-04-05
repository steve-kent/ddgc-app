<?php

class Validator
{
    // Make sure that the date is valid. Update the year to 4 digits if it's only 2.

    ////////////// Should update to make sure that the year is <= current year + 1 //////// 
    public static function V_Date($date)
    {
        $ymd = explode('-', $date);
        if(count($ymd) != 3)
        {
            return 0;
        }
        // make year 4 digits if it's not
        if ((int)$ymd[0] < 100)
        {
            if ((int)$ymd[0] > 50 )
            {
                $ymd[0] = (int)$ymd[0] + 1900;
            }
            else if ($ymd[0] >= 0)
            {
                $ymd[0] = (int)$ymd[0] + 2000;
            }
        }

        if (!checkdate($ymd[2], $ymd[1], $ymd[0]))
        {
            return 0;
        }

        return 1;
    }

    // Used for radio and dropdowns. Makes sure the selection is a valid option.
    public static function V_Selection($selection, $options)
    {
        if (in_array($selection, $options, true))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public static function FormatOutput($inputString)
    {
        $outputString = nl2br(htmlentities($inputString, ENT_QUOTES, "UTF-8"));
        return $outputString;
    }
}