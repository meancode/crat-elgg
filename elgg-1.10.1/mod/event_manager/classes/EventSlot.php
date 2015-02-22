<?php 
/**
 * EventRegistrationQuestion
 *
 * @package EventManager
 *
 */
class EventSlot extends ElggObject {
	const SUBTYPE = "eventslot";
	
	/**
	 * initializes the default class attributes
	 *
	 * @return void
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes["subtype"] = self::SUBTYPE;
	}
	
	/**
	 * Counts the number of registrations
	 *
	 * @return boolean|int
	 */
	public function countRegistrations() {
		$old_ia = elgg_set_ignore_access(true);
		
		$result = elgg_get_entities_from_relationship(array(
			"relationship" => EVENT_MANAGER_RELATION_SLOT_REGISTRATION,
			"relationship_guid" => $this->getGUID(),
			"inverse_relationship" => true,
			"count" => true,
			"site_guids" => false
		));
		
		elgg_set_ignore_access($old_ia);
		
		return $result;
	}
	
	/**
	 * Returns if the slot has a spot left
	 * 
	 * @return boolean
	 */
	public function hasSpotsLeft() {
		$result = false;
		
		if (empty($this->max_attendees) || (($this->max_attendees - $this->countRegistrations()) > 0)) {
			$result = true;
		}
		
		return $result;
	}
	
	/**
	 * Returns the users waiting for this slot
	 * 
	 * @param boolean $count if a count should be returned, or the entity
	 * 
	 * @return boolean|int|array
	 */
	public function getWaitingUsers($count = false) {
		$old_ia = elgg_set_ignore_access(true);
		
		if ($count) {
			$result = $this->countEntitiesFromRelationship(EVENT_MANAGER_RELATION_SLOT_REGISTRATION_WAITINGLIST, true);
		} else {
			$result = $this->getEntitiesFromRelationship(EVENT_MANAGER_RELATION_SLOT_REGISTRATION_WAITINGLIST, true);
		}
		
		elgg_set_ignore_access($old_ia);
		
		return $result;
	}

	/**
	 * Checks if a given user is waiting for this slot
	 * 
	 * @param string $user_guid guid of the user
	 * 
	 * @return ElggRelationship|false
	 */
	public function isUserWaiting($user_guid = null) {
		if (empty($user_guid)) {
			$user_guid = elgg_get_logged_in_user_guid();
		}
		
		return check_entity_relationship($user_guid, EVENT_MANAGER_RELATION_SLOT_REGISTRATION_WAITINGLIST, $this->getGUID());
	}
}
