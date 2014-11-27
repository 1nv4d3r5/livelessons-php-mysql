<?php


/**
 * Photos have the following information
 *
 * 'Format'   'JPEG', 'GIF', 'PNG', 'TIFF', 'BMP', etc ...
 * 'Filename'
 * 'FileSize'
 * 'Dimensions'  '1600x1200', etc...
 *
 * For the various "operations" we provide here, we'll not actually do the
 * image operation, but instead just provide some skeleton functions so you
 * get comfortable working with the concepts.
 */


function photo_create($format, $fn, $size, $dimensions)
{
    return array('Format' => $format, 'Filename' => $fn,
                 'FileSize' => $size, 'Dimensions' => $dimensions);
}



function photo_resize(&$photo, $newdims)
{
    $photo['Dimensions'] = $newdims;
}


function photo_change_format(&$photo, $format)
{
    $photo['Format'] = $format;
}


function photo_print($photo)
{
    foreach ($photo as $field => $value)
    {
        echo "<p><strong>$field</strong>: $value</p>\n";
    }
}


?>