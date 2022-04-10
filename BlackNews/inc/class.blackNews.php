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

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

if (!class_exists("blackNews", false)) {
  if (!class_exists("addOnMain", false)) {
    require_once dirname(__FILE__) . "/class.addOnMain.php";
  }

  class blackNews extends addOnMain
  {
    /**
     * @var void
     */
    protected static $instance = null;

    protected $template = "modify";
    private $SEOUrl;
    private $categories = [];

    private $routeUrl = "";
    private $routeQuery = null;
    private static $routeUrls = [];
    protected static $imageDir = "/media/blacknews/";
    protected static $imageName = "bNimage";
    private static $parsed = null;

    /**
     * @var void
     */
    protected static $name = "blackNews";
    protected static $directory = "blacknews";
    protected static $version = "0.7";
    protected static $author = "Matthias Glienke, letima development";
    protected static $license = "GNU General Public License";
    protected static $description = "Module for implementing news";
    protected static $guid = "3cf5feb8-7873-4d55-a6f4-33aafed211da";
    protected static $home = "https://github.com/BlackCatDevelopment/BlackNews_for_BlackCatCMS";
    protected static $platform = "1.x";

    public function __construct(int $section_id = null)
    {
      parent::__construct($section_id);
      $this->getRoute();
    }

    public function __destruct()
    {
      parent::__destruct();
    }

    public static function init()
    {
      parent::init();
      self::$routeUrls = [];

      if (CAT_Helper_Addons::isModuleInstalled(static::$directory)) {
        // Get all options
        // $result = self::$db->query(
        //   "SELECT `value`, `section_id` FROM `:prefix:mod_blackNewsOptions` " .
        //     'WHERE `name` = "permalink"'
        // );
        $result = self::$db->query(
          "SELECT s.`section_id`, p.`link` FROM `:prefix:sections` s " .
            "LEFT JOIN `:prefix:pages` p " .
            "ON s.`page_id` = p.`page_id` " .
            "WHERE `module` = :dir",
          [
            "dir" => static::$directory,
          ]
        );

        if ($result && $result->rowCount() > 0) {
          while (false !== ($permalink = $result->fetch())) {
            self::$routeUrls[$permalink["section_id"]] = trim(
              $permalink["link"],
              "/"
            );
          }
        }
      }
    }

    public static function getInstance()
    {
      if (!self::$instance) {
        self::$instance = new self();
      }
      return self::$instance;
    }

    /**
     *
     */
    public function getVariant(bool $fromDB = false)
    {
      // set and get variant of module
      $this->variant = $this->getOption("variant", $fromDB);
      return $this->variant ? $this->variant : "default";
    }

    /**
     * @param void $name
     * @param void $value
     */
    private function saveOptions(): array
    {
      if ($options = CAT_Helper_Validate::sanitizePost("options")) {
        foreach ($options as $opt) {
          $this->setOption($opt["name"], $opt["value"]);
        }
      }
      return [
        "message" => "Eintrag gespeichert",
        "success" => true,
      ];
    } // end saveOptions()

    /**
     * @param void $name
     * @param void $value
     */
    private function setOption(string $name, string $value): bool
    {
      //       if ($name == "permalink") {
      //         $value = trim($value, "/");
      //         #$oldDir	= $this->getOption('permalink');
      //
      //         // ToDo!s:
      //         // * check if directory already exists
      //         // * .htaccess anpassen
      //       }

      // Set info into table
      if (
        self::$db->query(
          "INSERT INTO `:prefix:mod_blackNewsOptions` " .
            "(`section_id`, `name`, `value`) VALUES ( :section_id, :name, :value ) " .
            "ON DUPLICATE KEY UPDATE `value` = :value",
          [
            "section_id" => $this->section_id,
            "name" => $name,
            "value" => $value,
          ]
        )
      ) {
        return true;
      } else {
        return false;
      }
    } // end setOption()

    /**
     *
     */
    public function getOption(string $name = "", bool $fromDB = false)
    {
      //: array|string
      if ($name != "" && !$fromDB && isset($this->options[$name])) {
        return $this->options[$name];
      } elseif ($name == "" && !$fromDB && count($this->options) > 0) {
        return $this->options;
      }

      // Get all options
      $result = self::$db->query(
        "SELECT `value`, `name` FROM `:prefix:mod_blackNewsOptions` " .
          "WHERE `section_id` = :section_id",
        [
          "section_id" => $this->section_id,
        ]
      );

      $this->options = [];
      if ($result && $result->rowCount() > 0) {
        while (false !== ($option = $result->fetch())) {
          $this->options[$option["name"]] = $option["value"];
        }
      }

      if ($name != "") {
        return isset($this->options[$name]) ? $this->options[$name] : "";
      }

      return $this->options;
    }

    /**
     *
     */
    public function getAllNewsSections(int $section_id = null): array
    {
      // Get all options
      $result = self::$db->query(
        "SELECT s.`section_id`, s.`name`, p.`menu_title`, p.`link`, p.`page_id` FROM `:prefix:sections` s " .
          "JOIN `:prefix:pages` p " .
          "ON s.`page_id` = p.`page_id` " .
          "WHERE s.`module` = :module AND " .
          " s.`section_id` <> :secID",
        [
          "module" => static::$directory,
          "secID" => $section_id
            ? $section_id
            : ($this->section_id
              ? $this->section_id
              : 0),
        ]
      );
      $sections = [];
      if ($result && $result->rowCount() > 0) {
        while (false !== ($sec = $result->fetch())) {
          $sections[$sec["section_id"]] = [
            "name" => $sec["name"],
            "menu_title" => $sec["menu_title"],
            "page_id" => $sec["page_id"],
            "link" => $sec["link"],
          ];
        }
      }
      return $sections;
    }

    /**
     *
     */
    public function getOverview(
      bool $addOpt = false,
      int $start = 0,
      int $limit = 0,
      bool $frontend = false
    ): array {
      $catID = $this->getOption("category") ? $this->getOption("category") : 0;

      $section_id = $this->getOption("setNews")
        ? $this->getOption("setNews")
        : 0;

      $between = $limit > 0 ? " LIMIT " . $start . "," . $limit : "";

      // Get all entries
      if ($catID > 0) {
        $result = self::$db->query(
          "SELECT nE.`entryID`, nE.`section_id`, `title`, `content`, `text`, `modified`, `created`, `userID`, `seoURL`, `position`, `publish`, `category`, `url`, " .
            'DATE_FORMAT(nE.`publishDate`, "%Y-%m-%d") AS publishDate, ' .
            'DATE_FORMAT(nE.`publishDate`, "%H:%i") AS publishTime, ' .
            'DATE_FORMAT(nE.`unpublishDate`, "%Y-%m-%d") AS unpublishDate, ' .
            'DATE_FORMAT(nE.`unpublishDate`, "%H:%i") AS unpublishTime, ' .
            "UNIX_TIMESTAMP(nE.`publishDate`) AS publishUT " .
            "FROM `:prefix:mod_blackNewsEntry` nE " .
            "LEFT JOIN `:prefix:mod_blackNewsCategoryEntries` catE " .
            "ON nE.`entryID` = catE.`entryID` " .
            "LEFT JOIN `:prefix:mod_blackNewsCategory` cat " .
            "ON cat.`catID` = catE.`catID` " .
            "WHERE catE.`catID` = :catID " .
            "AND nE.`section_id` = :section_id " .
            ($frontend
              ? "AND ((nE.`publishDate` < CURRENT_TIMESTAMP OR nE.`publishDate` IS NULL) " .
                "AND (nE.`unpublishDate` > CURRENT_TIMESTAMP OR nE.`unpublishDate` IS NULL)) " .
                "AND publish IS NOT NULL "
              : "") .
            "ORDER BY nE.`position` DESC, nE.`publishDate` DESC" .
            $between,
          [
            "section_id" => $section_id ? $section_id : $this->section_id,
            "catID" => $catID,
          ]
        );
      } else {
        $result = self::$db->query(
          "SELECT CURRENT_TIMESTAMP , nE.`entryID`, nE.`section_id`, `title`, `content`, `text`, `modified`, `created`, `userID`, `seoURL`, `position`, `publish`, `category`, `url`, " .
            'DATE_FORMAT(nE.`publishDate`, "%Y-%m-%d") AS publishDate, ' .
            'DATE_FORMAT(nE.`publishDate`, "%H:%i") AS publishTime, ' .
            'DATE_FORMAT(nE.`unpublishDate`, "%Y-%m-%d") AS unpublishDate, ' .
            'DATE_FORMAT(nE.`unpublishDate`, "%H:%i") AS unpublishTime, ' .
            "UNIX_TIMESTAMP(nE.`publishDate`) AS publishUT " .
            "FROM `:prefix:mod_blackNewsEntry` nE " .
            "LEFT JOIN `:prefix:mod_blackNewsCategoryEntries` catE ON nE.`entryID` = catE.`entryID`" .
            "LEFT JOIN `:prefix:mod_blackNewsCategory` C ON catE.catID = C.catID " .
            "WHERE nE.`section_id` = :section_id " .
            ($frontend
              ? "AND ((nE.`publishDate` < CURRENT_TIMESTAMP OR nE.`publishDate` IS NULL) " .
                "AND (nE.`unpublishDate` > CURRENT_TIMESTAMP OR nE.`unpublishDate` IS NULL)) " .
                "AND publish IS NOT NULL "
              : "") .
            "ORDER BY nE.`position` DESC, nE.`publishDate` DESC" .
            $between,
          [
            "section_id" => $section_id ? $section_id : $this->section_id,
          ]
        );
      }
      $entries = [];

      if ($result && $result->rowCount() > 0) {
        $i = 0;
        while (false !== ($entry = $result->fetch())) {
          $entries[++$i] = $entry;
          if ($addOpt) {
            $getEntry = new blackNewsEntry($entry["entryID"]);
            foreach ($getEntry->getOption() as $name => $value) {
              $entries[$i][$name] = $value;
            }
            $entries[$i][
              "username"
            ] = CAT_Users::getInstance()->get_user_details(
              $entries[$i]["userID"],
              "username"
            );
            $entries[$i][
              "display_name"
            ] = CAT_Users::getInstance()->get_user_details(
              $entries[$i]["userID"],
              "display_name"
            );
            $entries[$i]["image"] = $getEntry->getImage();
          }
        }
      }
      return $entries;
    }

    /**
     *
     */
    /*public static function getByCategory($addOpt=NULL,int $catID=0)
    {
      // Get all entries
      $result = self::$db->query(
        'SELECT * FROM `:prefix:mod_blackNewsEntry` E ' .
          'LEFT JOIN `:prefix:mod_blackNewsCategoryEntries` EC ON E.entryID = EC.entryID ' .
          'LEFT JOIN `:prefix:mod_blackNewsCategory` C ON EC.catID = C.catID ' .
          'WHERE C.catID = :catID ' .
            'AND E.`section_id` = :section_id ' .
            'ORDER BY E.`position` DESC',
        array(
          'section_id'		=> $this->section_id,
          'catID'				=> $catID
        )
      );
      if( $result && $result->rowCount() > 0 )
      {
        $i	= 0;
        while ( false !== ( $entry = $result->fetch() ) )
        {
          $entries[++$i]	= $entry;
          if($addOpt)
          {
            foreach( blackNewsEntry::getInstance($entry['entryID'])->getOption() as $name => $value )
            {
              $entries[$i][$name]	= $value;
            }
            $entries[$i]['username']	= CAT_Users::getInstance()->get_user_details($entries[$i]['userID'],'username');
            $entries[$i]['display_name']	= CAT_Users::getInstance()->get_user_details($entries[$i]['userID'],'display_name');
            $entries[$i]['image']			= blackNewsEntry::getInstance($entry['entryID'])->getImage();
          }
        }
      }
      return $entries;
    }*/

    /**
     *
     */
    private function getReferer(): int
    {
      if ($_SERVER["HTTP_REFERER"] == "") {
        return 0;
      }

      $route = array_filter(
        explode("/", parse_url($_SERVER["HTTP_REFERER"], PHP_URL_PATH))
      );
      $urls = [];

      foreach ($route as $k => $r) {
        $urls[$k] =
          (count($urls) > 0 ? $urls[$k - 1] : "") . "/" . trim($r, ".php");
      }

      // Wenn Referrer in Kategorien vorkommt, dann leite Zurückbutton auf Kategorie zurück
      $this->getCategories();
      foreach ($this->categories as $ind) {
        if ($ind["url"] == end($route)) {
          return $ind["catID"];
        }
      }
      // Wenn Referer als Page-URL vorkommt, dann leite Zurückbutton auf Seite zurück
      // Negativer Wert der Page-ID um zu catID unterscheiden zu können.
      $secs = $this->getAllNewsSections();
      foreach ($secs as $k => $v) {
        if (in_array($v["link"], $urls)) {
          $this->setParserValue("refererIsCategory", true);
          return (int) $v["page_id"];
        }
      }
      return 0;
    }

    public function getPermalink(int $secID = null): string
    {
      $result = self::$db
        ->query(
          "SELECT p.`link` FROM `:prefix:sections` s " .
            "LEFT JOIN `:prefix:pages` p " .
            "ON s.`page_id` = p.`page_id` " .
            "WHERE s.`section_id` = :secID AND `module` = :dir",
          [
            "secID" => $secID ? $secID : $this->section_id,
            "dir" => static::$directory,
          ]
        )
        ->fetchColumn();
      return trim($result, "/");
    }
    /**
     *
     */
    private function getEntry()
    {
      // TODO: Check if route is in database, else return 404
      // TODO: Add route to extra table with trigger to get history of files and automatically set 301

      return blackNewsEntry::getEntryByURL(
        trim(str_replace($this->getPermalink(), "", $this->routeUrl), "/")
      );
    }

    /**
     *
     */
    public function getCategories()
    {
      if (count($this->categories) > 0) {
        return $this->categories;
      }

      // Get all categories
      $r = self::$db->query(
        "SELECT * " .
          "FROM `:prefix:mod_blackNewsCategory` " .
          "WHERE `section_id` = :section_id",
        [
          "section_id" => $this->section_id,
        ]
      );
      if ($r && $r->rowCount() > 0) {
        while (false !== ($c = $r->fetch())) {
          $this->categories[$c["catID"]] = $c;
        }
      }
      return $this->categories;
    }

    /**
     * @param void $dir
     */
    private static function createPermalink($dir = "")
    {
      if (
        trim($dir, "/") != "" &&
        CAT_Helper_Directory::createDirectory(
          CAT_PATH . "/" . trim($dir, "/"),
          null,
          false
        )
      ) {
        return true;
      } else {
        return false;
      }
    }

    /**
     * @param void $old
     * @param void $new
     */
    private static function renamePermalink($old = null, $new = null)
    {
      if (!$old || !$new) {
        return false;
      }
      if (trim($new, "/") == trim($old, "/")) {
        return true;
      }

      $nDir = CAT_PATH . "/" . trim($new, "/");
      $oDir = CAT_PATH . "/" . trim($old, "/");

      if ((file_exists($nDir) && is_dir($nDir)) || !is_dir($oDir)) {
        return false;
      }

      if (rename($oDir, $nDir)) {
        $this->setOption("permalink", $new);
        return true;
      } else {
        return false;
      }
    }

    /**
     * get all offers from database
     *
     * @access public
     * @param  string/array  $id - id/ids of offer
     * @param  string  $output - if table to print - default false
     * @return array()
     *
     **/
    public static function createTitleURL($title = null)
    {
      if (!$title) {
        return false;
      }

      return CAT_Helper_Page::getFilename($title);
    } // end createTitleURL()

    /**
     *
     * @access public
     * @param  array  $arr - array( date (dd.mm.yyyy), start (hh:mm), end (hh:mm) )
     * @return
     **/
    public static function toTimestamp($arr = null)
    {
      if (!$arr || !is_array($arr)) {
        return false;
      }

      $ts = [];
      foreach ($arr as $date) {
        if (strpos($date["date"], "-") !== false) {
          list($y, $m, $d) = explode("-", $date["date"]);
        } else {
          list($d, $m, $y) = explode(".", $date["date"]);
        }
        list($sh, $sm) = explode(":", $date["time_start"]);
        list($eh, $em) = explode(":", $date["time_end"]);
        $ts[] = [
          mktime($sh, $sm, 0, $m, $d, $y),
          mktime($eh, $em, 0, $m, $d, $y),
        ];
      }
      return $ts;
    } // end function toTimestamp()

    /**
     *
     */
    public static function add(): bool
    {
      // Add a new blackNews
      global $section_id;
      global $page_id;
      if (
        self::$db->query(
          "INSERT INTO `:prefix:mod_blackNewsOptions` " .
            "( `section_id`, `name`, `value` ) VALUES " .
            '( :section_id, "variant", "default" )',
          [
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
    public static function update()
    {
      // Currently empty - placeholder for future updates
    }

    /**
     *
     */
    public static function checkRedirect(
      int $section_id = null,
      int $page_id = null
    ) {
      if (!$section_id) {
        global $section_id;
      }
      if (!$page_id) {
        global $page_id;
      }
      $rUrl = CAT_Registry::get("USE_SHORT_URLS")
        ? CAT_URL . "/" . self::$routeUrls[$section_id]
        : CAT_URL .
          "/" .
          trim(PAGES_DIRECTORY, "/") .
          "/" .
          self::$routeUrls[$section_id];
      $sUrl = CAT_Helper_Page::getLink($page_id);

      $bNObj = new self($section_id);

      if ($bNObj->getPermalink() . ".php" == self::$routeUrls[$section_id]) {
        $redirect = CAT_Registry::get("USE_SHORT_URLS")
          ? CAT_URL . "/" . $bNObj->getPermalink()
          : CAT_URL .
            "/" .
            trim(PAGES_DIRECTORY, "/") .
            "/" .
            $bNObj->getPermalink();
        header("HTTP/1.1 301 Moved Permanently");
        header("Location:" . $redirect);
        exit();
      }

      /*			if( $rUrl == $sUrl && ( $rUrl == CAT_URL . $_SERVER['REQUEST_URI'] ) )
      {
        $redirect	= CAT_Registry::get('USE_SHORT_URLS') ?
          CAT_URL  . '/' . $this->getOption('permalink') . '/'
          : CAT_URL . '/' . trim(PAGES_DIRECTORY,'/') . '/' . $this->getOption('permalink') . '/';
        header("HTTP/1.1 301 Moved Permanently");
        header("Location:" . $redirect );
        exit();
      }*/
    }

    /**
     *
     */
    public function checkOverview(string $rUrl = ""): bool
    {
      if (
        $this->routeUrl == $this->getPermalink() ||
        $rUrl == CAT_Helper_Page::getLink($this->page_id) ||
        $rUrl . ".php" == CAT_Helper_Page::getLink($this->page_id) ||
        trim($rUrl, "/") ==
          trim(CAT_Helper_Page::getLink($this->page_id), "/") ||
        trim($rUrl, "/") == trim(CAT_URL, "/")
      ) {
        return true;
      } else {
        return false;
      }
    }

    /**
     *
     */
    public function checkCategory(): bool
    {
      if ($this->routeUrl == "") {
        return false;
      }
      $route = explode("/", $this->routeUrl);

      $this->getCategories();
      foreach ($this->categories as $ind) {
        if ($ind["url"] == end($route)) {
          $this->options["category"] = $ind["catID"];
          return true;
        }
      }
      return false;
    }

    /**
     *
     */
    public function view(bool $output = true)
    {
      global $parser;

      $this->setIDs($section_id);

      // Reset parserValues
      $this->initSetParserValue();
      $this->setParserValue("isRoot", CAT_Users::is_root());
      $this->getRoute(PAGES_DIRECTORY);

      self::checkRedirect();

      $rUrl = CAT_Registry::get("USE_SHORT_URLS")
        ? CAT_URL . "/" . $this->routeUrl
        : CAT_URL . "/" . trim(PAGES_DIRECTORY, "/") . "/" . $this->routeUrl;

      $this->setParserValue("options", $this->getOption(), true);

      $this->setParserValue("categories", $this->getCategories(), true);

      // Check if user came from CategoryPage
      $this->setParserValue("referer", $this->getReferer(), true);

      $this->setParserValue(
        "permalink",
        $this->getPermalink(
          isset($this->parserValues["options"]["setNews"]) &&
          $this->parserValues["options"]["setNews"] > 0
            ? $this->parserValues["options"]["setNews"]
            : null
        )
      );

      if (self::checkOverview($rUrl) || self::checkCategory()) {
        $this->setParserValue("category", $this->getOption("category"), true);
        $this->setParserValue(
          "entries",
          $this->getOverview(true, 0, 0, true),
          true
        );
        $this->template = "view";
      } else {
        // $getEntry = new blackNewsEntry($entry["entryID"]);
        $this->setParserValue("entry", $this->getEntry());
        $this->template = "viewEntry";
      }
      if (
        file_exists(
          CAT_PATH .
            "/modules/" .
            static::$directory .
            "/view/" .
            $this->getVariant() .
            "/view.php"
        )
      ) {
        include CAT_PATH .
          "/modules/" .
          static::$directory .
          "/view/" .
          $this->getVariant() .
          "/view.php";
      }
      if ($output) {
        $parser->setPath(
          CAT_PATH .
            "/modules/" .
            static::$directory .
            "/templates/" .
            $this->getVariant()
        );
        $parser->setFallbackPath(
          CAT_PATH . "/modules/" . static::$directory . "/templates/default"
        );

        if (!self::$parsed) {
          $parser->output($this->template, $this->getParserValue());
        }
      } else {
        return $this->getParserValue();
      }
      #self::$parsed = true;
    }

    /**
     *
     */
    public static function includeNews(
      int $section_id = null,
      string $template = "",
      bool $out = true,
      int $start = 0,
      int $limit = 0
    ) {
      global $parser;
      $options = $this->getOption();

      $this->setIDs($section_id);
      $this->getVariant();

      /*			self::getRoute(PAGES_DIRECTORY);

      self::checkRedirect();

      $rUrl	= CAT_Registry::get('USE_SHORT_URLS') ?
          CAT_URL . '/' . $this->routeUrl
          : CAT_URL . '/' . trim(PAGES_DIRECTORY,'/') . '/' . $this->routeUrl;

      if ( $this->routeUrl == $this->getOption('permalink') )
        #|| !$this-> routeQuery )#$rUrl == CAT_Helper_Page::getLink(self::$page_id) )
      {
        $this->setParserValue('entries',$this->getOverview(true));
        $this->template	= 'view';
      } else {
        $this->setParserValue('entry',$this->getEntry());
        $this->template	= 'viewEntry';
      }
*/
      $this->setParserValue("categories", $this->getCategories());

      if ($options["category"]) {
        $this->setParserValue(
          "entries",
          $this->getOverview(true, $options["category"])
        );
      } else {
        $this->setParserValue(
          "entries",
          $this->getOverview(true, $start, $limit)
        );
      }

      $this->template = $template != "" ? $template : "view";

      $this->setParserValue("options", $this->getOption());

      // Muss ich noch checken... weiß ich selbst gerade nicht mehr, warum das gesetzt sein muss
      $this->options["variant"] = $options["variant"];

      $parser->setPath(
        CAT_PATH .
          "/modules/" .
          static::$directory .
          "/templates/" .
          $this->getVariant()
      );
      $parser->setFallbackPath(
        CAT_PATH . "/modules/" . static::$directory . "/templates/default"
      );

      if (!$out) {
        return $parser->get($this->template, $this->getParserValue());
      }

      if (!self::$parsed && $out) {
        $parser->output($this->template, $this->getParserValue());
      }

      #self::$parsed = true;
    }

    /**
     * retrieve the route
     *
     * @access private
     * @return
     **/
    private function getRoute(string $remove_prefix = "")
    {
      foreach (
        array_values([
          "REQUEST_URI",
          "REDIRECT_SCRIPT_URL",
          "SCRIPT_URL",
          "ORIG_PATH_INFO",
          "PATH_INFO",
        ])
        as $key
      ) {
        #self::printArray($_SERVER);
        if (isset($_SERVER[$key])) {
          $this->routeUrl = parse_url($_SERVER[$key], PHP_URL_PATH);
          $this->routeQuery = parse_url($_SERVER[$key], PHP_URL_QUERY);

          if (strpos($_SERVER[$key], "?") && strpos($_SERVER[$key], "=")) {
            $tmp = explode("?", $_SERVER[$key]);
            $this->routeUrl = $tmp[0];
          }
          $this->routeQuery = "";
          if ($this->routeQuery > "") {
            $this->routeUrl =
              $this->getPermalink() .
              "/" .
              str_replace("q=", "", $this->routeQuery);
          }
          break;
        }
      }
      if (!$this->routeUrl) {
        $this->routeUrl = "/";
      }

      // remove params
      if (stripos($this->routeUrl, "?")) {
        list($this->routeUrl, $ignore) = explode("?", $this->routeUrl, 2);
      }

      $path_prefix = str_ireplace(
        CAT_Helper_Directory::sanitizePath($_SERVER["DOCUMENT_ROOT"]),
        "",
        CAT_Helper_Directory::sanitizePath(CAT_PATH)
      );

      // if there's a prefix to remove
      if ($remove_prefix != "") {
        $this->routeUrl = str_replace(
          trim($remove_prefix, "/"),
          "",
          $this->routeUrl
        );
      }

      // Remove leading and ending "/" and multiple slashes
      $this->routeUrl = trim(
        CAT_Helper_Directory::sanitizePath($this->routeUrl),
        "/"
      );
      return [$this->routeUrl, $this->routeQuery];
    } // end function initRoute()

    /**
     *
     */
    protected static function order($entryIDs = [])
    {
      $counter = count($entryIDs);
      if ($counter > 0) {
        foreach ($entryIDs as $entry) {
          self::$db->query(
            "UPDATE `:prefix:mod_blackNewsEntry` " .
              "SET `position` = :position " .
              "WHERE `entryID` = :entryID",
            [
              "entryID" => $entry,
              "position" => $counter--,
            ]
          );
        }
      }
      return true;
    }

    /**
     *
     */
    public function modify()
    {
      global $parser, $section_id;

      $this->setIDs($section_id);

      // Reset parserValues
      $this->parserValues = [];

      // Check if catGallery is installed
      if (CAT_Helper_Addons::isModuleInstalled("cc_catgallery")) {
        $this->setParserValue(
          "isCatGallery",
          CAT_Helper_Addons::isModuleInstalled("cc_catgallery"),
          true
        );
        $gal = [];

        // Get all children pages using catGallery
        $getGal = self::$db->query(
          "SELECT DISTINCT main.`gallery_id`, opt.`value` as 'title' FROM `:prefix:mod_cc_catgallery` main " .
            "LEFT JOIN `:prefix:mod_cc_catgallery_options` opt " .
            "ON opt.`gallery_id` = main.`gallery_id` " .
            "WHERE main.`section_id` IN " .
            "(SELECT `section_id` FROM `:prefix:sections` se LEFT JOIN `:prefix:pages` pa ON pa.`page_id` = se.`page_id` WHERE pa.`parent`= :parent ) " .
            "AND opt.`name` = 'title' ORDER BY main.`gallery_id` DESC",
          [
            "parent" => $this->page_id,
          ]
        );

        if ($getGal && $getGal->rowCount() > 0) {
          while (!false == ($id = $getGal->fetch())) {
            $gal[$id["gallery_id"]] = $id["title"];
          }
        }

        $this->setParserValue("galleries", $gal);
      }

      $this->setParserValue("htaccess", $this->generateHTACCESS());

      $this->setParserValue("options", $this->getOption(), true);

      $this->setParserValue("sections", $this->getAllNewsSections(), true);

      $this->setParserValue("entries", $this->getOverview(true), true);

      $this->setParserValue("categories", $this->getCategories(), true);

      // ToDo: wird von einer include-Variante auf eine andere geswitcht, bleibt die Option setNews bestehen! Zusätzlich variante auf include... untersuchen!
      if (
        isset($this->parserValues["options"]["setNews"]) &&
        $this->parserValues["options"]["setNews"] != $this->section_id
      ) {
        $this->setParserValue(
          "categories",
          $this->getCategories($this->parserValues["options"]["setNews"]),
          true
        );
      }

      $this->setParserValue("usergroups", CAT_Users::getGroups(), true);
      $getGroupMembers = isset($this->parserValues["options"]["usergroup"])
        ? $this->parserValues["options"]["usergroup"]
        : 1;
      $this->setParserValue("users", CAT_Users::getMembers($getGroupMembers));

      if (
        file_exists(
          CAT_PATH .
            "/modules/" .
            static::$directory .
            "/modify/" .
            $this->getVariant() .
            "/modify.php"
        )
      ) {
        include CAT_PATH .
          "/modules/" .
          static::$directory .
          "/modify/" .
          $this->getVariant() .
          "/modify.php";
      } elseif (
        file_exists(
          CAT_PATH .
            "/modules/" .
            static::$directory .
            "/modify/default/modify.php"
        )
      ) {
        include CAT_PATH .
          "/modules/" .
          static::$directory .
          "/modify/default/modify.php";
      }

      $parser->setPath(
        CAT_PATH .
          "/modules/" .
          static::$directory .
          "/templates/" .
          $this->getVariant()
      );
      $parser->setFallbackPath(
        CAT_PATH . "/modules/" . static::$directory . "/templates/default"
      );

      #if( !self::$parsed )
      $parser->output($this->template, $this->getParserValue());

      #self::$parsed = true;
    }

    /**
     *
     */
    public function setParserValue($name = null, $value = null, $reset = false)
    {
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

    /**
     *
     */
    public function save()
    {
      if (CAT_Helper_Validate::sanitizePost("_cat_ajax") == 1) {
        header("Content-type: application/json");
        $backend = CAT_Backend::getInstance("Pages", "pages_modify", false);
      } else {
        $backend = CAT_Backend::getInstance("Pages", "pages_modify");
      }

      $backend->updateWhenModified();

      $action = CAT_Helper_Validate::sanitizePost("action");
      $return = [];
      $this->setIDs();

      if (CAT_Helper_Validate::sanitizePost("entryID")) {
        $entryObj = new blackNewsEntry(
          CAT_Helper_Validate::sanitizePost("entryID")
        );
      }

      switch ($action) {
        case "setSkin":
          $return = $this->setOption(
            "variant",
            CAT_Helper_Validate::sanitizePost("variant")
          );
          break;
        case "get":
          $return = $entryObj->getEntry();
          break;
        case "add":
          $return = blackNewsEntry::addEntry(
            CAT_Helper_Validate::sanitizePost("section_id")
          );
          break;
        case "copy":
          $return = $entryObj->copyEntry();
          break;
        case "publish":
          $return = $entryObj->publishEntry();
          break;
        case "remove":
          $return = $entryObj->removeEntry();
          break;
        case "saveOptions":
          $return = $this->saveOptions();
          $return["message"] = $backend->lang()->translate("Options saved");
          break;
        case "orderEntries":
          $return = [
            "message" => "Einträge sortiert",
            "success" => self::order(
              CAT_Helper_Validate::sanitizePost("positions")
            ),
          ];
          break;
        case "uploadIMG":
          if (
            isset($_FILES["bNimage"]["name"]) &&
            $_FILES["bNimage"]["name"] != ""
          ) {
            $return = [
              "message" => $backend
                ->lang()
                ->translate("Image uploaded successfully!"),
              "success" => $entryObj->saveImage($_FILES),
            ];
          } else {
            $ajax_return = [
              "message" => $backend->lang()->translate("No images to upload"),
              "success" => false,
            ];
          }
          break;
        case "removeIMG":
          /*$deleted	= blackNewsEntry::removeImage();
          $return	= array(
            'message'	=> $deleted === true
              ? $lang->translate( 'Image deleted successfully!' )
              : $lang->translate( 'An error occoured!' ),
            'success'	=> $deleted
          );*/
          $return = [
            "message" => "delete",
            "success" => true,
          ];
          break;

        default:
          // save
          $return = $entryObj->saveEntry();
          break;
      }

      if (CAT_Helper_Validate::sanitizePost("_cat_ajax") == 1) {
        print json_encode($return);
        exit();
      } else {
        $backend->print_success(
          isset($return["message"])
            ? $return["message"]
            : $backend->lang()->translate("Saved successfully"),
          CAT_ADMIN_URL . "/pages/modify.php?page_id=" . $this->page_id
        );
      }
    }
    /**
     *
     */
    public static function checkNewsInSection(int $pageID): bool
    {
      $result = self::$db->query(
        "SELECT `entryID` " .
          "FROM `:prefix:mod_blackNewsEntry` bn, `:prefix:sections` sec " .
          "WHERE sec.`page_id` = :page_id " .
          'AND sec.`module`="blacknews" ' .
          "AND sec.`section_id` = bn.`section_id`",
        [
          "page_id" => $pageID,
        ]
      );
      $id = [];
      if ($result && $result->rowCount() > 0) {
        while (false !== ($option = $result->fetch())) {
          $id[] = $option["entryID"];
        }
      }
      return count($id) > 0 ? true : false;
    }

    /**
     *
     */
    public static function uninstall()
    {
      $errors = self::sqlProcess(
        $CAT_PATH . "/modules/" . static::$directory . "/inc/db/uninstall.sql"
      );
      return $errors;
    }

    /**
     *
     */
    public static function upgrade()
    {
      // TODO: implement here
    }

    public function generateHTACCESS(): string
    {
      $start =
        "
########## Begin - BlackNews - redirect - SectionID " . (int) $this->section_id;
      $hint = "
########## Automatically generated! Do not change the following lines!";
      $end =
        "
########## End - BlackNews - redirect - SectionID " . (int) $this->section_id;

      $entry =
        "
# 
RewriteCond %{REQUEST_URI} !" .
        $this->getPermalink() .
        "\.php
RewriteRule ^" .
        $this->getPermalink() .
        "/(.*)$ " .
        $this->getPermalink() .
        ".php?q=$1 [QSA,L]
# ";
      return $start . $hint . $entry . $end;
    }
  }
  if (!class_exists("blackNewsEntry", false)) {
    require_once dirname(__FILE__) . "/class.blackNewsEntry.php";
  }
  blackNews::init();
}
