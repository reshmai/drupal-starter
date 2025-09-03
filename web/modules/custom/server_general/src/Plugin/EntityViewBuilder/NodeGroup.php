<?php

namespace Drupal\server_general\Plugin\EntityViewBuilder;

use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Drupal\server_general\EntityViewBuilder\NodeViewBuilderAbstract;
use Drupal\user\Entity\User;

/**
 * @EntityViewBuilder(
 *   id = "node.group",
 *   label = @Translation("Node - Group"),
 *   description = @Translation("Custom view builder for Group content type.")
 * )
 */
class NodeGroup extends NodeViewBuilderAbstract {

  /**
   * Build Full view mode.
   */
  public function buildFull(array $build, NodeInterface $entity) {
    // Get the current logged-in user account.
    $account = \Drupal::currentUser();
    $user = User::load($account->id());

    // Only proceed if user is logged in.
    if (!$user) {
      return $build;
    }

    /** @var \Drupal\og\MembershipManagerInterface $membership_manager */
    $membership_manager = \Drupal::service('og.membership_manager');

    /** @var \Drupal\og\OgAccessInterface $og_access */
    $og_access = \Drupal::service('og.access');

    // Check if user is already a member of the group.
    if (!$membership_manager->isMember($entity, $user)) {
      // Check if user can subscribe to this group.
      $access = $og_access->userAccess($entity, 'subscribe', $user);

      if ($access->isAllowed()) {
        $build['subscribe_message'] = [
          '#markup' => $this->t(
            'Hi @name, click <a href=":url">here</a> if you would like to subscribe to this group called @label.',
            [
              '@name' => $user->getDisplayName(),
              ':url' => Url::fromRoute('server_general.group_subscribe', ['group' => $entity->id()])->toString(),
              '@label' => $entity->label(),
            ]
          ),
        ];
      }
    }else{
        $build['subscribe_message'] = [
          '#markup' => $this->t(
            'Hi @name, You are already a member of this group called @label.',
            [
              '@name' => $user->getDisplayName(),
              '@label' => $entity->label(),
            ]
          ),
        ];
    }

    // Return the original build array plus our subscribe message.
    return $build;
  }

}
