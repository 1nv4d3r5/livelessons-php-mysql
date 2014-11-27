<?php



function power_of($base, $exponent)
{
    $result = $base;
    while ($exponent > 1)
    {
        $result = $result * $base;
        $exponent--;
    }

    return $result;
}



function babylonian_square_root($value)
{
    $value = abs($value);  // no negative sqrts!
    $guess = $value / 2;
    for ($x = 0; $x < 5; $x++)
        $guess = 0.5 * ($guess + ($value / $guess));

    return $guess;
}



?>