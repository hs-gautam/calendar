<?php
/**
 * @file
 * Contains \Drupal\calendar\DateFieldWrapper.
 */


namespace Drupal\calendar;

use Drupal\Core\Field\FieldItemList;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeItem;

class DateFieldWrapper {


  /**
   * @var \Drupal\Core\Field\FieldItemList
   */
  protected $fieldItemList;

  /**
   * DateFieldWrapper constructor.
   */
  public function __construct(FieldItemList $fieldItemList) {
    $this->fieldItemList = $fieldItemList;
  }

  /**
   * @return \DateTime
   */
  public function getStartDate() {
    $date = new \DateTime();
    return $date->setTimestamp($this->getStartTimeStamp());
  }

  /**
   * @return \DateTime
   */
  public function getEndDate() {
    $date = new \DateTime();
    return $date->setTimestamp($this->getEndTimeStamp());
  }

  /**
   * @return int
   */
  protected function getStartTimeStamp() {
    $value = $this->fieldItemList->getValue()[0]['value'];
    $field_def = $this->fieldItemList->getFieldDefinition();
    $field_type = $field_def->getFieldStorageDefinition()->getType();
    if ($field_type == 'datetime') {
      /** @var \Drupal/datetime\Plugin\FieldType\DateTimeItem $field */
      $field = $this->fieldItemList->get(0);
      // Set User's Timezone
      $field->date->setTimezone(timezone_open(drupal_get_user_timezone()));
      // Format to timestamp.
      return $field->date->format('U');
    }
    return (int)$value;
  }

  /**
   * @return int
   */
  protected function getEndTimeStamp() {
    return $this->getStartTimeStamp();
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return $this->fieldItemList->isEmpty();
  }
}
