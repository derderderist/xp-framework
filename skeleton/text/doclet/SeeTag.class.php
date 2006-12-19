<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('text.doclet.Tag');

  /**
   * Represents a user-defined cross-reference to related documentation.
   *
   * @see      xp://Tag
   * @purpose  Tag
   */
  class SeeTag extends Tag {
    var
      $scheme  = '',
      $urn     = '';
    
    /**
     * Constructor
     *
     * @access  public
     * @param   string name
     * @param   string text
     * @param   string scheme
     * @param   string urn
     */
    function __construct($name, $text, $scheme, $urn) {
      parent::__construct($name, $text);
      $this->scheme= $scheme;
      $this->urn= $urn;
    }
  }
?>
