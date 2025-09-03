<?php

namespace Drupal\server_general\Controller;

use Drupal\user\Entity\User;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\og\Og;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 *
 */
class GroupController extends ControllerBase {

  /**
   *
   */
  public function subscribe(NodeInterface $group) {
    $account = $this->currentUser();
    $user = User::load($account->id()); 

    $membership_manager = \Drupal::service('og.membership_manager');

    if (!$membership_manager->isMember($group, $user)) {
      $membership_manager->createMembership($group, $user)->save();
      $this->messenger()->addMessage($this->t('You have been subscribed to the group.'));
    }
    else {
      $this->messenger()->addMessage($this->t('You are already a member of this group.'));
    }

    return new RedirectResponse($group->toUrl()->toString());
  }

}
