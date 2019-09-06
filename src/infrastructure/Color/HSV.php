<?php


namespace eduslim\infrastructure\Color;


class HSV
{
    /** @var float */
    protected $hue; // range [0,360)

    /** @var float */
    protected $saturation; // range [0,1]

    /** @var float */
    protected $value; // range [0,1]

    function __construct( float $h, float $s, float $v )
    {
        $this->hue = $h;
        $this->saturation = $s;
        $this->value = $v;
    }

    function getRGB():?RGB
    {
        // Do it somehow
        return new RGB();
    }



    /**
     * @return float
     */
    public function getHue(): float
    {
        return $this->hue;
    }

    /**
     * @param float $hue
     */
    public function setHue(float $hue): void
    {
        $this->hue = $hue;
    }

    /**
     * @return float
     */
    public function getSaturation(): float
    {
        return $this->saturation;
    }

    /**
     * @param float $saturation
     */
    public function setSaturation(float $saturation): void
    {
        $this->saturation = $saturation;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }

}