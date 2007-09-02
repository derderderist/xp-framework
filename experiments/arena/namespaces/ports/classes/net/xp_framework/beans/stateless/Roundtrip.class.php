<?php
/* This file is part of the XP framework
 *
 * $Id: Roundtrip.class.php 8971 2006-12-27 15:27:10Z friebe $
 */

  namespace net::xp_framework::beans::stateless;

  ::uses('remote.beans.RemoteInterface');

  /**
   * Remote interface for xp/demo/Roundtrip
   *
   * @purpose  EASC Client stub
   */
  interface Roundtrip extends remote::beans::RemoteInterface {

    /**
     * EchoString method
     *
     * @param   string arg1
     * @return  string
     */
    public function echoString($arg1);

    /**
     * EchoInt method
     *
     * @param   integer arg1
     * @return  integer
     */
    public function echoInt($arg1);

    /**
     * EchoDouble method
     *
     * @param   double arg1
     * @return  double
     */
    public function echoDouble($arg1);

    /**
     * EchoBool method
     *
     * @param   boolean arg1
     * @return  boolean
     */
    public function echoBool($arg1);

    /**
     * EchoNull method
     *
     * @param   java.lang.Object arg1
     * @return  java.lang.Object
     */
    public function echoNull($arg1);

    /**
     * EchoDate method
     *
     * @param   util.Date arg1
     * @return  util.Date
     */
    public function echoDate($arg1);

    /**
     * EchoHash method
     *
     * @param   array<mixed, mixed> arg1
     * @return  array<mixed, mixed>
     */
    public function echoHash($arg1);

    /**
     * EchoArrayList method
     *
     * @param   lang.types.ArrayList arg1
     * @return  lang.types.ArrayList
     */
    public function echoArray($arg1);

  }
?>