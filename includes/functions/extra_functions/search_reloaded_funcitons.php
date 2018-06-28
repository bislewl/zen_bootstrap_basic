<?php
/**
 * Credit to CodeIgniter
 * 
 * /system/helpers/inflector_helper.php
 */
 

/**
 * Singular
 *
 * Takes a plural word and makes it singular
 *
 * @access	public
 * @param	string
 * @return	str
 */
if ( ! function_exists('reloaded_singular'))
{
	function reloaded_singular($str)
	{
		$str = trim($str);
		$end = substr($str, -3);
        
        $str = preg_replace('/(.*)?([s|c]h)es/i','$1$2',$str);
        
		if (strtolower($end) == 'ies')
		{
			$str = substr($str, 0, strlen($str)-3).(preg_match('/[a-z]/',$end) ? 'y' : 'Y');
		}
		elseif (strtolower($end) == 'ses')
		{
			$str = substr($str, 0, strlen($str)-2);
		}
		else
		{
			$end = strtolower(substr($str, -1));

			if ($end == 's')
			{
				$str = substr($str, 0, strlen($str)-1);
			}
		}

		return $str;
	}
}

// --------------------------------------------------------------------

/**
 * Plural
 *
 * Takes a singular word and makes it plural
 *
 * @access	public
 * @param	string
 * @param	bool
 * @return	str
 */
if ( ! function_exists('reloaded_plural'))
{
	function reloaded_plural($str, $force = FALSE)
	{   
        $str = trim($str);
		$end = substr($str, -1);

		if (preg_match('/y/i',$end))
		{
			// Y preceded by vowel => regular plural
			$vowels = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');
			$str = in_array(substr($str, -2, 1), $vowels) ? $str.'s' : substr($str, 0, -1).'ies';
		}
		elseif (preg_match('/h/i',$end))
		{
            if(preg_match('/^[c|s]h$/i',substr($str, -2)))
			{
				$str .= 'es';
			}
			else
			{
				$str .= 's';
			}
		}
		elseif (preg_match('/s/i',$end))
		{
			if ($force == TRUE)
			{
				$str .= 'es';
			}
		}
		else
		{
			$str .= 's';
		}

		return $str;
	}
}

// --------------------------------------------------------------------

/**
 * Calculates variance of number from the mean
 * @param float number
 * @param float mean of population
 * @return float
 */
if( !function_exists('reloaded_sd_square') ){
    
    // Function to calculate square of value - mean
    function reloaded_sd_square($x, $mean) { return pow($x - $mean,2); }
    
}

// --------------------------------------------------------------------

/**
 * Calculate standard deviation
 * @param array of values in a population
 * @return float
 */
if( !function_exists('reloaded_sd') ){
    // Function to calculate standard deviation (uses sd_square)   
    function reloaded_sd($array) {
       
        // square root of sum of squares devided by N-1
        return sqrt(array_sum(array_map("reloaded_sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );
    }
}
// --------------------------------------------------------------------

