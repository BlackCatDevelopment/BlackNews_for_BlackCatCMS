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

if (!class_exists("blackNewsEntry", false)) {
    if (!class_exists("blackNews", false)) {
        require_once dirname(__FILE__) . "/class.blackNews.php";
    }

    class blackNewsEntry extends blackNews
    {
        /**
         * @var void
         */
        private $entryID;
        private $typ;
        private $info = [];
        private $values = [];
        private $seoUrl;

        private static $staticVars = [
            "staticVars",
            "modified",
            "eventID",
            "timestamp",
            "instance",
        ];

        /**
         *
         */
        public function __construct(int $entryID = null)
        {
            parent::__construct();
            $this->setEntryID($entryID);
        }
        public function __destruct()
        {
            parent::__destruct();
        }
        /**
         * @param void $entryID
         */
        public static function getInstance($entryID = null)
        {
            if (!self::$instance || $entryID) {
                self::$instance = new self();
            }
            if ($entryID) {
                self::$instance->entryID = $entryID;
            }
            return self::$instance;
        }

        /**
         * @param void
         */
        public function getEntry()
        {
            CAT_Helper_I18n::getInstance(LANGUAGE)->addFile(
                LANGUAGE . ".php",
                CAT_Helper_Directory::sanitizePath(
                    CAT_PATH . "/modules/" . static::$directory . "/languages"
                )
            );
            return array_merge($this->getEntryInfo(), [
                "entryID" => $this->getEntryID(),
                "image" => $this->getImage(),
                "message" => CAT_Helper_I18n::getInstance(LANGUAGE)
                    ->lang()
                    ->translate("Post loaded"),
                "options" => $this->getOption(),
                "category" => $this->getCategory(),
                "success" => true,
            ]);
        }
        /**
         * @param void
         */
        public static function getEntryByURL(
            $seoURL = null,
            bool $getObject = true
        ) {
            if (!$seoURL) {
                return false;
            }

            $entryID = self::$db
                ->query(
                    'SELECT `entryID` FROM `:prefix:mod_blackNewsEntry`
          WHERE `seoURL` = :seoURL',
                    [
                        "seoURL" => $seoURL,
                    ]
                )
                ->fetchColumn();
            if ($getObject) {
                $returnEntry = new self($entryID);
                return $returnEntry->getEntry();
            } else {
                return $entryID;
            }
        } // end getEntryByURL()

        /**
         * @param void $name
         * @param void $value
         */
        public function getImage()
        {
            if (
                file_exists(
                    CAT_PATH .
                        parent::$imageDir .
                        parent::$imageName .
                        "_" .
                        $this->getEntryID() .
                        ".jpg"
                )
            ) {
                return CAT_URL .
                    parent::$imageDir .
                    parent::$imageName .
                    "_" .
                    $this->getEntryID() .
                    ".jpg";
            } else {
                return false;
            }
        }

        /**
         * @param void $name
         * @param void $value
         */
        public function getOption(string $name = "", bool $fromDB = false)
        {
            if ($name != "") {
                if (isset($this->options[$name])) {
                    return $this->options[$name];
                }

                // Get info from table
                return self::$db
                    ->query(
                        "SELECT `value` FROM `:prefix:mod_blackNewsEntryOptions` " .
                            "WHERE `entryID` = :entryID AND `name` = :name",
                        [
                            "entryID" => $this->getEntryID(),
                            "name" => $name,
                        ]
                    )
                    ->fetchColumn();
            } else {
                // Get all options
                $result = self::$db->query(
                    "SELECT `value`, `name` " .
                        "FROM `:prefix:mod_blackNewsEntryOptions` " .
                        "WHERE `entryID` = :entryID",
                    [
                        "entryID" => $this->getEntryID(),
                    ]
                );
                if ($result && $result->rowCount() > 0) {
                    while (false !== ($option = $result->fetch())) {
                        $this->options[$option["name"]] = $option["value"];
                    }
                }
                return $this->options;
            }
        }

        /**
         * @param void $name
         * @param void $value
         */
        private function setOption($name, $value)
        {
            // Get info from table
            return self::$db->query(
                "INSERT INTO `:prefix:mod_blackNewsEntryOptions` " .
                    "(`entryID`, `name`, `value`) VALUES ( :entryID, :name, :value ) " .
                    "ON DUPLICATE KEY UPDATE `value` = :value",
                [
                    "entryID" => $this->getEntryID(),
                    "name" => $name,
                    "value" => $value,
                ]
            );
        }

        /**
         * @param void $name
         * @param void $value
         */
        public function getEntryInfo($name = null)
        {
            // Get info from table
            $getEntry = self::$db->query(
                "SELECT nE.`entryID`, nE.`section_id`, `title`, `content`, `shortcontent`, `text`, `modified`, `created`, `userID`, `seoURL`, `position`, `publish`, `category`, `url`, " .
                    'DATE_FORMAT(`publishDate`, "%Y-%m-%d") AS publishDate, ' .
                    'DATE_FORMAT(`publishDate`, "%H:%i") AS publishTime, ' .
                    'DATE_FORMAT(`unpublishDate`, "%Y-%m-%d") AS unpublishDate, ' .
                    'DATE_FORMAT(`unpublishDate`, "%H:%i") AS unpublishTime ' .
                    "FROM `:prefix:mod_blackNewsEntry` nE " .
                    "LEFT JOIN `:prefix:mod_blackNewsCategoryEntries` catE " .
                    "ON nE.`entryID` = catE.`entryID` " .
                    "LEFT JOIN `:prefix:mod_blackNewsCategory` cat " .
                    "ON cat.`catID` = catE.`catID` " .
                    "WHERE nE.`entryID` = :entryID",
                [
                    "entryID" => $this->getEntryID(),
                ]
            );

            if (
                isset($getEntry) &&
                $getEntry->numRows() > 0 &&
                !false == ($row = $getEntry->fetchRow())
            ) {
                $this->info = $row;
                $this->info["seoURLencode"] = urlencode($this->info["seoURL"]);
                $this->info[
                    "username"
                ] = CAT_Users::getInstance()->get_user_details(
                    $this->info["userID"],
                    "username"
                );
                $this->info[
                    "display_name"
                ] = CAT_Users::getInstance()->get_user_details(
                    $this->info["userID"],
                    "display_name"
                );
            }

            #	$this->info['publishDate']		= $this->info['publishDate'] != '' ? self::getDateTimeInput('publishDate') : '';
            #	$this->info['unpublishDate']	= $this->info['unpublishDate'] != '' ? self::getDateTimeInput('unpublishDate') : '';

            return $name
                ? (isset($this->info[$name])
                    ? $this->info[$name]
                    : "")
                : $this->info;
        }

        /**
         * @param void $name
         * @param void $value
         */
        public function setEntryInfo(array $values)
        {
            foreach ($values as $k => $v) {
                $this->info[$k] = $v;
            }

            $i = 0;
            while (
                $this->info["seoURL"] == "" ||
                ($checkID =
                    self::$db
                        ->query(
                            "SELECT `entryID` FROM `:prefix:mod_blackNewsEntry` " .
                                "WHERE `seoURL` = :seoURL",
                            [
                                "seoURL" => $this->info["seoURL"],
                            ]
                        )
                        ->fetchColumn() &&
                    self::$db
                        ->query(
                            "SELECT `entryID` FROM `:prefix:mod_blackNewsEntry` " .
                                "WHERE `seoURL` = :seoURL",
                            [
                                "seoURL" => $this->info["seoURL"],
                            ]
                        )
                        ->fetchColumn() != $this->getEntryID())
            ) {
                $this->info["seoURL"] =
                    $this->info["seoURL"] == ""
                        ? parent::createTitleURL($this->info["title"])
                        : parent::createTitleURL($this->info["title"]) .
                            "-" .
                            ++$i;
            }
            if (isset($values["userID"]) && $values["userID"] == "") {
                $this->info["userID"] = CAT_Users::getInstance()->get_user_id();
            }

            // use HTMLPurifier to clean up the contents if enabled
            if (
                self::$db
                    ->query(
                        "SELECT `value` FROM `:prefix:settings` " .
                            "WHERE `name` = 'enable_htmlpurifier' AND `value` = 'true'"
                    )
                    ->fetchColumn()
            ) {
                $this->info[
                    "content"
                ] = CAT_Helper_Protect::getInstance()->purify(
                    $this->info["content"],
                    ["Core.CollectErrors" => true]
                );
                $this->info[
                    "shortcontent"
                ] = CAT_Helper_Protect::getInstance()->purify(
                    $this->info["shortcontent"],
                    ["Core.CollectErrors" => true]
                );
            }

            // Add a new entry
            // Add a new entry
            return self::$db->query(
                "INSERT INTO `:prefix:mod_blackNewsEntry` " .
                    "( `entryID`, `title`, `content`, `shortcontent`, `text`, `seoURL`, `publishDate`, `unpublishDate`, `userID` ) VALUES " .
                    "( :entryID, :title, :content, :short, :text, :seoURL, :pD, :upD, :userID ) " .
                    "ON DUPLICATE KEY UPDATE " .
                    "`title` = :title, `content` = :content, `shortcontent` = :short, `text` = :text, `seoURL` = :seoURL, `modified` = CURRENT_TIMESTAMP, `publishDate` = :pD, `unpublishDate` = :upD, `userID` = :userID",
                [
                    "entryID" => $this->getEntryID(),
                    "title" => $this->info["title"],
                    "content" => $this->info["content"],
                    "short" => $this->info["shortcontent"],
                    "text" => strip_tags($this->info["content"]),
                    "seoURL" => $this->info["seoURL"],
                    "pD" =>
                        (isset($this->info["publishDate"]) &&
                            $this->info["publishDate"] != "") ||
                        (isset($this->info["publishTime"]) &&
                            $this->info["publishTime"] != "")
                            ? date(
                                "Y-m-d H:i:s",
                                strtotime(
                                    (isset($this->info["publishDate"]) &&
                                    $this->info["publishDate"] != ""
                                        ? $this->info["publishDate"]
                                        : "") .
                                        " " .
                                        (isset($this->info["publishTime"]) &&
                                        $this->info["publishTime"] != ""
                                            ? $this->info["publishTime"]
                                            : "00:00")
                                )
                            )
                            : null,
                    "upD" =>
                        (isset($this->info["unpublishDate"]) &&
                            $this->info["unpublishDate"] != "") ||
                        (isset($this->info["unpublishTime"]) &&
                            $this->info["unpublishTime"] != "")
                            ? date(
                                "Y-m-d H:i:s",
                                strtotime(
                                    (isset($this->info["unpublishDate"]) &&
                                    $this->info["unpublishDate"] != ""
                                        ? $this->info["unpublishDate"]
                                        : "") .
                                        " " .
                                        (isset($this->info["unpublishTime"]) &&
                                        $this->info["unpublishTime"] != ""
                                            ? $this->info["unpublishTime"]
                                            : "00:00")
                                )
                            )
                            : null,
                    "userID" => isset($this->info["userID"])
                        ? $this->info["userID"]
                        : null,
                ]
            );
        }

        /**
         *
         */
        public function getEntryID()
        {
            if (!$this->entryID) {
                $this->setEntryID();
            }
            return $this->entryID;
        }

        /**
         *
         */
        public function setEntryID($entryID = null)
        {
            $this->entryID =
                $entryID && is_numeric($entryID)
                    ? $entryID
                    : CAT_Helper_Validate::sanitizePost("entryID", "numeric");
            return $this->entryID;
        }

        /**
         *
         */
        public function getDescription()
        {
            // TODO: implement here
        }

        /**
         *
         */
        public function setDescription($content)
        {
            // TODO: implement here
        }

        /**
         *
         */
        public function setCategoryByURL($url = null)
        {
            if (!$url) {
                return false;
            }

            // Set category
            if (
                self::$db->query(
                    "REPLACE INTO `:prefix:mod_blackNewsCategoryEntries` " .
                        "( `catID`, `entryID` ) " .
                        "VALUES (" .
                        "( SELECT `catID` FROM `:prefix:mod_blackNewsCategoryEntries` " .
                        "WHERE `section_id` = :section_id AND `url` = :url ), " .
                        ":entryID )",
                    [
                        "url" => $url,
                        "section_id" => parent::$section_id,
                        "entryID" => $this->getEntryID(),
                    ]
                )
            ) {
            }
        }

        /**
         *
         */
        public function getCategory()
        {
            #			if (isset($this->options[$name])) return $this->options[$name];
            // Get all categories for this
            $result = self::$db->query(
                "SELECT bnCE.`catID`, bnC.`url`, bnC.`category` " .
                    "FROM `:prefix:mod_blackNewsCategoryEntries` AS bnCE " .
                    "JOIN `:prefix:mod_blackNewsCategory` AS bnC ON bnC.`catID` = bnCE.`catID` " .
                    "WHERE `entryID` = :entryID",
                [
                    "entryID" => $this->getEntryID(),
                ]
            );
            $cats = [];
            if ($result && $result->rowCount() > 0) {
                while (false !== ($option = $result->fetch())) {
                    $cats[] = [
                        "catID" => $option["catID"],
                        "category" => $option["category"],
                        "url" => $option["url"],
                    ];
                }
            }
            return $cats;
        }

        /**
         *
         */
        public function setCategoryByID($catID = null)
        {
            if (!$catID) {
                return false;
            }

            $return = true;

            //
            if (!is_array($catID)) {
                $catID = [$catID];
            }

            // Delete all categories for this entry
            if (
                !self::$db->query(
                    "DELETE FROM `:prefix:mod_blackNewsCategoryEntries` " .
                        "WHERE `entryID` = :entryID",
                    [
                        "entryID" => $this->getEntryID(),
                    ]
                )
            ) {
                $return = false;
            }

            // Save only categories if "No category" is unchecked and a category is selected
            if (count($catID) > 0 && !in_array(-1, $catID)) {
                foreach ($catID as $id) {
                    // Set category
                    if (
                        !self::$db->query(
                            "REPLACE INTO `:prefix:mod_blackNewsCategoryEntries` " .
                                "( `catID`, `entryID` ) " .
                                "VALUES ( :catID, :entryID )",
                            [
                                "catID" => $id,
                                "entryID" => $this->getEntryID(),
                            ]
                        )
                    ) {
                        $return = false;
                    }
                }
            }
            return $return;
        }

        /**
         *
         */
        public function publishEntry()
        {
            $this->getEntryID();
            CAT_Helper_I18n::getInstance(LANGUAGE)->addFile(
                LANGUAGE . ".php",
                CAT_Helper_Directory::sanitizePath(
                    CAT_PATH . "/modules/" . static::$directory . "/languages"
                )
            );
            $published = CAT_Helper_I18n::getInstance(LANGUAGE)
                ->lang()
                ->translate("Post published");
            $unpublished = CAT_Helper_I18n::getInstance(LANGUAGE)
                ->lang()
                ->translate("Post offline");
            // Set publish
            if (
                self::$db->query(
                    "UPDATE `:prefix:mod_blackNewsEntry` " .
                        "SET `publish` = ( SELECT CASE " .
                        "WHEN `publish` IS NULL THEN CURRENT_TIMESTAMP " .
                        "ELSE NULL " .
                        "END AS publish ) " .
                        "WHERE `entryID` = :entryID",
                    [
                        "entryID" => $this->getEntryID(),
                    ]
                )
            ) {
                return [
                    "message" =>
                        $this->getEntryInfo("publish") === null
                            ? $unpublished
                            : $published,
                    "publish" => $this->getEntryInfo("publish"),
                    "entryID" => $this->getEntryID(),
                    "success" => true,
                ];
            } else {
                return [
                    "message" =>
                        $this->getEntryInfo("publish") === null
                            ? $unpublished
                            : $published,
                    "publish" => $this->getEntryInfo("publish"),
                    "entryID" => $this->getEntryID(),
                    "success" => true,
                ];
            }
        }

        /**
         *
         */
        public static function addEntry(int $section_id = null)
        {
            $title = self::createTitle($section_id);

            // Set publish
            if (
                self::$db->query(
                    "INSERT INTO `:prefix:mod_blackNewsEntry` " .
                        "( `section_id`, `userID`, `title`, `position` ) " .
                        "VALUES ( :section_id, :userID, :title, " .
                        "( SELECT MAX(t.`position`) FROM (SELECT `position` FROM `:prefix:mod_blackNewsEntry`) t ) + 1 )",
                    [
                        "section_id" => $section_id,
                        "userID" => CAT_Users::getInstance()->get_user_id(),
                        "title" => $title,
                    ]
                )
            ) {
                $entryID = self::$db->lastInsertId();

                $entryObj = new blackNewsEntry($entryID);
                $entryObj->getEntryInfo();

                CAT_Helper_I18n::getInstance(LANGUAGE)->addFile(
                    LANGUAGE . ".php",
                    CAT_Helper_Directory::sanitizePath(
                        CAT_PATH .
                            "/modules/" .
                            static::$directory .
                            "/languages"
                    )
                );

                return [
                    "message" => CAT_Helper_I18n::getInstance(LANGUAGE)
                        ->lang()
                        ->translate("Post created"),
                    "html" => $entryObj->getHTML("entryList"),
                    "values" => $entryObj->getEntryInfo(),
                    "image" => $entryObj->getImage(),
                    "entryID" => $entryID,
                    "success" => true,
                ];
            }
        }

        /**
         *
         */
        public function saveEntry()
        {
            $this->entryID = CAT_Helper_Validate::sanitizePost("entryID");

            $this->setEntryInfo(CAT_Helper_Validate::sanitizePost("values"));

            $this->setCategoryByID(
                CAT_Helper_Validate::sanitizePost("category")
            );

            if ($options = CAT_Helper_Validate::sanitizePost("options")) {
                foreach ($options as $opt) {
                    $this->setOption($opt["name"], $opt["value"]);
                }
            }
            CAT_Helper_I18n::getInstance(LANGUAGE)->addFile(
                LANGUAGE . ".php",
                CAT_Helper_Directory::sanitizePath(
                    CAT_PATH . "/modules/" . static::$directory . "/languages"
                )
            );

            return [
                "message" => CAT_Helper_I18n::getInstance(LANGUAGE)
                    ->lang()
                    ->translate("Post saved"),
                "image" => $this->getImage(),
                "values" => $this->getEntryInfo(),
                "entryID" => $this->getEntryID(),
                "success" => true,
            ];
        }

        /**
         *
         */
        public function removeEntry()
        {
            $this->entryID = CAT_Helper_Validate::sanitizePost(
                "entryID",
                "numeric"
            );

            if (
                self::$db->query(
                    "DELETE FROM `:prefix:mod_blackNewsEntry` " .
                        "WHERE `entryID` = :entryID",
                    [
                        "entryID" => $this->getEntryID(),
                    ]
                )
            ) {
                CAT_Helper_I18n::getInstance(LANGUAGE)->addFile(
                    LANGUAGE . ".php",
                    CAT_Helper_Directory::sanitizePath(
                        CAT_PATH .
                            "/modules/" .
                            static::$directory .
                            "/languages"
                    )
                );

                return [
                    "message" => CAT_Helper_I18n::getInstance(LANGUAGE)
                        ->lang()
                        ->translate("Post deleted"),
                    "success" => true,
                ];
            }
        }

        /**
         *
         */
        public function copyEntry()
        {
            $sourceID = $this->getEntryID();

            $this->getEntryInfo();
            $this->getOption();

            // copy main information of entry
            if (
                self::$db->query(
                    "INSERT INTO `:prefix:mod_blackNewsEntry` " .
                        "( `section_id`, `title`, `content`, `shortcontent`, `text`, `userID` ) " .
                        "VALUES ( :section_id, :title, :content, :short, :text, :userID )",
                    [
                        "section_id" => parent::$section_id,
                        "title" => $this->info["title"],
                        "content" => $this->info["content"],
                        "short" => $this->info["shortcontent"],
                        "text" => $this->info["text"],
                        "userID" => CAT_Users::getInstance()->get_user_id(),
                    ]
                )
            ) {
                $this->setEntryID(self::$db->lastInsertId());

                // Copy options for entry
                foreach ($this->options as $key => $val) {
                    $this->setOption($key, $val);
                }

                foreach (
                    CC_Form::getInstance()
                        ->setEntryID($sourceID)
                        ->getFields()
                    as $val
                ) {
                    CC_Form::getInstance()
                        ->setEntryID($this->getEntryID())
                        ->addField($val);
                }
                CAT_Helper_I18n::getInstance(LANGUAGE)->addFile(
                    LANGUAGE . ".php",
                    CAT_Helper_Directory::sanitizePath(
                        CAT_PATH .
                            "/modules/" .
                            static::$directory .
                            "/languages"
                    )
                );

                return [
                    "message" => CAT_Helper_I18n::getInstance(LANGUAGE)
                        ->lang()
                        ->translate("Post copied"),
                    "html" => self::getHTML("entryList"),
                    "entryID" => $this->getEntryID(),
                    "success" => true,
                ];
            } else {
                return false;
            }
        }

        /**
         * save images
         *
         * @access public
         * @param  array  $tmpFiles - images in an array
         * @return boolean true/false
         *
         **/
        public function saveImage($tmpFiles = null)
        {
            $this->getEntryID();

            $field_name = "bNimage";

            if (
                isset($tmpFiles[$field_name]["name"]) &&
                $tmpFiles[$field_name]["name"] != ""
            ) {
                // ===========================================
                // ! Get file extension of the uploaded file
                // ===========================================
                $file_extension =
                    strtolower(
                        pathinfo(
                            $tmpFiles[$field_name]["name"],
                            PATHINFO_EXTENSION
                        )
                    ) == ""
                        ? false
                        : strtolower(
                            pathinfo(
                                $tmpFiles[$field_name]["name"],
                                PATHINFO_EXTENSION
                            )
                        );
                // ======================================
                // ! Check if file extension is allowed
                // ======================================
                if (
                    isset($file_extension) &&
                    in_array($file_extension, ["png", "jpg", "jpeg", "gif"])
                ) {
                    if (!is_array($tmpFiles) || !count($tmpFiles)) {
                        return CAT_Backend::getInstance("Pages", "pages_modify")
                            ->lang()
                            ->translate("No files!");
                    } else {
                        $current = CAT_Helper_Upload::getInstance(
                            $tmpFiles[$field_name]
                        );
                        if ($current->uploaded) {
                            $dir = CAT_PATH . parent::$imageDir;
                            $tempDir = $dir . "temp/";

                            if (!file_exists($dir) || !is_dir($dir)) {
                                CAT_Helper_Directory::createDirectory(
                                    $dir,
                                    null,
                                    true
                                );
                            }
                            if (!file_exists($tempDir) || !is_dir($tempDir)) {
                                CAT_Helper_Directory::createDirectory(
                                    $tempDir,
                                    null,
                                    true
                                );
                            }

                            $current->file_overwrite = true;
                            $current->process($tempDir);

                            if ($current->processed) {
                                #								$addImg	= $this->addImg( $file_extension );

                                if (
                                    !CAT_Helper_Image::getInstance()->make_thumb(
                                        $tempDir . $current->file_dst_name,
                                        $dir .
                                            parent::$imageName .
                                            "_" .
                                            $this->getEntryID(),
                                        1400, //$resize_y,
                                        1400, //$resize_x,
                                        "fit",
                                        "jpg"
                                    )
                                ) {
                                    $return = false;
                                }

                                #								$this->createImg( $addImg['image_id'], self::$thumb_x, self::$thumb_y );

                                #								$addImg['thumb']	= sprintf( '%s/thumbs_%s_%s/',
                                #									$this->galleryURL,
                                #									self::$thumb_x,
                                #									self::$thumb_y ) . $addImg['picture'];

                                unlink($tempDir . $current->file_dst_name);

                                // =================================
                                // ! Clean the upload class $files
                                // =================================
                                $current->clean();
                                return true;
                            } else {
                                return CAT_Backend::getInstance(
                                    "Pages",
                                    "pages_modify"
                                )
                                    ->lang()
                                    ->translate(
                                        "File upload error: {{error}}",
                                        [
                                            "error" => $current->error,
                                        ]
                                    );
                            }
                        } else {
                            return CAT_Backend::getInstance(
                                "Pages",
                                "pages_modify"
                            )
                                ->lang()
                                ->translate("File upload error: {{error}}", [
                                    "error" => $current->error,
                                ]);
                        }
                    }
                }
            }
        } // end saveImages()

        /**
         *
         */
        public function getShort()
        {
            // TODO: implement here
        }

        /**
         *
         */
        public function getUrl()
        {
            // TODO: implement here
        }

        /**
         *
         */
        public function setUrl()
        {
            // TODO: implement here
        }

        /**
         *
         */
        private static function createTitle(int $section_id = null)
        {
            if (!$section_id) {
                global $section_id;
            }

            $result = self::$db->query(
                "SELECT `title` FROM `:prefix:mod_blackNewsEntry` " .
                    "WHERE `section_id` = :section_id",
                [
                    "section_id" => $section_id,
                ]
            );

            CAT_Helper_I18n::getInstance(LANGUAGE)->addFile(
                LANGUAGE . ".php",
                CAT_Helper_Directory::sanitizePath(
                    CAT_PATH . "/modules/" . static::$directory . "/languages"
                )
            );

            $title = CAT_Helper_I18n::getInstance(LANGUAGE)
                ->lang()
                ->translate("New post");
            $base = $title;

            if ($result && $result->rowCount() > 0) {
                $titles = [];
                while (false !== ($name = $result->fetch())) {
                    $titles[] = $name["title"];
                }
                $counter = 0;
                while (in_array($title, $titles)) {
                    $title = $base . "-" . ++$counter;
                }
            }
            return $title;
        }

        /**
         *
         */
        private function getHTML($template = "entryList")
        {
            global $parser, $section_id;

            $parser_data["entry"] = $this->info;
            $parser_data["section_id"] = $section_id;
            $parser_data["entry"]["entryID"] = $this->entryID;
            $parser_data["CAT_URL"] = CAT_URL;

            $this->template = $template;

            $parser->setPath(
                CAT_PATH .
                    "/modules/" .
                    static::$directory .
                    "/templates/" .
                    $this->getVariant() .
                    "/modify/"
            );
            $parser->setFallbackPath(
                CAT_PATH .
                    "/modules/" .
                    static::$directory .
                    "/templates/default/modify/"
            );

            return $parser->get($this->template, $parser_data);
        }

        /**
         * Prepare a valid string from a property for input:date
         *
         * @access private
         * @param  string	$prop	- property which should be converted
         * @param  string	$format	- output format
         * @return string
         *
         **/
        protected function getDateTimeInput(
            $prop = null,
            $format = "%Y-%m-%d %H:%M"
        ) {
            if (!self::getInstance()->getProperty($prop)) {
                return false;
            }
            return strftime(
                $format,
                strtotime(self::getInstance()->getProperty($prop))
            );
        }

        /**
         * Prepare a valid string from a property for DateTime in SQL
         *
         * @access private
         * @param  string	$prop	- property which should be converted
         * @return string
         *
         **/
        protected function getDateTimeSQL($prop = null)
        {
            if (!self::getInstance()->getProperty($prop)) {
                return false;
            }
            return strftime(
                "%Y-%m-%d %H:%M:00",
                strtotime(self::getInstance()->getProperty($prop))
            );
        }

        /**
         * Store a value to a property of an object
         *
         * @access public
         * @param  string	$key	- attribute of class, that should be set
         * @param  string	$value	- value for the attribute
         * @return object
         *
         **/
        public function setProperty($key = null, $value = null)
        {
            if (
                !self::getInstance()->getEventID() ||
                !property_exists("blackNewsEntry", $key) ||
                in_array($key, self::$staticVars)
            ) {
                return false;
            } else {
                self::getInstance()->$key = $value;
                return $this;
            }
        }

        /**
         * Get a value of a property of an object
         *
         * @access public
         * @param  string	$key	- attribute of class, that should be got
         * @return string
         *
         **/
        public function getProperty($key = null)
        {
            if (
                !self::getInstance()->getEventID() ||
                !property_exists("blackNewsEntry", $key) ||
                in_array($key, self::$staticVars)
            ) {
                return false;
            } else {
                return self::getInstance()->$key;
            }

            /*				'INSERT INTO `:prefix:mod_blacknews_content`
            (`page_id`, `section_id`, `news_id`, `title`, `subtitle`, `auto_generate_size`, `auto_generate` , `content`, `short`)
            VALUES (:page_id, :section_id, :news_id, :title, :subtitle, :auto_generate_size, :auto_generate, :content, :short )';*/
        }
    }
}
