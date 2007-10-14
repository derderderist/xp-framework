<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 
  uses(
    'peer.ldap.LDAPClient',
    'peer.ldap.LDAPSearchResult',
    'unittest.TestCase'
  );

  /**
   * Test LDAP client
   *
   * @see      xp://peer.ldap.LDAPClient
   * @purpose  Unit Test
   */
  class LDAPResultTest extends TestCase {
    public
      $lc      = NULL;
      
    /**
     * Setup function
     *
     */
    public function setUp() {
      $this->lc= new LDAPClient('ldap.openldap.org');
      try {
        $this->lc->setOption(LDAP_OPT_PROTOCOL_VERSION, 3);
        $this->lc->connect();
        $this->lc->bind();
      } catch (ConnectException $e) {
        throw (new PrerequisitesNotMetError(
          PREREQUISITE_INITFAILED,
          $e,
          array('connect', 'ldapv3://ldap.openldap.org')
        ));
      } catch (LDAPException $e) {
        throw (new PrerequisitesNotMetError(
          PREREQUISITE_INITFAILED,
          $e,
          array('bind', 'ldapv3://ldap.openldap.org')
        ));
      }
    }
    
    /**
     * Tear down this test case.
     *
     */
    public function tearDown() {
      $this->lc->close();
    }

    /**
     * Test empty resultset
     *
     */
    #[@test, @expect('lang.IllegalStateException')]
    public function testEmptyResult() {
      $r= new LDAPSearchResult();
      $r->getNextEntry();
    }

    /**
     * Test LDAP search
     *
     */
    #[@test]
    public function testSearch() {
      $res= $this->lc->search(
        'ou=People,dc=OpenLDAP,dc=Org', 
        '(objectClass=*)'
      );
      $this->assertClass($res, 'peer.ldap.LDAPSearchResult');
      $this->assertNotEquals(0, $res->numEntries());
      $entry= $res->getFirstEntry();
      $this->assertClass($entry, 'peer.ldap.LDAPEntry');
      return $entry;
    }

    /**
     * Test call of nextEntry() when there are
     * no more resultsets 
     *
     */
    #[@test]
    public function testNoMoreResults() {
      $res= $this->lc->search(
        'cn=Directory Manager,dc=OpenLDAP,dc=Org', 
        '(objectClass=*)'
      );
      $this->assertEquals(1, $res->numEntries());
      $entry= $res->getFirstEntry();
      $this->assertFalse($res->getNextEntry());
    }

    /**
     * Multiple calls of getFirstEntry()
     *
     */
    #[@test]
    public function testFirstEntry() {
      $res= $this->lc->search(
        'ou=People,dc=OpenLDAP,dc=Org',
        '(objectClass=person)'
      );
      
      // First entry
      $this->assertEquals('Kurt', $res->getFirstEntry()->getAttribute('givenname', 0));
      
      // Second entry
      $this->assertEquals('Howard', $res->getNextEntry()->getAttribute('givenname', 0));
      
      // Jump to first entry
      $this->assertEquals('Pagan', $res->getFirstEntry()->getAttribute('description', 0));
      $this->assertEquals('KDZ', $res->getFirstEntry()->getAttribute('initials', 0));
      
      // Get second entry again
      $this->assertEquals('Howard', $res->getNextEntry()->getAttribute('givenname', 0));
      
      // Third entry
      $this->assertEquals('Stig', $res->getNextEntry()->getAttribute('givenname', 0));
    }

    /**
     * Test to get first entry on first call
     * of getNextEntry()
     *
     */
    #[@test]
    public function ommitFirstEntry() {
      $res= $this->lc->search(
        'ou=People,dc=OpenLDAP,dc=Org',
        '(objectClass=person)'
      );
      
      $this->assertEquals('Kurt', $res->getNextEntry()->getAttribute('givenname', 0));
    }

    /**
     * Test ldap entry object
     *
     */
    #[@test]
    public function testEntry() {
      $res= $this->lc->search(
        'ou=People,dc=OpenLDAP,dc=Org',
        '(objectClass=person)'
      );
      
      $entry= $res->getFirstEntry();

      $this->assertClass($entry, 'peer.ldap.LDAPEntry');
      $this->assertNotEmpty($entry->getDN());
      $this->assertArray($attributes= $entry->getAttributes());
    }
  }
?>