<?php

class Validator
{
    // Make sure that the date is valid. Update the year to 4 digits if it's only 2.

    ////////////// Should update to make sure that the year is <= current year + 1 //////// 
    public static function V_Date($date)
    {
        $dmy = explode('-', $date);
        if(count($dmy) != 3)
        {
            return 0;
        }
        // make year 4 digits if it's not
        if ((int)$dmy[0] < 100)
        {
            if ((int)$dmy[0] > 50 )
            {
                $dmy[0] = (int)$dmy[0] + 1900;
            }
            else if ($dmy[0] >= 0)
            {
                $dmy[0] = (int)$dmy[0] + 2000;
            }
        }

        if (!checkdate($dmy[1], $dmy[2], $dmy[0]))
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