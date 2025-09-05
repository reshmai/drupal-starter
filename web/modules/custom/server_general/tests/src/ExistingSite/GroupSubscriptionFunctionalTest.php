<?php

namespace Drupal\Tests\server_general\ExistingSite;

use Drupal\node\Entity\Node;
use Drupal\og\Og;
use Drupal\user\Entity\User;
use Drupal\user\Entity\Role;



/**
 * Tests group subscription functionality.
 *
 * @group server_general
 */
class GroupSubscriptionFunctionalTest extends ServerGeneralTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = ['node', 'user', 'og', 'server_general'];

  /**
   * The test user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $testUser;

  /**
   * The group node.
   *
   * @var \Drupal\node\NodeInterface
   */
  protected $groupNode;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    // Example: give "authenticated" users the permission.
    $role = Role::load('authenticated');
    $role->grantPermission('subscribe to group');
    $role->save();

    $this->testUser = User::create([
    'name' => $this->randomMachineName(),
    'mail' => $this->randomMachineName() . '@example.com',
    'status' => 1,
    ]);
    $this->testUser->save();


    // Create a Group node.
    $this->groupNode = Node::create([
    // Your group content type machine name.
      'type' => 'group',
      'title' => 'Test Group',
    ]);
    $this->groupNode->save();

    // // Register the node as a group in OG.
    // Og::groupTypeManager()->addGroup('node', 'group');
  }

  /**
   * Tests that a user sees the greeting message and can subscribe.
   */
  public function testSubscribeMessageAndMembership() {
    // Log in as the test user.
    $this->drupalLogin($this->testUser);

    // Visit the group node.
    $this->drupalGet($this->groupNode->toUrl());

    // Check that the greeting/subscribe message appears.
    $this->assertSession()->pageTextContains('Hi ' . $this->testUser->getDisplayName() . ', click here if you would like to subscribe to this group called ' . $this->groupNode->label() . '.');

    // Find and click the subscribe link.
    $link = $this->getSession()->getPage()->findLink('here');
    $this->assertNotNull($link, 'Subscribe link is present.');
    $link->click();

    // Should be redirected back to the group node page.
    $this->assertSession()->addressEquals($this->groupNode->toUrl()->toString());

    // Verify that the user is now a member of the group.
    $membership = Og::getMembership($this->groupNode, $this->testUser);
    $this->assertNotNull($membership, 'User successfully subscribed to the group.');
  }

}
