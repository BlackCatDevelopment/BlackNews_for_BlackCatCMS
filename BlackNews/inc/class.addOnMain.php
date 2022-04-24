<?php

/**
 *
 *
 * ,-----.  ,--.              ,--.    ,-----.          ,--.       ,-----.,--.   ,--. ,---.
 * |  |) /_ |  | ,--,--. ,---.|  |,-.'  .--./ ,--,--.,-'  '-.    '  .--./|   `.'   |'   .-'
 * |  .-.  \|  |' ,-.  || .--'|     /|  |    ' ,-.  |'-.  .-'    |  |    |  |'.'|  |`.  `-.
 * |  '--' /|  |\ '-'  |\ `--.|  \  \'  '--'\\ '-'  |  |  |      '  '--'\|  |   |  |.-'    |
 * `------' `--' `--`--' `---'`--'`--'`-----' `--`--'  `--'       `-----'`--'   `--'`-----'
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author			Matthias Glienke
 *   @copyright		2022, Black Cat Development
 *   @link				https://github.com/BlackCatDevelopment/BlackNews_for_BlackCatCMS
 *   @license			https://www.gnu.org/licenses/gpl-3.0.html
 *   @category		CAT_Modules
 *   @package			blackNews
 *
 */

if (!interface_exists("addOnInterface", false)) {
    interface addOnInterface
    {
        public function view();
        public function save();
        public function modify();
        public static function add();
        public static function remove();
        public static function install();
        public static function uninstall();
        public static function upgrade();
    }
}

if (!class_exists("addOnMain", false)) {
    abstract class addOnMain implements addOnInterface
    {
        /**
         * @var void
         */

        protected static $name = "";
        protected static $directory = "";
        protected static $version = "";
        protected static $author = "";
        protected static $license = "";
        protected static $description = "";
        protected static $guid = "";
        protected static $home = "";
        protected static $platform = "";
        protected static $type = "page";
        protected static $addonID = null;

        protected static $db = null;

        protected $page_id;
        protected $section_id;
        protected $parserValues = [];

        protected static $precheckVersion;

        protected static $templatePath = "";
        protected $variant = "default";
        protected static $allVariants = [];

        protected $options = [];
        /**
         *
         */
        public function __construct(int $section_id = null)
        {
            // self::$_instances[] = $this;
            $this->setIDs($section_id);
        }

        public static function init()
        {
            // Connection to DB
            self::$db = CAT_Helper_DB::getInstance();

            static::$templatePath =
                "modules/" . static::$directory . "/templates/";
        }

        /**
         *
         */
        public function __destruct()
        {
            // unset(self::$_instances[array_search($this, self::$_instances, true)]);
        }

        /**
         * @param $includeSubclasses Optionally include subclasses in returned set
         * @returns array array of objects
         */
        public static function getInstances($includeSubclasses = false)
        {
            // $return = [];
            // foreach (self::$_instances as $inst) {
            //   $class = get_class($this);
            //   if ($inst instanceof $class) {
            //     if ($includeSubclasses || get_class($inst) === $class) {
            //       $return[] = $inst;
            //     }
            //   }
            // }
            // return $return;
        }

        /**
         *
         */
        public static function getInstance()
        {
            if (!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Default install routine
         */
        public static function install()
        {
            # self::uninstall();

            $errors = self::sqlProcess(
                CAT_PATH .
                    "/modules/" .
                    static::$directory .
                    "/inc/db/structure.sql"
            );

            $addons_helper = new CAT_Helper_Addons();
            foreach (["save.php"] as $file) {
                if (
                    false ===
                    $addons_helper->sec_register_file(static::$directory, $file)
                ) {
                    error_log("Unable to register file -$file-!");
                }
            }
            return $errors;
        }

        /**
         * currently workaround to set $section_id and $page_id
         */
        public function setIDs(int $section_id = null): self
        {
            // Try to set section_id
            $this->section_id = $section_id
                ? $section_id
                : CAT_Helper_Validate::get("_REQUEST", "section_id", "numeric");

            if (!isset($this->section_id)) {
                global $section_id;
                $this->section_id = $section_id;
            }

            // Try to set page_id
            if (!isset($this->page_id)) {
                $this->page_id = CAT_Helper_Validate::get(
                    "_REQUEST",
                    "page_id",
                    "numeric"
                );
            }

            if (!isset($this->page_id)) {
                if ($this->section_id) {
                    $this->page_id = self::$db
                        ->query(
                            "SELECT `page_id` FROM `:prefix:sections` " .
                                "WHERE `section_id` = :section_id",
                            [
                                "section_id" => $this->section_id,
                            ]
                        )
                        ->fetchColumn();
                } else {
                    global $page_id;
                    $this->page_id = $page_id;
                }
            }
            return $this;
        }

        /**
         * Default uninstall routine
         */
        public static function uninstall()
        {
            $errors = self::sqlProcess(
                CAT_PATH .
                    "/modules/" .
                    static::$directory .
                    "/inc/db/uninstall.sql"
            );
            return $errors;
        }
        /**
         *
         */
        abstract public static function upgrade();
        /**
         *
         */
        abstract public function save();

        /**
         * Default modify routine
         */
        public function modify()
        {
            global $parser;

            $this->setIDs();

            // Should be moved to the Object
            $this->setParserValue();

            $parser->setPath(
                CAT_PATH .
                    "/modules/" .
                    static::$directory .
                    "/templates/" .
                    $this->getVariant()
            );
            $parser->setFallbackPath(
                CAT_PATH .
                    "/modules/" .
                    static::$directory .
                    "/templates/default"
            );

            $parser->output(self::$template, $this->getParserValue());
        }

        public static function add()
        {
            $this->setIDs();

            // Add a new news section
            if (
                self::$db->query(
                    "INSERT INTO `:prefix:mod_" .
                        static::$directory .
                        '`
            ( `page_id`, `section_id` ) VALUES
            ( :page_id, :section_id )',
                    [
                        "page_id" => $this->page_id,
                        "section_id" => $this->section_id,
                    ]
                )
            ) {
                self::$addonID = self::$db->lastInsertId();
                return self::$addonID;
            } else {
                return null;
            }
        }
        public function view()
        {
            global $parser;

            self::$template = "view";

            $parser->setPath(
                CAT_PATH .
                    "/modules/" .
                    static::$directory .
                    "/templates/" .
                    $this->getVariant()
            );
            $parser->setFallbackPath(
                CAT_PATH .
                    "/modules/" .
                    static::$directory .
                    "/templates/default"
            );

            $parser->output(self::$template, $this->getParserValue());
        }

        public static function remove()
        {
            global $page_id;
            global $section_id;
            // Remove from database
            if (
                self::$db->query(
                    "DELETE FROM `:prefix:mod_" .
                        static::$directory .
                        "` " .
                        "WHERE `page_id` =:page_id " .
                        "AND `section_id` =:section_id",
                    [
                        "page_id" => $page_id,
                        "section_id" => $section_id,
                    ]
                )
            ) {
                return true;
            } else {
                return false;
            }
        }
        /**
         *
         */
        public static function get()
        {
            // TODO: implement here
        }

        /**
         * allows to get addon details by using the ID as set in the DB;
         * returns array on success, false on fail
         * use getInfo() with the ID
         */
        private function getByID()
        {
            // TODO: implement here
        }

        /**
         * get all installed addons from database
         */
        protected static function getAll()
        {
            // TODO: implement here
        }

        /**
         * get infos from  headers.inc.php
         */
        public function getHeader($for = "backend")
        {
            $path =
                CAT_PATH .
                "/modules/" .
                static::$directory .
                "/inc/headers/" .
                $this->getVariant(true) .
                "/" .
                $for .
                ".ini";
            $default =
                CAT_PATH .
                "/modules/" .
                static::$directory .
                "/inc/headers/default/" .
                $for .
                ".ini";

            if (file_exists($path)) {
                return parse_ini_file($path, true);
            } elseif (file_exists($default)) {
                return parse_ini_file($default, true);
            }
        } // end getHeader()

        /**
         * gets the details of an addons; uses the directory name to find the
         * addon in the DB
         * @access public
         * @param  string  $temp_addon_file
         * @param void $value
         */
        public static function getInfo($value)
        {
            return static::$$value;
        }

        /**
         * load info during install() or upgrade() to DB
         */
        private static function setInfo()
        {
            // TODO: implement here
        }

        /**
         * get info fro the info.php (or similar) while install(), upgrade()
         */
        private function getInfoByFile()
        {
            // TODO: implement here
        }

        /**
         *
         */
        public function getVariant()
        {
            // TODO: implement here
        }

        /**
         * set variant of the Addon
         */
        public function setVariant()
        {
            // TODO: implement here
        }

        /**
         * Get all available variants of an addon by checking the templates-folder
         */
        public static function getAllVariants()
        {
            if (count(self::$allVariants) > 0) {
                return self::$allVariants;
            }
            foreach (
                CAT_Helper_Directory::getInstance()
                    ->setRecursion(false)
                    ->scanDirectory(
                        CAT_PATH .
                            "/modules/" .
                            static::$directory .
                            "/templates/"
                    )
                as $path
            ) {
                self::$allVariants[] = basename($path);
            }
            return self::$allVariants;
        }

        /**
         *
         */
        public function precheck()
        {
            // TODO: implement here
        }

        /**
         *
         */
        public static function installAddon()
        {
            // TODO: implement here
        }

        /**
         *
         */
        public static function uninstallAddon()
        {
        }

        /**
         * use in the  install() / upgrade()
         */
        private function installUploaded()
        {
            // TODO: implement here
        }

        /**
         *
         */
        private static function isInstalled()
        {
            // In install() / upgrade()
        }

        /**
         * check whether an addon is removeable => entry in the database
         * is used in upgrade() / uninstall()
         */
        private function isRemovable()
        {
            // TODO: implement here
        }

        /**
         * gets the sections and pages a module is used on
         */
        public function getUsage()
        {
            // TODO: implement here
        }

        /**
         * get  module permissions for current user
         * not sure, if this function should be in CAT_Addons, but in CAT_Permissions?
         */
        public function getPermission()
        {
            // TODO: implement here
        }
        protected static function sqlProcess($file)
        {
            $errors = [];
            $import = file_get_contents($file);
            $import = preg_replace("%/\*(.*)\*/%Us", "", $import);
            $import = preg_replace("%^--(.*)\n%mU", "", $import);
            $import = preg_replace("%^$\n%mU", "", $import);
            $import = preg_replace("%cat_%", CAT_TABLE_PREFIX, $import);
            foreach (self::__split_sql_file($import, ";") as $imp) {
                if ($imp != "" && $imp != " ") {
                    $ret = self::$db->query($imp);
                    if (self::$db->isError()) {
                        $errors[] = self::$db->getError();
                    }
                }
            }
            return $errors;
        }

        /**
         * Credits: http://stackoverflow.com/questions/147821/loading-sql-files-from-within-php
         * Copied from the install-folder
         **/
        private static function __split_sql_file($sql, $delimiter)
        {
            // Split up our string into "possible" SQL statements.
            $tokens = explode($delimiter, $sql);

            // try to save mem.
            $sql = "";
            $output = [];

            // we don't actually care about the matches preg gives us.
            $matches = [];

            // this is faster than calling count($oktens) every time thru the loop.
            $token_count = count($tokens);
            for ($i = 0; $i < $token_count; $i++) {
                // Don't wanna add an empty string as the last thing in the array.
                if ($i != $token_count - 1 || strlen($tokens[$i] > 0)) {
                    // This is the total number of single quotes in the token.
                    $total_quotes = preg_match_all(
                        "/'/",
                        $tokens[$i],
                        $matches
                    );
                    // Counts single quotes that are preceded by an odd number of backslashes,
                    // which means they're escaped quotes.
                    $escaped_quotes = preg_match_all(
                        "/(?<!\\\\)(\\\\\\\\)*\\\\'/",
                        $tokens[$i],
                        $matches
                    );

                    $unescaped_quotes = $total_quotes - $escaped_quotes;

                    // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
                    if ($unescaped_quotes % 2 == 0) {
                        // It's a complete sql statement.
                        $output[] = $tokens[$i];
                        // save memory.
                        $tokens[$i] = "";
                    } else {
                        // incomplete sql statement. keep adding tokens until we have a complete one.
                        // $temp will hold what we have so far.
                        $temp = $tokens[$i] . $delimiter;
                        // save memory..
                        $tokens[$i] = "";

                        // Do we have a complete statement yet?
                        $complete_stmt = false;

                        for (
                            $j = $i + 1;
                            !$complete_stmt && $j < $token_count;
                            $j++
                        ) {
                            // This is the total number of single quotes in the token.
                            $total_quotes = preg_match_all(
                                "/'/",
                                $tokens[$j],
                                $matches
                            );
                            // Counts single quotes that are preceded by an odd number of backslashes,
                            // which means they're escaped quotes.
                            $escaped_quotes = preg_match_all(
                                "/(?<!\\\\)(\\\\\\\\)*\\\\'/",
                                $tokens[$j],
                                $matches
                            );

                            $unescaped_quotes = $total_quotes - $escaped_quotes;

                            if ($unescaped_quotes % 2 == 1) {
                                // odd number of unescaped quotes. In combination with the previous incomplete
                                // statement(s), we now have a complete statement. (2 odds always make an even)
                                $output[] = $temp . $tokens[$j];

                                // save memory.
                                $tokens[$j] = "";
                                $temp = "";

                                // exit the loop.
                                $complete_stmt = true;
                                // make sure the outer loop continues at the right point.
                                $i = $j;
                            } else {
                                // even number of unescaped quotes. We still don't have a complete statement.
                                // (1 odd and 1 even always make an odd)
                                $temp .= $tokens[$j] . $delimiter;
                                // save memory.
                                $tokens[$j] = "";
                            }
                        } // for..
                    } // else
                }
            }

            // remove empty
            for ($i = count($output) + 1; $i >= 0; $i--) {
                if (isset($output[$i]) && trim($output[$i]) == "") {
                    array_splice($output, $i, 1);
                }
            }

            return $output;
        }

        /**
         *
         */
        protected function getTemplate()
        {
            // TODO: implement here
            return "view";
        }

        /**
         *
         */
        protected function setTemplate()
        {
            // TODO: implement here
        }

        /**
         *
         */
        public function setParserValue(
            $name = null,
            $value = null,
            $reset = false
        ) {
            if (count($this->parserValues) == 0) {
                $this->initSetParserValue();
            }
            if ($name) {
                $this->parserValues[$name] =
                    isset($this->parserValues[$name]) &&
                    is_array($this->parserValues[$name]) &&
                    !$reset
                        ? array_merge($this->parserValues[$name], $value)
                        : $value;
            }
        }

        protected function initSetParserValue()
        {
            $this->parserValues = [
                "CAT_ADMIN_URL" => CAT_ADMIN_URL,
                "CAT_PATH" => CAT_PATH,
                "CAT_URL" => CAT_URL,
                "fullUrl" => CAT_Helper_Validate::getURI(CAT_URL),
                "version" => CAT_Helper_Addons::getModuleVersion(
                    static::$directory
                ),
                "allVariants" => self::getAllVariants(),
                "page_id" => $this->page_id,
                "section_id" => $this->section_id,
                "variant" => $this->getVariant(),
                "bc_WYSIWYG" => [
                    "width" => "100%",
                    "height" => "150px",
                    "name" => "wysiwyg_" . $this->section_id,
                ],
                "bc_WYSIWYG2" => [
                    "width" => "100%",
                    "height" => "100px",
                    "name" => "wysiwyg_" . $this->section_id . "2",
                ],
            ];
        }

        /**
         *
         */

        public function getParserValue()
        {
            if (count($this->parserValues) == 0) {
                $this->initSetParserValue();
            }
            return $this->parserValues;
        }

        public static function printArray($arr)
        {
            echo "<pre>";
            print_r($arr);
            echo "</pre>";
        }
    }
}
