<?php


namespace eduslim\infrastructure\Color;


class RGB
{
    static $scale = 255;

    /** @var int */
    protected $r;

    /** @var int */
    protected $g;

    /** @var int */
    protected $b;

    public function __construct( int $r=0, int $g=0, int $b=0 )
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
    }

    public function getHSV():HSV
    {
        $r = $this->r / self::$scale;
        $g = $this->g / self::$scale;
        $b = $this->b / self::$scale;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        $delta = $max - $min;

        $h = $s = 1.0;

        $v = $max * 1.0;

        if( $max == 0 ){
            $h = 0;
            $s = 0;
        } else {
            $s = $delta/$max;
            if ($delta == 0) {
                $h = NAN;
            }

            switch ($max){
                case $r:
                    $h = (60*($g - $b)/$delta + 360) % 360;
                    break;
                case $g:
                    $h = (60*($b - $r)/$delta + 120) % 360;
                    break;
                case $b:
                    $h = (60*($r - $g)/$delta + 240) % 360;
                    break;
            }

        }

        return new HSV($h, $s, $v);
    }

    // input : ff0000 (like that)
    public function getFromHEX(string $s){
        $s = strtolower($s); // if there are big FF;
        $int = hexdec($s);

        $rgb = [];
        for( $i=0 ; $i < 3 ; $i++){
            $rgb[$i] = ($int & 255) ;
            $int = $int >> 8;
        }

        $this->r = $rgb[2];
        $this->g = $rgb[1];
        $this->b = $rgb[0];
    }

    public function __toString():string
    {
        // TODO: Implement __toString() method.

        $num =             $this->r;
        $num = $num << 8 + $this->g;
        $num = $num << 8 + $this->b;

        return dechex($num);
    }

    /**
     * @return int
     */
    public function getR(): int
    {
        return $this->r;
    }

    /**
     * @param int $r
     */
    public function setR(int $r): void
    {
        $this->r = $r;
    }


    /**
     * @return int
     */
    public function getG(): int
    {
        return $this->g;
    }

    /**
     * @param int $g
     */
    public function setG(int $g): void
    {
        $this->g = $g;
    }


    /**
     * @return int
     */
    public function getB(): int
    {
        return $this->b;
    }

    /**
     * @param int $b
     */
    public function setB(int $b): void
    {
        $this->b = $b;
    }


}