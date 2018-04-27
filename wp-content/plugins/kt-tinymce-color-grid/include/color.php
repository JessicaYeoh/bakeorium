<?php

if (!class_exists('kt_Color')) {

    /**
     * Color Conversion Madness
     *
     * @since 1.9
     */
    class kt_Color {

        protected $luma_transformations = array();

        public function add_luma_transformation($id, $name, $fn) {
            if ($this->has_luma_transformation($id) || !is_callable($fn)) {
                return false;
            }
            $this->luma_transformations[$id] = array($name, $fn);
        }

        public function has_luma_transformation($id) {
            return $id && isset($this->luma_transformations[$id]);
        }

        public function get_luma_transformation($id) {
            if ($this->has_luma_transformation($id)) {
                return $this->luma_transformations[$id];
            }
            return false;
        }

        public function get_luma_transformations($output = 'all') {
            switch ($output) {
                case 'ids': return array_keys($this->luma_transformations);
                case 'names':
                    $transformations = array();
                    foreach ($this->luma_transformations as $id => $transformation) {
                        $transformations[$id] = $transformation[0];
                    }
                    return $transformations;
            }
            return $this->luma_transformations;
        }

        public function default_luma_transformations() {
            $this->add_luma_transformation('sine', __('Sine', 'kt-tinymce-color-grid'), array($this, 'sine_luma'));
            $this->add_luma_transformation('cubic', __('Cubic', 'kt-tinymce-color-grid'), array($this, 'cubic_luma'));
            $this->add_luma_transformation('natural', __('Natural', 'kt-tinymce-color-grid'), array($this, 'natural_luma'));
        }

        /**
         * Apply a transformation on a linear float
         * @since 1.7
         * @param float $luma [-1..1]
         * @param string $type
         * @return float [-1..1]
         */
        public function transform_luma($luma, $type) {
            if (!$this->has_luma_transformation($type)) {
                return $luma;
            }
            list($name, $fn) = $this->get_luma_transformation($type);
            return call_user_func($fn, $luma, $name);
        }

        /**
         * Apply a sine transformation on a linear luma value.
         * @since 1.7
         * @param float $luma [-1..1]
         * @return float [-1..1]
         */
        public function sine_luma($luma) {
            return $luma < 0 ? sin((1 - $luma) * M_PI_2) - 1 : sin($luma * M_PI_2);
        }

        /**
         * Apply a cubic transformation on a linear luma value.
         * @since 1.7
         * @param float $luma [-1..1]
         * @return float [-1..1]
         */
        public function cubic_luma($luma) {
            return $luma < 0 ? pow(($luma + 1), 8 / 11) - 1 : pow($luma, 8 / 13);
        }

        /**
         * Apply a natural transformation on a linear luma value.
         * @since 1.7
         * @param float $luma [-1..1]
         * @return float [-1..1]
         */
        public function natural_luma($luma) {
            return $luma < 0 ? $this->sine_luma($luma) : $this->cubic_luma($luma);
        }

        /**
         * Apply a luma transformation on a RGB vector
         * @since 1.7
         * @param float $luma [-1..1]
         * @param array $rgb RGB vector [red, gree, blue] of [0..1]
         * @return array
         */
        public function apply_luma($luma, $rgb) {
            foreach ($rgb as $i => $c) {
                if ($luma < 0) {
                    $c += $c * $luma;
                } else if ($luma > 0) {
                    $c = $c == 0 ? $luma : $c + (1 - $c) * $luma;
                    $c = max(0, min($c, 1));
                }
                $rgb[$i] = $c;
            }
            return $rgb;
        }

        /**
         * Sanitize a string to RRGGBB
         * @since 1.4
         * @param string $string String to be checked
         * @return string|boolean Returns a color of RRGGBB or false on failure
         */
        public function sanitize_color($string) {
            $string = strtoupper($string);
            $hex = null;
            if (preg_match('~([0-9A-F]{6}|[0-9A-F]{3})~', $string, $hex)) {
                $hex = $hex[1];
                if (strlen($hex) == 3) {
                    return preg_replace('~[0-9A-F]~', '\1\1', $hex);
                }
                return $hex;
            }
            return false;
        }

        /**
         * Convert a float to a HEX string
         * @since 1.7
         * @param float $p [0..1]
         * @return string
         */
        public function float2hex($p) {
            return $this->int2hex($p * 255);
        }

        /**
         * Convert a integer to a HEX string
         * @since 1.9
         * @param int $i [0..255]
         * @return string
         */
        public function int2hex($i) {
            $s = dechex($i);
            return (strlen($s) == 1 ? '0' : '') . $s;
        }

        /**
         * Return a RGB vector for a hue
         * @since 1.7
         * @param float $hue [0..1]
         * @return array RGB vector [red, gree, blue] of [0..1]
         */
        public function hue2rgb($hue) {
            $hue *= 6;
            if ($hue < 1) {
                return array(1, $hue, 0);
            }
            if (--$hue < 1) {
                return array(1 - $hue, 1, 0);
            }
            if (--$hue < 1) {
                return array(0, 1, $hue);
            }
            if (--$hue < 1) {
                return array(0, 1 - $hue, 1);
            }
            if (--$hue < 1) {
                return array($hue, 0, 1);
            }
            return array(1, 0, 1 - --$hue);
        }

        /**
         * Convert a RGB vector to a HEX string
         * @since 1.9
         * @param array $rgb RGB vector [red, gree, blue] of [0..1]
         * @return string
         */
        public function rgb2hex($rgb) {
            if (!is_array($rgb)) {
                $rgb = func_get_args();
            }
            foreach ($rgb as $i => $x) {
                if ($x < 0 || $x > 1) {
                    return false;
                }
                $rgb[$i] = $this->int2hex($x * 255);
            }
            return implode('', $rgb);
        }

        /**
         * Convert a CMYK vector into a RGB vector
         * @since 1.9
         * @param array $cmyk [cyan, magenta, yellow, black] of [0..1]
         * @return array [red, gree, blue] of [0..1]
         */
        public function cmyk2rgb($cmyk) {
            $rgb = array();
            for ($i = 0; $i < 3; $i++) {
                $rgb[$i] = (1 - $cmyk[$i]) * (1 - $cmyk[3]);
            }
            return $rgb;
        }

        /**
         * Convert CMYK vector into a HEX string
         * @since 1.9
         * @param array $cmyk [cyan, magenta, yellow, black] of [0..1]
         * @return string
         */
        public function cmyk2hex($cmyk) {
            return $this->rgb2hex($this->cmyk2rgb($cmyk));
        }

        /**
         * Multiply a three component (column) vector and a 3x3 matrix
         * @param array $v
         * @param array $M
         * @return array
         */
        protected function transform_vector($v, $M) {
            foreach ($M as $i => $m) {
                $v[$i] = $v[0] * $m[0] + $v[1] * $m[1] + $v[2] * $m[2];
            }
            return $v;
        }

        /**
         * Convert a XYZ vector into a RGB vector
         *
         * @since 1.9
         * @link http://www.brucelindbloom.com/Eqn_XYZ_to_RGB.html
         *
         * @param array $xyz XYZ vector
         * @return array RGB vector [red, gree, blue] of [0..1]
         */
        public function xyz2rgb($xyz) {
            # XYZ to linear RGB
            $rgb = $this->transform_vector($xyz, array(
                array(3.2404542, -1.5371385, -.4985314),
                array(-.9692660, 1.8760108, .0415560),
                array(.0556434, -.2040259, 1.0572252)
            ));

            # sRGB companding
            foreach ($rgb as $i => $c) {
                $rgb[$i] = $c <= .0031308 ? 12.92 * $c : 1.055 * pow($c, 2.4) - .055;
            }
            return $rgb;
        }

        /**
         * Convert a Lab vector into a XYZ vector.
         *
         * It uses CIEXYZ D65 as white point reference.
         *
         * @since 1.9
         * @link http://www.brucelindbloom.com/Eqn_Lab_to_XYZ.html
         *
         * @param array $lab Lab vector [0..1, 0..1, 0..1]
         * @return array XYZ vector [0..1, 0..1, 0..1]
         */
        public function lab2xyz($lab) {
            list($xw, $yw, $zw) = array(.9504, 1, 1.0888);
            list($L, $a, $b) = $lab;
            $fy = ($L + 16) / 116;
            $fz = $fy - $b / 200;
            $fx = $a / 500 + $fy;
            $fx3 = pow($fx, 3);
            $fz3 = pow($fz, 3);
            $xr = $fx3 > (216 / 24389) ? $fx3 : (116 * $fx - 16) / (24389 / 27);
            $yr = $L > 9 ? pow(($L + 16) / 116, 3) : $L / (24389 / 27);
            $zr = $fz3 > (216 / 24389) ? $fz3 : (116 * $fz - 16) / (24389 / 27);
            return array($xr * $xw, $yr * $yw, $zr * $zw);
        }

        /**
         * Convert a Lab vector into a RGB vector
         * @since 1.9
         * @param array $lab Lab vector [0..1, 0..1, 0..1]
         * @return array RGB vector [red, gree, blue] of [0..1]
         */
        public function lab2rgb($lab) {
            return $this->xyz2rgb($this->lab2xyz($lab));
        }

        /**
         * Convert a Lab vector into a HEX string
         * @since 1.9
         * @param array $lab Lab vector [0..1, 0..1, 0..1]
         * @return string
         */
        public function lab2hex($lab) {
            return $this->rgb2hex($this->lab2rgb($lab));
        }

        /**
         * Convert a grayscale float into a HEX string
         * @since 1.9
         * @param float $gray [0..1]
         * @return string
         */
        public function gray2hex($gray) {
            $g = $this->float2hex($gray);
            return "$g$g$g";
        }

        /**
         * Convert a HSV/HSB vector into a RGB vector
         *
         * @since 1.9
         * @link https://de.wikipedia.org/wiki/HSV-Farbraum#Umrechnung_HSV_in_RGB
         *
         * @param array $hsv HSV vector [hue, saturation, value/brightness] of [0..1]
         * @return array
         */
        public function hsv2rgb($hsv) {
            list($h, $s, $v) = $hsv;
            if ($s == 0) {
                return array($v, $v, $v);
            }
            $h *= 6;
            if ($h == 6) {
                $h = 0;
            }
            $f = $h - floor($h);
            $p = $v * (1 - $s);
            $q = $v * (1 - ($s * $f));
            $t = $v * (1 - ($s * (1 - $f)));
            switch ($t) {
                case 0: return array($v, $t, $p);
                case 1: return array($q, $v, $p);
                case 2: return array($p, $v, $t);
                case 3: return array($p, $q, $v);
                case 4: return array($t, $p, $v);
                default:return array($v, $p, $q);
            }
        }

        /**
         * Convert a HSV/HSB vector into a HEX string
         * @since 1.9
         * @param array $hsv [0..1, 0..1, 0..1]
         * @return string
         */
        public function hsv2hex($hsv) {
            return $this->rgb2hex($this->hsv2rgb($hsv));
        }

    }

}