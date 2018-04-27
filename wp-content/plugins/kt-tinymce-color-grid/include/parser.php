<?php

if (!class_exists('kt_Palette_Parser')) {

    /**
     * Holds methods for parsing third party color palette files.
     *
     * @since 1.9
     */
    class kt_Palette_Parser {

        const DEBUG = 0;

        protected $XML;
        protected $parser = array();
        protected $error = array();
        protected $id = null;

        /**
         *
         * @var kt_Palette_Parser
         */
        protected static $Instance;

        /**
         * Singleton Design
         * @return kt_Palette_Parser
         */
        public static function instance() {
            if (!self::$Instance) {
                self::$Instance = new self();
            }
            return self::$Instance;
        }

        /**
         * Traditional HEX dump
         * @since 1.9
         * @author mindplay.dk at https://stackoverflow.com/a/4225813
         * @param mixed $data Input data
         * @param string $newline Defaults to \n
         */
        static function hex_dump($data, $newline = "\n") {
            static $from = '';
            static $to = '';

            static $width = 16; # number of bytes per line

            static $pad = '.'; # padding for non-visible characters

            if ($from === '') {
                for ($i = 0; $i <= 0xFF; $i++) {
                    $from .= chr($i);
                    $to .= ($i >= 0x20 && $i <= 0x7E) ? chr($i) : $pad;
                }
            }

            $hex = str_split(bin2hex($data), $width * 2);
            $chars = str_split(strtr($data, $from, $to), $width);

            $offset = 0;
            foreach ($hex as $i => $line) {
                echo sprintf('%6X', $offset) . ' : ' . implode(' ', str_split($line, 2)) . ' [' . $chars[$i] . ']' . $newline;
                $offset += $width;
            }
        }

        /**
         * Add a parser.
         *
         *
         *
         * @since 1.9
         * @param string $id
         * @param string|array $arg
         * @return boolean
         */
        public function add($id, $arg) {
            if ($this->has($id)) {
                return false;
            }
            $parser = wp_parse_args($arg, array(
                'name' => ucfirst($id),
            ));
            if (!isset($parser['ext']) || !isset($parser['parse']) || !is_callable($parser['parse'])) {
                return false;
            }
            $parser['ext'] = strtolower($parser['ext']);
            if (isset($parser['error'])) {
                if (is_array($parser['error'])) {
                    $this->error += $parser['error'];
                }
                unset($parser['error']);
            }
            $this->parser[$id] = $parser;
            return true;
        }

        /**
         * Check if parser exists
         * @since 1.9
         * @param string $id
         * @return boolean
         */
        public function has($id) {
            return isset($this->parser[$id]);
        }

        /**
         * Remove a parser by id
         * @since 1.9
         * @param string $id
         * @return boolean
         */
        public function remove($id) {
            if ($this->has($id)) {
                unset($this->parser[$id]);
                return true;
            }
            return false;
        }

        /**
         * Get a parser by id
         * @since 1.9
         * @param string $id
         * @return array
         */
        public function get($id) {
            if ($this->has($id)) {
                return $this->parser[$id];
            }
            return null;
        }

        /**
         * Return all parser
         * @since 1.9
         * @return array
         */
        public function all() {
            return $this->parser;
        }

        /**
         * Return number of parser
         * @since 1.9
         * @return int
         */
        public function count() {
            return count($this->parser);
        }

        /**
         * Parse a file
         * @since 1.9
         * @param string $file Entry of $_FILES
         * @return boolean|string|array
         */
        public function parse($file) {
            $this->id = null;
            foreach ($this->parser as $id => $parser) {
                $ext = strtolower(substr($file['name'], -strlen($parser['ext']) - 1));
                if ($ext != '.' . $parser['ext']) {
                    continue;
                }
                $palette = call_user_func($parser['parse'], $file['tmp_name']);
                if (!$palette) {
                    continue;
                }
                $this->id = $id;
                return $palette;
            }
            return false;
        }

        /**
         * Get id of last run parser
         * @return string|null
         */
        public function id() {
            return $this->id;
        }

        /**
         * Get name of last run parser
         * @return string
         */
        public function name($id) {
            $parser = $this->get($id);
            return $parser ? $parser['name'] : '';
        }

        /**
         * Return a error message for a status code.
         * @since 1.9
         * @param string $status
         * @param string $default [optional]
         * @return string
         */
        public function error_message($status, $default = '') {
            return isset($this->error[$status]) ? $this->error[$status] : $default;
        }

        /**
         * Add default palette parser.
         * @since 1.9 Support added for aco, ase, gpl, soc, Expression, Scribus, pal, cs and skechpalette
         */
        public function default_parser() {
            $unsupported = __('The %s file can not be imported. Its version is not supported.', 'kt-tinymce-color-grid');
            $corrupt = __('The %s file can not be imported because it is damaged.', 'kt-tinymce-color-grid');
            $this->add('adobe-aco', array(
                'name' => 'Adobe Color Swatch',
                'ext' => 'aco',
                'parse' => array($this, 'parse_aco'),
                'error' => array(
                    'aco-unsupported' => sprintf($unsupported, 'Adobe Color Swatch'),
                    'aco-corrupt' => sprintf($corrupt, 'Adobe Color Swatch'),
                ),
            ));
            $this->add('adobe-ase', array(
                'name' => 'Adobe Swatch Exchange',
                'ext' => 'ase',
                'parse' => array($this, 'parse_ase'),
                'error' => array(
                    'ase-unsupported' => sprintf($unsupported, 'Adobe Swatch Exchange'),
                    'ase-corrupt' => sprintf($corrupt, 'Adobe Swatch Exchange'),
                ),
            ));
            $this->add('gimp', array(
                'name' => 'Gimp / Inkscape',
                'ext' => 'gpl',
                'parse' => array($this, 'gimp_parse'),
            ));
            $this->add('openoffice', array(
                'name' => 'OpenOffice',
                'ext' => 'soc',
                'parse' => array($this, 'parse_openoffice'),
            ));
            $this->add('ms-expression', array(
                'name' => 'Expression',
                'ext' => 'xml',
                'parse' => array($this, 'parse_ms_expression'),
            ));
            $this->add('scribus', array(
                'name' => 'Scribus',
                'ext' => 'xml',
                'parse' => array($this, 'parse_scribus'),
            ));
            $this->add('jasc-pal', array(
                'name' => 'Jasc / Corel Paint Shop Pro',
                'ext' => 'pal',
                'parse' => array($this, 'parse_pal'),
            ));
            $this->add('colorschemer', array(
                'name' => 'ColorSchemer',
                'ext' => 'cs',
                'parse' => array($this, 'parse_cs'),
                'error' => array(
                    'cs-corrupt' => sprintf($corrupt, 'ColorSchemer')
                )
            ));
            $this->add('sketch', array(
                'name' => 'Sketch Palette',
                'ext' => 'sketchpalette',
                'parse' => array($this, 'parse_sketch'),
            ));

            # As soon as Paletton.com exports valid XML support will be added
            /* $this->add('paletton', array(
              'name' => 'Paletton',
              'ext' => 'xml',
              'parse' => array($this, 'parse_paletton'),
              )); */
        }

        /**
         * Check if a path is a XML file.
         *
         * Additionally you can check if the file has a specific namespace or if<br>
         * its root element has a specific name.
         *
         * @since 1.9
         * @param string $path Path to check
         * @param string $check [optional] xmlns with optional name, or root
         * @param string $value [optional] Value to check against
         * @return boolean
         */
        protected function is_xml($path, $check = null, $value = null) {
            if (!class_exists('DOMDocument')) {
                return false;
            }
            $this->XML = new DOMDocument('1.0', 'UTF-8');
            if (!$this->XML->load($path, LIBXML_NOBLANKS)) {
                return false;
            }
            if (preg_match('~^xmlns~', $check)) {
                return $this->XML->firstChild->getAttribute($check) == $value;
            }
            switch ($check) {
                case 'root': return $this->XML->firstChild->nodeName == $value;
            }
            return true;
        }

        /**
         * Convert a string between character encodings.
         *
         * Does not throw errors. If the iconv extension is not available or the<br>
         * iconv function fails, the input string will be returned unaltered.
         *
         * @since 1.9
         * @param string $in_charset Charset of the input string
         * @param string $out_charset Charset of the output string
         * @param string $str Input string
         * @return string
         */
        protected static function iconv($in_charset, $out_charset, $str) {
            if ($in_charset == $out_charset || !function_exists('iconv')) {
                return $str;
            }
            $iconv = @iconv($in_charset, $out_charset . '//TRANSLIT', $str);
            if ($iconv === false) {
                return $str;
            }
            return $iconv;
        }

        /**
         * Read a 16bit big-endian string from a file stream.
         *
         * String will be passed through sanitize_text_field.
         *
         * @since 1.9
         * @param resource $file File resource
         * @param int $bytes [optional] Number of bytes holding the string's length, default 2
         * @param string $format [optional] Format of these bytes, default 'n'
         * @return string
         */
        protected static function fread_str16be($file, $bytes = 2, $format = 'n') {
            $len = self::funpack($file, $bytes, $format);
            $str = self::fread($file, $len * 2);
            $str = self::iconv('UTF-16', 'UTF-8', $str);
            return sanitize_text_field($str);
        }

        /**
         * Read a 8bit lower-endian string from a file stream.
         *
         * String will be passed through sanitize_text_field.
         *
         * @since 1.9
         * @param resource $file File resource
         * @param int $bytes [optional] Number of bytes holding the string's length, default 2
         * @param string $format [optional] Format of these bytes, default 'v'
         * @return string
         */
        protected static function fread_str8le($file, $bytes = 2, $format = 'v') {
            $len = self::funpack($file, $bytes, $format);
            $str = self::fread($file, $len);
            return sanitize_text_field($str);
        }

        /**
         * Read 32bit big-endian float(s) from a file stream.
         * @param resource $file File resource
         * @param int $count [optional] Number of floats to read, default 3
         * @return float|array
         */
        protected static function fread_float32be($file, $count = 3) {
            if ($count < 1) {
                return array();
            }
            $floats = array();
            while ($count--) {
                $float32 = strrev(self::fread($file, 4));
                $floats[] = self::unpack('f', $float32);
            }
            return $floats;
        }

        /**
         * Read bytes from a file stream and unpack them.
         *
         * If format will yield just one value it will be returned instead of an array.<br>
         * Array indices are corrected to begin with 0 for compatibility with list().
         *
         * @since 1.9
         * @param resource $file File resource
         * @param int $bytes Number of bytes to read
         * @param string $format Format codes
         * @return array|mixed
         */
        protected static function funpack($file, $bytes, $format) {
            $buffer = self::fread($file, $bytes);
            return self::unpack($format, $buffer);
        }

        /**
         * Unpack binary data.
         *
         * If format will yield just one value it will be returned instead of an array.<br>
         * Array indices are corrected to begin with 0 for compatibility with list().
         *
         * @since 1.9
         * @param string $format
         * @param string $data
         * @return mixed|array
         */
        protected static function unpack($format, $data) {
            $data = unpack($format, $data);
            if (strlen($format) == 1) {
                return reset($data);
            }
            $result = array();
            foreach ($data as $key => &$value) {
                if (is_int($key)) {
                    $result[$key - 1] = $value;
                } else {
                    $result[$key] = $value;
                }
            }
            return $result;
        }

        /**
         * Read bytes from a file stream.
         *
         * If debugging is enabled any read bytes will be hex_dump'ed
         *
         * @since 1.9
         * @param resource $file
         * @param int $bytes
         * @return string
         */
        protected static function fread($file, $bytes) {
            $data = fread($file, $bytes);
            if (self::DEBUG) {
                self::hex_dump($data);
            }
            return $data;
        }

        /**
         * Convert an array of integers into an array of float base upon a fractional part.
         * @since 1.9
         * @param array $x Base
         * @param int $f Fraction
         * @return array
         */
        protected static function int2float($x, $f) {
            if (!is_array($x)) {
                $x = array($x);
            }
            foreach ($x as $i => $n) {
                $x[$i] = $n / $f;
            }
            return $x;
        }

        /**
         * Parse ColorSchemer Studio 2 file
         *
         * @since 1.9
         * @link https://markembling.info/2012/03/reverse-engineering-the-colorschemer-studio-2-file-format
         *
         * @param string $path
         * @return boolean|string|array
         */
        public function parse_cs($path) {
            $file = fopen($path, 'r');
            if (fread($file, 2) != 'CS') {
                return false;
            }
            $did_base = false;
            $block_count = 1;
            $palette = array();
            while ($block_count--) {
                $block_type = self::funpack($file, 2, 'v');
                if (!$did_base && $block_type != 1) {
                    return 'cs-corrupt';
                }
                switch ($block_type) {

                    case 1:  # color block
                        if (!$did_base) {
                            $did_base = true;
                            $skip = self::funpack($file, 2, 'v');
                            if ($skip) {
                                fseek($file, $skip, SEEK_CUR);
                            }
                            switch (self::funpack($file, 2, 'v')) {
                                case 1: fseek($file, 12, SEEK_CUR);
                                    break;
                                case 2: fseek($file, 16, SEEK_CUR);
                                    break;
                                default: return 'cs-corrupt';
                            }
                            $block_count = self::funpack($file, 2, 'v');
                        } else {
                            $name = self::fread_str8le($file);
                            switch (self::funpack($file, 2, 'v')) {

                                case 1:  # RGB
                                    $rgb = self::funpack($file, 12, 'f3');
                                    $color = kt_Color::instance()->rgb2hex($rgb);
                                    break;

                                case 2:  # CMYK
                                    $cmyk = self::funpack($file, 16, 'f4');
                                    $color = kt_Color::instance()->cmyk2hex($cmyk);
                                    break;

                                default: return 'cs-corrupt';
                            }
                            fseek($file, 1, SEEK_CUR);
                            $palette[] = array($color, $name);
                        }
                        break;

                    case 2:  # start of group
                        $skip = self::funpack($file, 2, 'v') + 1;
                        fseek($file, $skip, SEEK_CUR);
                        break;

                    case 3:  # end of group
                        break;

                    default: return 'cs-corrupt';
                }
            }
            return $palette;
        }

        /**
         * Parse ASE file.
         *
         * @since 1.9
         * @link http://carl.camera/?id=109
         *
         * @param string $path
         * @return boolean|string|array
         */
        public function parse_ase($path) {
            $file = fopen($path, 'r');
            if (self::fread($file, 4) != 'ASEF') {
                return false;
            }
            list($mayor, $minor) = self::funpack($file, 4, 'n2');
            if ($mayor != 1 && $minor != 0) {
                return 'ase-unsupported';
            }
            $count = self::funpack($file, 4, 'N');
            $palette = array();
            if ($count < 1) {
                return $palette;
            }
            while ($count--) {
                $chunk_type = self::fread($file, 2);
                if ($chunk_type == "\00\00") {
                    # EOF
                    break;
                }
                $len = self::funpack($file, 4, 'N');
                switch ($chunk_type) {

                    // chunk name
                    case "\xC0\x01":
                        fseek($file, $len, SEEK_CUR);
                        break;

                    // color chunk
                    case "\x00\x01":
                        $name = self::fread_str16be($file);
                        switch (self::fread($file, 4)) {

                            case 'RGB ':
                                $rgb = self::fread_float32be($file);
                                $color = kt_Color::instance()->rgb2hex($rgb);
                                break;

                            case 'CMYK':
                                $cmyk = self::fread_float32be($file, 4);
                                $color = kt_Color::instance()->cmyk2hex($cmyk);
                                break;

                            case 'LAB':
                                $lab = self::fread_float32be($file);
                                $color = kt_Color::instance()->lab2hex($lab);
                                break;

                            case 'Gray':
                                $gray = self::fread_float32be($file, 1);
                                $color = kt_Color::instance()->gray2hex($gray);
                                break;

                            default: return 'ase-corrupt';
                        }
                        self::fread($file, 2);  # ignore type
                        $palette[] = array($color, $name);
                        break;

                    // chunk end
                    case "\xC0\x02":
                        break;

                    default: return 'ase-corrupt';
                }
            }
            return $palette;
        }

        /**
         * Parse ACO file
         *
         * @since 1.9
         * @link http://www.adobe.com/devnet-apps/photoshop/fileformatashtml/#50577411_pgfId-1055819
         *
         * @param string $path
         * @return boolean|string|array
         */
        public function parse_aco($path) {
            $file = fopen($path, 'r');
            $version = self::funpack($file, 2, 'n');
            if ($version != 1) {
                return 'aco-unsupported';
            }
            $count = self::funpack($file, 2, 'n');
            $offset = 4;
            $parse_names = false;
            fseek($file, $offset + $count * 10);
            if (self::funpack($file, 2, 'n') == 2) {
                $offset += $offset + $count * 10;
                $count = self::funpack($file, 2, 'n');
                $parse_names = true;
            }
            fseek($file, $offset);
            $palette = array();
            for ($i = 0; $i < $count; $i++) {
                $space = self::funpack($file, 2, 'n');
                $buffer = self::fread($file, 8);
                $color = false;
                switch ($space) {

                    case 0: #RGB
                        list($r, $g, $b) = self::unpack('n3', $buffer);
                        $rgb = array($r * 65535, $g * 65535, $b * 65535);
                        $color = kt_Color::instance()->rgb2hex($rgb);
                        break;

                    case 1: #HSB/HSV
                        list($h, $s, $b) = self::unpack('n3', $buffer);
                        $color = kt_Color::instance()->hsv2hex($h / 65535, $s / 65535, $b / 65535);
                        break;

                    case 2: #CMYK
                        list($c, $m, $y, $k) = self::unpack('n4', $buffer);
                        $color = kt_Color::instance()->cmyk2hex($c / 65535, $m / 65535, $y / 65535, $k / 65535);
                        break;

                    case 7: #Lab
                        list($l, $a, $b) = self::unpack('n3', $buffer);
                        $color = kt_Color::instance()->lab2hex($l / 100, $a / 12800, $b / 12800);
                        break;

                    case 8: #Monochrome
                        list($gray) = self::unpack('n', $buffer);
                        $color = kt_Color::instance()->gray2hex($gray / 1e4);
                        break;

                    default: return 'aco-corrupt';
                }
                if (!$color) {
                    continue;
                }
                $name = '';
                if ($parse_names) {
                    $name = self::fread_str16be($file, 4, 'N');
                }
                $palette[] = array($color, $name);
            }
            return $palette;
        }

        /**
         * Parse sketchpalette file
         * @since 1.9
         * @param string $path
         * @return boolean|array
         */
        public function parse_sketch($path) {
            $raw = file_get_contents($path);
            if (!$raw) {
                return false;
            }
            $json = json_decode($raw, true);
            if (!$json || !is_array($json) || !isset($json['colors']) || !is_array($json['colors'])) {
                return false;
            }
            $palette = array();
            $keys = array('red', 'green', 'blue');
            foreach ($json['colors'] as $color) {
                $hex = '';
                foreach ($keys as $key) {
                    $hex .= kt_Color::instance()->float2hex($color[$key]);
                }
                $palette[] = array($hex, '');
            }
            return $palette;
        }

        /**
         * Parse paletton.com XML export
         *
         * Currently unused until paletton.com exports valid XML
         *
         * @since 1.9
         * @param string $path
         * @return boolean|array
         */
        public function parse_paletton($path) {
            if (!$this->is_xml($path, 'root', 'palette')) {
                return false;
            }
            $found_url = false;
            foreach ($this->XML->firstChild->childNodes as $Node) {
                if ($Node->nodeName == 'url' && strpos($Node->textContent, 'paletton.com') !== false) {
                    $found_url = true;
                    break;
                }
            }
            if (!$found_url) {
                return false;
            }
            $palette = array();
            foreach ($this->XML->firstChild->childNodes as $Set) {
                if (!$Set->nodeName == 'colorset') {
                    continue;
                }
                foreach ($Set->childNodes as $Node) {
                    if (!$Node->nodeName == 'color') {
                        continue;
                    }
                    $color = kt_Color::instance()->sanitize_color($Node->getAttribute('rgb'));
                    if (!$color) {
                        continue;
                    }
                    $name = sanitize_text_field($Node->getAttribute('id'));
                    $palette[] = array($color, $name);
                }
            }
            return $palette;
        }

        /**
         * Parse Paint Shop Pro PAL file
         * @since 1.9
         * @param string $path
         * @return boolean|array
         */
        public function parse_pal($path) {
            if (fread(fopen($path, 'r'), 8) != 'JASC-PAL') {
                return false;
            }
            $lines = file($path);
            $palette = array();
            foreach ($lines as $line) {
                $match = null;
                if (preg_match('~(\d+)\s*(\d+)\s*(\d+)~', $line, $match)) {
                    list($match, $r, $g, $b) = $match;
                    $rgb = self::int2float(array($r, $g, $b), 255);
                    $color = kt_Color::instance()->rgb2hex($rgb);
                    if (!$color) {
                        continue;
                    }
                    $palette[] = array($color, '');
                }
            }
            return $palette;
        }

        /**
         * Parse GIMP Color Palette
         * @since 1.9
         * @param string $path
         * @param boolean $headless [optional] default false
         * @return boolean|array
         */
        public function gimp_parse($path, $headless = false) {
            if (fread(fopen($path, 'r'), 12) != 'GIMP Palette') {
                return false;
            }
            $in_head = true;
            $palette = array();
            $match = array();
            $pattern = '~(\d+)\s+(\d+)\s+(\d+)\s*(.*)~';
            $lines = file($path);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line == '') {
                    continue;
                }
                if (!$headless && substr($line, 0, 1) == '#') {
                    $in_head = false;
                    continue;
                }
                if (($headless || !$in_head) && preg_match($pattern, $line, $match)) {
                    list($match, $r, $g, $b, $name) = $match;
                    $rgb = self::int2float(array($r, $g, $b), 255);
                    $color = kt_Color::instance()->rgb2hex($rgb);
                    if (!$color) {
                        continue;
                    }
                    $name = sanitize_text_field($name);
                    $palette[] = array($color, $name);
                }
            }
            return $palette;
        }

        /**
         * Parse OpenOffice SOC file
         * @since 1.9
         * @param string $path
         * @return boolean|array
         */
        public function parse_openoffice($path) {
            if (!$this->is_xml($path, 'xmlns:office', 'http://openoffice.org/2000/office')) {
                return false;
            }
            $palette = array();
            foreach ($this->XML->firstChild->childNodes as $Node) {
                if ($Node->nodeName != 'draw:color') {
                    continue;
                }
                $color = kt_Color::instance()->sanitize_color($Node->getAttribute('draw:color'));
                if (!$color) {
                    continue;
                }
                $name = sanitize_text_field($Node->getAttribute('draw:name'));
                $palette[] = array($color, $name);
            }
            return $palette;
        }

        /**
         * Parse Scribus file
         * @since 1.9
         * @param string $path
         * @return boolean|array
         */
        public function parse_scribus($path) {
            if (!$this->is_xml($path, 'root', 'SCRIBUSCOLORS')) {
                return false;
            }
            $palette = array();
            foreach ($this->XML->firstChild->childNodes as $Node) {
                if (!$Node->nodeName == 'COLOR' || $Node->getAttribute('Register')) {
                    continue;
                }
                $color = false;
                if ($Node->hasAttribute('RGB')) {
                    $color = kt_Color::instance()->sanitize_color($Node->getAttribute('RGB'));
                } else if ($Node->hasAttribute('CMYK')) {
                    $cmyk = $Node->getAttribute('CMYK');
                    if (preg_match('~^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$~i', $cmyk, $cmyk)) {
                        array_shift($cmyk);
                        foreach ($cmyk as $i => $c) {
                            $cmyk[$i] = hexdec($c) / 255;
                        }
                        $color = kt_Color::instance()->cmyk2hex($cmyk);
                    }
                }
                if ($color) {
                    $name = sanitize_text_field($Node->getAttribute('NAME'));
                    $palette[] = array($color, $name);
                }
            }
            return $palette;
        }

        /**
         * Parse Expression file
         * @since 1.9
         * @param string $path
         * @return boolean|array
         */
        public function parse_ms_expression($path) {
            if (!$this->is_xml($path, 'xmlns', 'http://schemas.microsoft.com/expression/design/2007')) {
                return false;
            }
            $palette = array();
            foreach ($this->XML->firstChild->childNodes as $Node) {
                if ($Node->nodeName == 'SolidColorSwatch') {
                    $color = $Node->getAttribute('Color');
                    $color = kt_Color::instance()->sanitize_color(substr($color, 3));
                    if ($color) {
                        $palette[] = array($color, '');
                    }
                }
            }
            return $palette;
        }

    }

}