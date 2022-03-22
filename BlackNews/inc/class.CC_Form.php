<?php

/**
 *
 */
class CC_Form extends blackNews
{
  /**
   * @var void
   */
  protected static $instance = null;
  protected static $entryID = null;
  protected static $fieldID = null;
  private static $value = [];
  private static $missing = [];

  private static $timestamp = null;
  private static $timeToFill = 8;
  private static $check_bot = 0;

  public function __construct()
  {
    self::$check_bot = CAT_Helper_Validate::getInstance()->sanitizePost(
      "see_" . self::getTime()
    );
  }
  public function __destruct()
  {
  }

  public static function getInstance()
  {
    if (!self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public static function getTime()
  {
    self::$timestamp =
      CAT_Helper_Validate::getInstance()->sanitizePost("bot_temp", "numeric") ==
      ""
        ? self::setNewTime()
        : self::setTime();

    return self::$timestamp;
  }

  private static function checkTime()
  {
    if (!self::$timestamp) {
      self::getTime();
    }
    if (self::$timestamp > 0 && self::$timestamp < time() - self::$timeToFill) {
      return true;
    } else {
      return false;
    }
  }

  private static function setNewTime()
  {
    return rand(1000, 9999) . time();
  }

  private static function setTime()
  {
    return intval(
      substr(
        trim(
          CAT_Helper_Validate::getInstance()->sanitizePost(
            "bot_temp",
            "numeric"
          )
        ),
        4
      )
    );
  }

  /**
   *
   */

  public function setFieldID($fieldID)
  {
    $this->fieldID = $fieldID;
    return self::$instance;
  }

  /**
   *
   */

  public function getFieldID()
  {
    return $this->fieldID;
  }

  /**
   *
   */

  public function getEntryID()
  {
    return $this->entryID;
  }

  /**
   *
   */

  public function setEntryID($entryID)
  {
    $this->entryID = $entryID;
    return self::$instance;
  }

  /**
   *
   */
  public function getFields($fieldID = null)
  {
    if (!$this->entryID) {
      return false;
    }
    $this->fields = [];
    // Get all options
    $result = self::$db->query(
      'SELECT * FROM `:prefix:mod_blackNewsForm`
				WHERE `entryID` = :entryID
				ORDER BY `position` DESC',
      [
        "entryID" => $this->entryID,
      ]
    );
    if (isset($result) && $result->rowCount() > 0) {
      while (false !== ($field = $result->fetch())) {
        $this->fields[$field["fieldID"]] = $field;
      }
    }
    if ($fieldID) {
      return $this->fields[$fieldID];
    }
    return $this->fields;
  }

  /**
   *
   */
  public function addField($val = [])
  {
    if (!$this->entryID || count($val) == 0) {
      return false;
    }
    // set all info to table
    if (
      self::$db->query(
        "INSERT INTO `:prefix:mod_blackNewsForm` " .
          "SET `entryID` = :entryID, `name` = :name, `type` = :type, `required` = :required, " .
          "`value` = :value, `placeholder` = :placeholder, `width` = :width",
        [
          "entryID" => $this->entryID,
          "name" => $val["name"],
          "type" => $val["type"],
          "required" =>
            !$val["required"] || $val["required"] == "false" ? 0 : 1,
          "value" => $val["value"],
          "placeholder" => $val["placeholder"],
          "width" => $val["width"],
        ]
      )
    ) {
      $this->fieldID = self::$db->lastInsertId();
      return true;
    } else {
      return false;
    }
  }

  /**
   *
   */
  public function saveField($val = [])
  {
    if (!$this->fieldID) {
      return false;
    }
    if (count($val) > 2) {
      // set all info to table
      if (
        self::$db->query(
          "UPDATE `:prefix:mod_blackNewsForm` " .
            "SET `name` = :name, `type` = :type, `required` = :required, " .
            "`value` = :value, `placeholder` = :placeholder, `width` = :width " .
            "WHERE `fieldID` = :fieldID",
          [
            "fieldID" => $this->fieldID,
            "name" => $val["name"],
            "type" => $val["type"],
            "required" =>
              !$val["required"] || $val["required"] == "false" ? 0 : 1,
            "value" => $val["value"],
            "placeholder" => $val["placeholder"],
            "width" => $val["width"],
          ]
        )
      ) {
        return true;
      }
    } elseif (
      in_array($val["field"], [
        "type",
        "required",
        "value",
        "placeholder",
        "width",
        "position",
      ])
    ) {
      // Set single info to table
      if (
        self::$db->query(
          "UPDATE `:prefix:mod_blackNewsForm` " .
            "SET `" .
            $val["field"] .
            "` = :value " .
            "WHERE `fieldID` = :fieldID",
          [
            "fieldID" => $this->fieldID,
            "value" => $val["value"],
          ]
        )
      ) {
        return true;
      }
    }
    return false;
  }

  /**
   *
   */
  public static function removeField($fieldID = null)
  {
    if (!$fieldID) {
      return false;
    } elseif (
      self::$db->query(
        'DELETE FROM `:prefix:mod_blackNewsForm`
				WHERE `fieldID` = :fieldID',
        [
          "fieldID" => $fieldID,
        ]
      )
    ) {
      return true;
    }
    return false;
  }

  /**
   *
   */
  public static function order($fieldIDs = [])
  {
    $counter = count($fieldIDs);
    if ($counter > 0) {
      $obj = self::getInstance();
      foreach ($fieldIDs as $field) {
        $obj->setFieldID($field);
        $obj->saveField([
          "field" => "position",
          "value" => $counter--,
        ]);
      }
    }
  }

  /**
   *
   */
  public function setMail($send = true)
  {
    // Only for BC 1.x ... remove with support for 2.x only
    $val = CAT_Helper_Validate::getInstance();

    foreach ($this->getFields() as $field) {
      $getVal = $val->sanitizePost("field_" . $field["fieldID"]);
      // check if field is requiredd and if value is send
      if ($field["required"]) {
        // IF no value is send
        if ($getVal == "") {
          $this->missing[$field["fieldID"]] = $field["fieldID"];
          continue;
        }
        // IF type is Email
        if ($field["type"] == 5 && !$val->validate_email($getVal)) {
          $this->missing[$field["fieldID"]] = $field["fieldID"];
          continue;
        }
      }
      if (self::checkEmailvalue($getVal)) {
        $this->value[$field["fieldID"]] = htmlspecialchars(strip_tags($getVal));
        // Specials for ik
        switch ($field["name"]) {
          case "Anrede":
            self::setParserValue("anrede", $getVal);
            break;
          case "E-Mail":
            self::setParserValue("email", $getVal);
            break;
          case "Nachname":
            if ($getVal != "") {
              self::setParserValue("nachname", $getVal);
            }
            break;
        }
      } else {
        $this->missing[$field["fieldID"]] = $field["fieldID"];
      }
    }

    self::setParserValue("value", $this->value);
    self::setParserValue("missing", $this->missing);

    if (!count($this->missing)) {
      self::setParserValue("SERVER_EMAIL", SERVER_EMAIL);
      self::setParserValue(
        "CATMAILER_DEFAULT_SENDERNAME",
        CATMAILER_DEFAULT_SENDERNAME
      );
      if ($send === true) {
        $this->sendMail();
      }
    }
  } // end setMail();

  /**
   *
   */
  public function sendMail()
  {
    global $parser;
    $MailHelper = CAT_Helper_Mail::getInstance("Swift");

    $path =
      CAT_PATH .
      "/modules/" .
      parent::$directory .
      "/templates/" .
      parent::getVariant() .
      "/mail/";

    $parser->setPath($path);

    self::setParserValue(
      "IP",
      empty($_SERVER["HTTP_X_FORWARDED_FOR"])
        ? $_SERVER["REMOTE_ADDR"]
        : $_SERVER["HTTP_X_FORWARDED_FOR"]
    );
    self::setParserValue("BROWSER", $_SERVER["HTTP_USER_AGENT"]);

    $value = self::getParserValue();

    // Email an Kunden
    $MailHelper->sendMail(
      SERVER_EMAIL,
      $value["email"],
      $value["entry"]["options"]["formularMailTitelKunde"],
      $parser->get("mail_sender.tpl", $value),
      CATMAILER_DEFAULT_SENDERNAME,
      $parser->get("mail_sender_html.tpl", $value)
    );
    // Email an Anbieter
    $MailHelper->sendMail(
      $value["email"],
      SERVER_EMAIL,
      $value["entry"]["options"]["formularMailTitelAnbieter"],
      $parser->get("mail_provider.tpl", $value),
      CATMAILER_DEFAULT_SENDERNAME,
      $parser->get("mail_provider_html.tpl", $value)
    );

    self::setParserValue("sendMail", true);
  } // end sendMail();

  private function getMailer()
  {
  }

  /**
   *
   */
  public function getHTML($template = "formularFormItem", $for = "backend")
  {
    global $parser, $section_id;

    $return = "";

    switch ($for) {
      case "backend":
        $folder = "modify";
        break;
      case "mail":
        $folder = "mail";
        break;
      default:
        $folder = "view";
        break;
    }

    $parser->setPath(
      CAT_PATH .
        "/modules/" .
        static::$directory .
        "/templates/" .
        parent::getVariant() .
        "/" .
        $folder .
        "/"
    );
    $parser->setFallbackPath(
      CAT_PATH .
        "/modules/" .
        static::$directory .
        "/templates/default/" .
        $folder .
        "/"
    );

    $template = "formularFormItem"; #$for == 'backend' ? 'modify' : 'view' EMAIL_KUNDE, EMAIL_ANBIETER;
    foreach ($this->getFields() as $field) {
      $return .= $parser->get($template, ["field" => $field]);
    }
    return $return;
  }

  public function isSend()
  {
    if (
      CAT_Helper_Validate::getInstance()->sanitizePost("bot_temp", "numeric") >
      0
    ) {
      return true;
    } else {
      return false;
    }
  }

  public function checkBot()
  {
    if (self::checkTime() && !self::$check_bot) {
      return true;
    } else {
      return false;
    }
  }

  /**
   *
   * @access public
   * @return
   **/
  private static function checkEmailvalue($val)
  {
    if (
      preg_match(
        "/(to:|cc:|bcc:|from:|subject:|reply-to:|content-type:|MIME-Version:|multipart\/mixed|Content-Transfer-Encoding:)/ims",
        $val
      )
    ) {
      return false;
    }
    if (
      preg_match(
        "/%0A|%0D|%00|\\0|%09|\\t|%01|%02|%03|%04|%05|%06|%07|%08|%09|%0B|%0C|%0E|%0F|%10|%11|%12|%13/i",
        $val
      )
    ) {
      return false;
    }
    return true;
  }
}
