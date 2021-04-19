<?php


namespace App\Http\Services;


use Cmixin\BusinessDay;
use Illuminate\Support\Carbon;

class CalculatorService
{
    private const CARBON_CLASS = 'Illuminate\Support\Carbon';
    private const BASE_LIST = 'us-national';

    private const LAST_DAY = 't';
    private const CURRENT_DAY = 'd';
    private const CURRENT_MONTH = 'm';
    private const CURRENT_YEAR = 'Y';

    private $businessDays;

    /**
     * CalculatorService constructor.
     * @access public
     *
     * @uses BusinessDay
     * @see CalculatorService::BASE_LIST
     * @see CalculatorService::CARBON_CLASS
     *
     * @return void
     */
    public function __construct()
    {
        $this->businessDays = BusinessDay::enable(self::CARBON_CLASS, self::BASE_LIST);
    }

    /**
     * Method returns a count of business days since today
     * For selected term
     * @access public
     *
     * @param int $months Contain a count of term months
     *
     * @see CalculatorService::CURRENT_DAY
     * @see CalculatorService::CURRENT_MONTH
     * @see CalculatorService::CURRENT_YEAR
     *
     * @uses Carbon
     * @uses Carbon::parse()
     * @uses Carbon::diffInBusinessDays()
     * @uses date()
     *
     * @return float|int
     */
    public function getDays ($months)
    {
        //Used to calculate how much months left
        $countOfMonths = $months;
        //Used to calculate a value of the Term last month
        $monthValue = $months;
        //get info about Current Date
        $currentDay = date(self::CURRENT_DAY);
        $currentMonth = date(self::CURRENT_MONTH);
        $currentYear = date(self::CURRENT_YEAR);

        //Decrement value to get Count of months without current
        $countOfMonths --;
        //Will represent a next year value
        $nextYear = $currentYear;


        //Get days in current month
        $workDays = Carbon::parse($currentYear . '-' . $currentMonth . '-' . $currentDay)
            ->diffInBusinessDays(Carbon::parse($currentYear . '-' . $currentMonth . '-' . date(self::LAST_DAY)));

        //if term bigger then current year
        if ($currentMonth + $countOfMonths > 12) {
            $monthsLeft = 12 - $currentMonth;
            $countOfMonths -= $monthsLeft;
            $monthValue -= $monthsLeft;
            //Calculate average value of business days in current Year
            $average =  Carbon::parse($nextYear . '-' . 1 . '-' . 1)->diffInBusinessDays( Carbon::parse($nextYear . '-' . 12 . '-' . 31)) / 12;
            //Multiply the average by the number of months remaining and add it to count of business days
            $workDays += $average * $monthsLeft;

            //We achieved a next Year that's why increment by 1
            $nextYear++;
        } else {
            //Calculate average value of business days in current Year
            $average =  Carbon::parse($nextYear . '-' . 1 . '-' . 1)->diffInBusinessDays( Carbon::parse($nextYear . '-' . 12 . '-' . 31)) / 12;
            //Multiply the average by the number of months remaining and add it to count of business days
            $workDays += $average * $countOfMonths;
        }

        //if we have a few months more
        while($countOfMonths > 0 ) {
            //If they are enough for full year
            if($countOfMonths >= 12) {
                $countOfMonths -= 12;
                $monthValue -= 12;
                //Add business days of year to total count
                $workDays += Carbon::parse($nextYear . '-' . 1 . '-' . 1)->diffInBusinessDays( Carbon::parse($nextYear . '-' . 12 . '-' . 31)) ;

                //Switch to next year
                $nextYear++;
            } else {
                //Calculate average value of business days in Year
                $average =  Carbon::parse($nextYear . '-' . 1 . '-' . 1)->diffInBusinessDays( Carbon::parse($nextYear . '-' . 12 . '-' . 31)) / 12;
                //Multiply the average by the number of months  and add it to count of business days
                $workDays+= $average * $countOfMonths;

                //No more months left
                $countOfMonths = 0;
            }
        }

        //Get days in last month and add it to count of business days
        $workDays += Carbon::parse($nextYear . '-' . $monthValue . '-' . 1)
            ->diffInBusinessDays(Carbon::parse($nextYear . '-' . $monthValue . '-' . ($currentDay+1))) ;

        return $workDays;
    }
}
