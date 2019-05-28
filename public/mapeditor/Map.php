<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 12.01.2019
 * Time: 12:48
 */

namespace Map {
    require_once $_SERVER['DOCUMENT_ROOT'].'/lib/main/Data.php';
use Main\Data;
use User\User;

    class Map
    {
        const debug = true;

        /**
         * @var \eSafeMySQL
         */
        protected $db;

        /**
         * @var User
         */
        protected $creator; // User - creator

        protected $name;

        protected $map = []; // Array of cells
        protected $clans = []; //Array of bases positions

        public function clansN(){
            return count($this->clans);
        }

        protected $mapStr;

        /**
         * @param \eSafeMySQL $db
         */
        public function setDb($db)
        {
            $this->db = $db;
        }

        /**
         * @param string $name
         */
        public function setName($name)
        {
            $this->name = $name;
        }

        /**
         * @param User $creator
         */
        public function setCreator($creator)
        {
            $this->creator = $creator;
        }

        public function save()
        {
            $db = $this->db;

            $sql = 'INSERT INTO maps ( name, map, creator ) VALUES (?s, ?s, ?i)';
            $res = $db->query($sql, $this->name, $this->mapStr, $this->creator->getId());
            if (!$res) {
                return new Data([
                    'errText' => 'Database error',
                    'errCode' => 501,
                    'response' => $db->getStats(),
                ]);
            }

            return new Data();
        }

        function draw( )
        {
            $maxmins = $this->GetMaxMin();
            $X = $maxmins[0];
            $Y = $maxmins[1];
            $isLCE = 2*$this->LeftColTest();
            $isRCE = 2*$this->RightColTest();

            // 1. Создать "холст" для карты размерами (maxX - minX)*3 + 1 , аналогично для Y ( +  пикселя)
            $im = imagecreatetruecolor( ($X[1] - $X[0] + 1)*4+3-$isLCE-$isRCE, ($Y[1] - $Y[0] + 1)*4+1);
            //imagefill($im, 0, 0, imagecolorallocatealpha($im, 255, 255, 255, 127));
            //echo ((($X[1] - $X[0] + 1)*4+3)." , ".(($Y[1] - $Y[0] + 1)*4+1)."\n");
            // 1,5. Поставить цвета для прямоугольников
            $colors = array(
                imagecolorallocate($im, 195, 195, 195),  // $grey
                imagecolorallocate($im, 128, 0  , 255), // $purple
                imagecolorallocate($im, 237, 28 , 36 ), // $red
                imagecolorallocate($im, 255, 255, 0  ), // $yellow
                imagecolorallocate($im, 0  , 255, 64 ), // $green
                imagecolorallocate($im, 0  , 255, 255), // $cyan
                imagecolorallocate($im, 0  , 128, 255), // $blue
            );
            // 2. Цикл рисовки прямоугольничков
            foreach ($this->map as $i => $mapI) {
                foreach ($mapI as $j => $mapJ) {
                    $isOdd = ($j & 1)*2;
                    imagefilledrectangle($im,($i-$X[0])*4+$isOdd-$isLCE,($j-$Y[0])*4,($i-$X[0])*4+4+$isOdd-$isLCE,($j-$Y[0])*4+4,imagecolorallocate($im, 155, 155, 155));
                    imagefilledrectangle($im,($i-$X[0])*4+1+$isOdd-$isLCE,($j-$Y[0])*4+1,($i-$X[0])*4+3+$isOdd-$isLCE,($j-$Y[0])*4+3,$colors[$mapJ[0]]);
                }
            }

            // Сохраняем изображение в 'simpletext.jpg'
            imagepng($im, $_SERVER['DOCUMENT_ROOT'].'/images/maps/'.$this->name.'.png'); //
            imagedestroy($im);

            unset($mapI,$mapJ,$i,$j);
        }

        protected function findBases()
        {
            $baseStrok = "";
            $colorStrok = "";

            if(!$this->map) return "";
            foreach ($this->map as $i => $mapI) {
                foreach ($mapI as $j => $mapJ) {
                    if($mapJ[1] == 7 && $mapJ[0] != 0){
                        $baseStrok .= '|'.$i.','.$j;
                        $colorStrok .= '|'.$mapJ[0];
                    }
                }
            }
            unset($mapI,$mapJ,$i,$j);

            return [$baseStrok, $colorStrok];
        }

        public function StrToMap ( $str )
        {
            $this->mapStr = $str;
            $this->map = array();

            $MapXraw = explode('"', $str); // ("x|y;type;type|y;type;type|...","x|y;type;type")
            foreach ($MapXraw as $value) {
                $xTrash = explode('|', $value); // ("x", "y;type;type", "y;type;type", ...)

                $x = intval($xTrash[0], 10);
                if($x == 0) continue;
                $this->map += [ $x => array() ];
                $xTrashLenght = count($xTrash);
                for ($i=1; $i < $xTrashLenght ; $i++) {
                    $hex = explode(';',$xTrash[$i]); // ("y", "type", "type")
                    $y = intval($hex[0], 10);
                    $this->map[$x] += [ $y => array($hex[1],$hex[2]) ];
                }

            }

        }

        protected function GetMaxMin()
        {
            $LUcorner = array(0,0); $firstIt = true;
            $RDcorner = array(0,0);

            foreach ($this->map as $i => $mapI) {
                if($firstIt) $LUcorner[0] = $i;
                $LUcorner[1] = $i;
                foreach ($mapI as $j => $mapJ) {
                    if($RDcorner[0] > $j || $firstIt) $RDcorner[0] = $j;
                    if($RDcorner[1] < $j) $RDcorner[1] = $j;
                    $firstIt = false;
                }
            }

            unset($mapI,$mapJ,$j);

            return array($LUcorner,$RDcorner);
        }

        protected function LeftColTest()
        {
            $mapI = reset($this->map);

            foreach ($mapI as $j => $mapJ) {
                if(!($j & 1)) {
                    return 0;
                }
            }

            unset($mapI,$mapJ,$j);
            return 1;
        }

        protected function RightColTest()
        {
            $mapI = end($this->map);

            foreach ($mapI as $j => $mapJ) {
                if(!($j & 1)) {
                    return 1;
                }
            }

            unset($mapI,$mapJ,$j);
            return 0;
        }

    }
}