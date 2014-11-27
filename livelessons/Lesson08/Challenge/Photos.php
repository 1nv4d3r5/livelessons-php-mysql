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

class Photo
{
    public $Format;
    public $Filename;
    public $FileSize;
    public $Dimensions;

    public function __construct($format, $fn, $size, $dimensions)
    {
        $this->Format = $format;
        $this->Filename = $fn;
        $this->FileSize = $size;
        $this->Dimensions = $dimensions;
    }

    public function resize($newdims)
    {
        $this->Dimensions = $newdims;
    }

    public function changeFormat($format)
    {
        $this->Format = $format;
    }

    public function debugPrint()
    {
        foreach ($this as $field => $value)
        {
            echo "<p><strong>$field</strong>: $value</p>\n";
        }
    }
}



?>