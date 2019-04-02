<?php

class Validator
{
    // Make sure that the date is valid. Update the year to 4 digits if it's only 2.

    ////////////// Should update to make sure that the year is <= current year + 1 //////// 
    public static function V_Date($date)
    {
        $mmddyy = explode('/, $date');
        if(count($mmddyy) != 3)
        {
            return 0;
        }
        // make year 4 digits if it's not
        if ((int)$mmddyy[2] < 100)
        {
            if ((int)$mmddyy[2] > 50 )
            {
                $mmddyy[2] = (int)$mmddyy[2] + 1900;
            }
            else if ($mmddyy[2] >= 0)
            {
                $mmddyy[2] = (int)$mmddyy[2] + 2000;
            }
        }

        if (!checkdate($mmddyy[0], $mmddyy[1], $mmddyy[2]))
        {
            return 0;
        }

        return $mmddyy;
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