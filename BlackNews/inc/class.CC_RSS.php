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

/**
 *
 */
class CC_SEOUrl
{
  /**
   *
   */
  public function __construct()
  {
  }

  /**
   * @var void
   */
  private static $instance = null;
  private $seoPath;
  private $seoUrl;
  private $fileName;

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
   * get all offers from database
   *
   * @access public
   * @param  string/array  $id - id/ids of offer
   * @param  string  $output - if table to print - default false
   * @return array()
   *
   **/
  public function setRSSCounter()
  {
    $getOption = self::getOptions("rss_counter");
    $this->rss_counter = $getOption > 0 ? $getOption : 10;

    return $this->rss_counter;
  } // end setEPP()

  /**
   * This method creates the rss-xml
   *
   * @access public
   * @param  string  directory to start with
   * @return void
   *
   **/
  public function createRSS()
  {
    // Prevent default index.php from beeing overwritten
    if ($this->getOptions("permalink") == "") {
      return false;
    }

    $create_dir = CAT_PATH . $this->getOptions("permalink");

    if (file_exists($create_dir . "/rss.xml")) {
      unlink($create_dir . "/rss.xml");
    }

    if (file_exists($create_dir) && ($handle = dir($create_dir))) {
      $fh = fopen($create_dir . "/rss.xml", "w");
      fwrite($fh, $this->_rss_file_code());
      fclose($fh);

      $handle->close();
      return true;
    } else {
      return false;
    }
  } // end function createRSS()

  /**
   *
   *
   *
   *
   **/
  private function validateRSScontent($data)
  {
    $newData = str_replace("&nbsp;", " ", $data);
    return "<![CDATA[ " . utf8_encode($newData) . " ]]>";
  } // end validateRSScontent()

  /**
   *
   *
   *
   *
   **/
  private function getRSSitems()
  {
    $this->RSS = [
      "items" => $this->getEntries(true, true, true),

      "RSStitle" => $this->getOptions("rss_title"),
      "RSSlink" => $this->sanitizeURL(CAT_URL . $this->getOptions("permalink")),
      "RSSdescription" => $this->validateRSScontent(
        $this->getOptions("rss_description")
      ),
      "RSSpubDate" => date("D, d M Y H:i:s O", time()),
      "RSSlastDate" => date("D, d M Y H:i:s O", time()),
      "RSSdocs" =>
        $this->sanitizeURL(CAT_URL . $this->getOptions("permalink")) .
        "/rss.xml",
      "RSSEdit" => "",
      "copyright" => WEBSITE_TITLE,
      "managingEditor" =>
        SERVER_EMAIL . " (" . CATMAILER_DEFAULT_SENDERNAME . ")",
      "webMaster" => SERVER_EMAIL . " (" . CATMAILER_DEFAULT_SENDERNAME . ")",
    ];

    return $this->RSS["items"];
  } // end getRSSitems()

  /**
   *
   *
   *
   *
   **/
  private function _rss_file_code()
  {
    $RSScontent = "";
    //print_r($this->getRSSitems());
    foreach ($this->getRSSitems() as $item) {
      $RSScontent .= sprintf(
        '
		<item> 
			<title>%s</title>
			<description>%s</description>
			<content:encoded>%s</content:encoded>
			<guid>%s</guid>
			<link>%s</link>
			<pubDate>%s</pubDate>
			<dc:creator>%s</dc:creator>
			<category>[BETA]</category>
		</item>
',
        $this->validateRSScontent($item["title"]),
        $item["short"],
        $item["image_url"] != ""
          ? $this->validateRSScontent(
            '<a href="' .
              CAT_URL .
              $this->getOptions("permalink") .
              $this->createTitleURL($item["title"]) .
              '"><img src="' .
              $item["image_url"] .
              '"></img></a>' .
              $item["content"]
          )
          : $this->validateRSScontent($item["content"]),
        CAT_URL .
          $this->getOptions("permalink") .
          $this->getEntryOptions("url", $item["news_id"]),
        CAT_URL .
          $this->getOptions("permalink") .
          $this->getEntryOptions("url", $item["news_id"]), //$item['link'],
        date("D, d M Y H:i:s O", $item["updated_TS"]),
        $item["created_by"]
      );
    }
    return sprintf(
      '<?xml version="1.0" encoding="ISO-8859-1" ?>
<rss version="2.0" 
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<title>%s</title>
		<link>%s</link>
		<description>%s</description>
		<language>de-de</language>
		<pubDate>%s</pubDate>
		<lastBuildDate>%s</lastBuildDate>
		<docs>%s</docs>
		<managingEditor>%s</managingEditor>
		<generator>BlackCat CMS</generator>
		<webMaster>%s</webMaster>
		<copyright>Copyright (C) %s</copyright>
		<atom:link href="%s" rel="self" type="application/rss+xml" />
		%s
	</channel>
</rss>
',
      $this->RSS["RSStitle"],
      $this->RSS["RSSlink"],
      $this->RSS["RSSdescription"],
      $this->RSS["RSSpubDate"],
      $this->RSS["RSSlastDate"],
      $this->RSS["RSSdocs"],
      $this->RSS["managingEditor"],
      $this->RSS["webMaster"],
      $this->RSS["copyright"],
      $this->RSS["RSSdocs"],
      $RSScontent
    );
  } // end _rss_file_code()
}
